$.ajaxSetup ({
    cache: false
});

function getPing() {
var sendDate = (new Date()).getTime();
$.ajax({
    //type: "GET", //with response body
    type: "HEAD", //only headers
    url: "http://systems.cycloneapp.info/cyclone/audio.php?warning=PowerOutages[TEST]",
    success: function(){

        var receiveDate = (new Date()).getTime();

        var responsetime = receiveDate - sendDate;
        
        
        
        if(responsetime < 300) {
        	$("#responsetime").html(responsetime);
        	$("#pingtime").attr("src", "/inform/img/4bars.png");
        } else if (responsetime < 500) {
        	$("#responsetime").html(responsetime);
        	$("#pingtime").attr("src", "/inform/img/3bars.png");
        } else if (responsetime < 1000) {
        	$("#responsetime").html("<span class='amber'>"+responsetime+"</span>");
        	$("#pingtime").attr("src", "/inform/img/2bars.png");
        } else if (responsetime >= 1000) {
        	$("#pingtime").attr("src", "/inform/img/1bar.png");
        	$("#responsetime").html("<span class='red'>"+responsetime+"</span>");
        	warning("It's taking a while to connect to the server...");
        }

    }
});
}

function logoutPrep() {
	presentModal("Logout", "Are you sure you want to log out?", true,"Log Out", "green", "logout");
}

function closeModal() {
	$("#modal_dialog").hide();
	$("#modal_actions").html("");
}

function presentModal(title,message,allowclose,actiontitle,actioncolour,action) {
	closeModal();
	$("#modal_title").text(title);
	$("#modal_message").text(message);
	if(allowclose == true) {
		$("#modal_actions").append("<div class='modal_action redbg' onclick='closeModal();'>Close</div>");
	}
	
	if(action) {
		$("#modal_actions").append("<div onclick='"+action+"();' class='modal_action " + actioncolour +"bg'>"+actiontitle+"</div>");
	}
	$("#modal_dialog").show();
}

function loadMainWindow() {
	showLoader();
	$("#main_content").load("platform/main.php", function (responseText, textStatus, req) {
		hideLoader();
		if (textStatus == "error") {
          console.log("Oh noes...");
          ajaxError(req);
        }
        postAjaxJS();
        var content = $("#msg_send_predef_sel").val();
		console.log("Getting MSG Preview");
		console.log(content);
		$("#predef_msg_preview").text(content);
	});	
}

function highlight() {
	$(this).parent().addClass('highlight');
}
function unhlighlight() {
	$(this).parent().removeClass('highlight');
}

$('.highlight_on_hover').hover(function () {
	console.log("highlighting");
	$(this).parent().toggleClass('highlight');
});

function ajaxError(request) {
	warning("There was an error loading the requested module...", true);
}


function showLoader() {
	$("#popup_bg, #popup_loader").fadeIn("slow");
}

function hideLoader() {
	$("#popup_bg, #popup_loader").fadeOut("slow");
}



function viewPage(page,titlelock,query) {

	$("#main_content").fadeOut("slow");
	if(query) {
		var queryext = "?" + query;
	} else {
		var queryext = "";
	}
	$("#ajax_status").text("Currently Loading: /inform/platform/" + page + ".php"+queryext);

	var str = page;
	str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    	return letter.toUpperCase();
	});
	
	if(!titlelock) {
	updateTitle(str);
	}
	showLoader();
	$("#main_content").load("platform/"+page+".php", function (responseText, textStatus, req) {
		hideLoader();
		setTimeout(function(){$("#ajax_status").text("");},1000);
		$("#main_content").fadeIn("slow");
		if (textStatus == "error") {
          console.log("Oh noes...");
          ajaxError(req);
          $("#ajax_status").text("There was an error loading: /inform/platform/" + page + ".php");
          setTimeout(function(){$("#ajax_status").text("");},1000);
        }
        reloadStylesheet();
		postAjaxJS();
	});	
	
	
}

