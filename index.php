<?php
error_reporting(0);
if(!($_GET['message'])) {
$message = "";
}
?>

<html>
<head>
<title>Login - Informer</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="js/jStorage.js"></script>
<script src="js/PxLoader.js"></script>
<script src="js/PxLoaderImage.js"></script>
<link rel="stylesheet" text="text.css" href="/inform/css/misc.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
html {
font-family: "Segoe UI",Frutiger,"Frutiger Linotype","Dejavu Sans","Helvetica Neue",Arial,sans-serif;
overflow:hidden;
background-image:url('img/background.png');
}
#title {
position:absolute;
left:0px;
top:100px;
width:100%;
text-align:center;
}
#subtitle {
position:absolute;
left:0px;
top:143px;
width:100%;
text-align:center;
}
#status {
position:absolute;
left:0px;
top:50%;
width:100%;
text-align:center;
font-size:50px;
margin-top:-67px;
}
#loader {
position:absolute;
top:50%;
left:50%;
width:64px;
height:64px;
margin-left:-32px;
fill:rgba(52, 152, 219,1.0);
}
#loadbar {
position:absolute;
left:0px;
top:0px;
width:100%;
height:29px;
font-size:20px;
color:rgba(241, 196, 15,1.0);
background-color:rgba(41, 128, 185,1.0);
text-align:center;
z-index:100;
}
#subload {
position:absolute;
left:0px;
top:0px;
width:100%;
height:29px;
font-size:20px;
color:rgba(241, 196, 15,1.0);
background-color:rgba(192, 57, 43,1.0);
text-align:center;
z-index:99;
}
.text {
width:512px;
font-size:0.5em;
border:0px;
text-align:center;
background-color:transparent;
}
.error {
color:red;
}
@media all and (max-width: 640px) {
	.text {
		width:100%;
		font-size:0.5em;
		border:0px;
		text-align:center;
		background-color:transparent;
		}
}
</style>
</head>
<body>
<h1 id="title">INFORMER</h1>
<h3 id="subtitle">Saga Systems<br><span class="error"><?php echo $_GET['message']; ?></span></h3>
<div id="loadbar">Log In</div>
<div id="subload"></div>
<div id="status">
	<form action="login.php" id="login" method="POST">
		<p><input required class="text" type="email" name="email" placeholder="E-Mail"></p>
		<p><input required class="text" type="password" name="pass" placeholder="Password"></p>
	</form>
	<p style="font-size:0.3em;"><button class="button" id="loginbtn" data-action="login.php" style="margin-right:10px;">Login</button> or 
	<a href="#" data-action="platform/signup.php" id="signup" class="button" style="margin-left:10px;">Sign Up</a></p>
	
</div>

<script>
var form = $("#login");


$("#signup").click(function() {
	form.attr("action", "signup/splash.php").submit();
});



$('#loginbtn').click(function() { // catch the form's submit event
	
	event.preventDefault();
	
	$("html").css("cursor", "progress");
	$("#status").fadeOut("slow");
	
    $.ajax({ // create an AJAX call...
        data: form.serialize(), // get the form data
        type: 'POST', // GET or POST
        url: 'login.php', // the file to call
        success: function(response) { // on success..
        console.log(response);
            var obj = jQuery.parseJSON(response);
            	console.log(response);
            	if(obj.valid == "true") {
            		
            		$.jStorage.set("sessid", obj.sessionID);
            		$.jStorage.set("begin", obj.begin);
            		$.jStorage.set("end", obj.end);
            		window.location.href = "load.php";
            	} else if(obj.valid == "taken") {
            		$("html").css("cursor", "auto");
            		alert(obj.error);
            		$("#status").fadeIn("slow");
            	} else if(obj.valid == "signup") {
            		signupLogin();
            	} else if(obj.valid = "activate") {
            		window.location.replace("/inform/signup/splash_2.php?message=Please%20activate%20your%20account%20before%20logging%20in.");
            	} else {
            		$("html").css("cursor", "auto");
            		alert("Your login is invalid.");
            		$("#status").fadeIn("slow");
            	}
        }
    });
    return false; // cancel original event to prevent form submitting
});
</script>

</body>
</html>