String.prototype.hashCode = function(){
    if (Array.prototype.reduce){
        return this.split("").reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0);              
    } 
    var hash = 0;
    if (this.length === 0) return hash;
    for (var i = 0; i < this.length; i++) {
        var character  = this.charCodeAt(i);
        hash  = ((hash<<5)-hash)+character;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

function reloadStylesheet() {
	var queryString = '?reload=' + new Date().getTime();
    $('link[rel="stylesheet"]').each(function () {
        this.href = this.href.replace(/\?.*|$/, queryString);
    });
}

$("#settings").click(function() {
	viewPage("settings");
});

function hideFooter() {
	$("#footer, #footer_toggle").animate({"bottom":"-=200px"});
	footer = false;
}

$("a").hover(function() {
	$("#ajax_status").text($(this).attr("href"));
}, function() {
	$("#ajax_status").text("");
});

function updateTitle(value) {
	$("title").text(value+" - Inform");
	$("#title").text("Inform - " +value);
}
function restoreTitle() {

}

function playWarning() {
	$("#warningsound").trigger("play");
}

function settingWarning(message) {
	$("#setting_warning").text(message);
}

function saveData(id) {
	event.preventDefault();
	$("#ajax_status").text("Saving...");
	$("#settings_predef_info").text("Saving...").removeClass("redbg").removeClass("greenbg").addClass("amberbg").css('background-image', 'url("/inform/img/spinner.svg")');
	setTimeout(function(){$("#ajax_status").text("");},1000);
	console.log("will submit #" + id);
	$.post( $("#" + id).attr("action"), $("#" + id).serialize(), function(data) {
			//console.log(data);
			//var obj = jQuery.parseJSON(data);
			var errorstr = "";
			if(data.error) {
				var errorstr = data.error;
			}
			if(data.valid == "true") {
				$("#settings_predef_info").text("Saved.").removeClass("amberbg").removeClass("redbg").addClass("greenbg").css('background-image', 'url("/inform/img/icon_info.png")');
				settingWarning("");
			} else {
				$("#settings_predef_info").text("There was an error saving...").removeClass("greenbg").addClass("redbg").css('background-image', 'url("/inform/img/icon_error.png")');
				settingWarning("There was an error saving your data. It's been saved to your browser just in case :) ["+errorstr+"]");
			}
         	console.log(data);
       },
       'json' // I expect a JSON response
    ).error(function() {
    	$("#settings_predef_info").text("There was an error autosaving...").removeClass("amberbg").removeClass("greenbg").addClass("redbg").css('background-image', 'url("/inform/img/icon_error.png")');
    	settingWarning("There was an error saving your data. It's been saved to your browser just in case :)");
    	
    	});
    
}

function logout() {
	window.location.replace("/inform/logout");
}

function postAjaxJS() {
	var content = $("#msg_send_predef_sel").val();
	console.log("Getting MSG Preview");
	console.log(content);
	$("#predef_msg_preview").text(content);
$("#msg_send_predef_sel").on('change', function() {
	var content = $(this).val();
	console.log("Getting MSG Preview");
	console.log(content);
	$("#predef_msg_preview").text(content);
});

$(".autosave").keyup(function() {
	console.log("saving...");
	saveData($(this).parent().attr("id"));
});
$(".savebtn").click(function() {
	console.log("saving...");
	saveData($(this).parent().attr("id"));
});

$(".settings_menu_item").click(function() {
	var load = $(this).data("href");
	viewPage(load,true);
	$(this).css("color", "#2c3e50");
});

$("#clientaccountpasswordconf").keyup(function() {
	if($("#clientaccountpassword").val() != $("#clientaccountpasswordconf").val()) {
		$("#clientaccountpasswordconf").css("background-color","#e74c3c");
	} else {
		$("#clientaccountpasswordconf").css("background-color","transparent");
	}
});

$("#customerDeviceID").keyup(function() {
	if($(this).val().length == 5) {
		$(this).addClass("amberbg").removeClass("redbg").removeClass("greenbg");
		$.post( "/inform/platform/checkdeviceid.php", { id: $(this).val()})
  			.done(function( data ) {
  				console.log(data);
    			var obj = jQuery.parseJSON(data);
    			console.log(obj);
    			console.log(obj.valid);
    			if(obj.valid == "true") {
    				$("#editCustomerDeviceID").show();
    				console.log("adding bg");
    				$("#customerDeviceID").removeClass("amberbg").removeClass("redbg").addClass("greenbg");
    				$("#customerDeviceID").attr("readonly", "readonly");
    			}
  			});
	} else {
		$(this).removeClass("amberbg").addClass("redbg").removeClass("greenbg");
	}	
});
$("#editCustomerDeviceID").click(function() {
	$("#customerDeviceID").val("").removeAttr("readonly").removeClass("amberbg").removeClass("greenbg").addClass("redbg").focus();
});
}

setInterval(function() {
getPing();
},10000);

function warning(message, sound) {
	playWarning();
	$("#warning").text(message).slideDown("slow");
	updateTitle("Warning");
	if(sound) {
		playWarning();
	}
	setTimeout(function(){$("#warning").slideUp("slow");updateTitle("Demo Page");},5000);
}

function init() {
hideLoader();
$("#warning").hide();
getPing();
loadMainWindow();
$("#footer_toggle").click(function() {
	if($(this).data("up") == "true") {
		$("#footer, #footer_toggle").animate({"bottom":"-=200px"}).data("up", "false");
		$("#footer_toggle").text("Show");
	} else {
		$("#footer, #footer_toggle").animate({"bottom":"+=200px"}).data("up", "true");
		$("#footer_toggle").text("Hide");
	}
});
}

setInterval(function () {
$.get( "/inform/platform/checksession.php", function( data ) {
	var obj = jQuery.parseJSON(data);
	console.log(obj.valid);
	if(obj.valid != "true") {
		alert("Your session has expired. You will now be redirected to the login page.");
		window.location.replace("/inform");
	}
});
}, 10000); // refresh every 10000 milliseconds


