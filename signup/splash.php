<?php
error_reporting(0);
if(!($_GET['message'])) {
$message = "";
}
?>
<script src="../js/jStorage.js"></script>
<script src="../js/PxLoader.js"></script>
<script src="../js/PxLoaderImage.js"></script>
<html>
<head>
<title>Sign Up - Informer</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<link rel="stylesheet" text="text.css" href="/inform/css/misc.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
html {
font-family: "Segoe UI",Frutiger,"Frutiger Linotype","Dejavu Sans","Helvetica Neue",Arial,sans-serif;
background-image:url('/inform/img/background.png');
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
top:30%;
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
<h1 id="title">Sign Up</h1>
<h3 id="subtitle">INFORMER<br><span class="error"><?php echo $_GET['message']; ?></span></h3>
<div id="loadbar">Sign Up</div>
<div id="subload"></div>
<div id="status">
	<form action="/inform/platform/signup_2.php" id="login" method="POST">
		<p><input required class="text" type="text" name="name" placeholder="Full Name"></p>
		<p><input required class="text" type="password" id="pass_a" value="<?php echo $_POST['pass']; ?>" name="pass" placeholder="Password"></p>
		<p><input required class="text" type="password" id="pass_b" name="pass_b" placeholder="Password (again)"></p>
		<p style="font-size:0.3em;"><input required type="checkbox" name="agree" value="true" id="termsbox"><label for="termsbox">Agree to the <a href="/inform/pages?p=terms" target="_blank">Terms and Conditions</a></label></p>
		<p style="font-size:0.3em;"><input type="checkbox" name="news" value="true" id="emailnews"><label for="emailnews">Receive Occasional NEWS E-Mails from us</label></p>
		<p style="font-size:0.3em;" class="error" id="formerr"></p>
		<p style="font-size:0.3em;"><input type="submit" id="submitbtn" class="button" value="Continue"></p>
		
		<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
	</form>
</div>

<script>
var form = $("#login");

$("#pass_a,#pass_b").keyup(function() {
	if($("#pass_a").val() == $("#pass_b").val()) {
		$("#submitbtn").fadeIn();
		$("#formerr").text("");
	} else {
		$("#submitbtn").fadeOut();
		$("#formerr").text("Your Passwords do not match.");
	}
});

function signupLogin() {
	console.log("Going to login after signup");
	 $.ajax({ // create an AJAX call...
        data: form.serialize(), // get the form data
        type: "POST", // GET or POST
        url: "/inform/login.php", // the file to call
        success: function(response) { // on success..
        console.log(response);
            var obj = jQuery.parseJSON(response);
            	if(obj.valid == "true") {
            		window.location.href = "splash_2.php";
            	} else {
            		$("html").css("cursor", "auto");
            		alert("That E-Mail has already been used.");
            		window.location.replace('/inform?message=That%20e-mail%20address%20has%20already%20been%20used.');
            		$("#status").fadeIn("slow");
            	}
        }
    });
}

$('#login').submit(function() { // catch the form's submit event
	
	event.preventDefault();
	
	$("html").css("cursor", "progress");
	$("#status").fadeOut("slow");
	
    $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: 'POST', // GET or POST
        url: '/inform/platform/signup.php', // the file to call
        success: function(response) { // on success..
        console.log(response);
            var obj = jQuery.parseJSON(response);
            	if(obj.valid == "true") {
            		
            		window.location.href = "load.php";
            	} else if(obj.valid == "taken") {
            		$("html").css("cursor", "auto");
            		alert(obj.error);
            		$("#status").fadeIn("slow");
            	} else if(obj.valid == "signup") {
            		signupLogin();
            	} else {
            		$("html").css("cursor", "auto");
            		alert("That E-Mail has already been used.");
            		window.location.replace('/inform?message=That%20e-mail%20address%20has%20already%20been%20used.');
            		$("#status").fadeIn("slow");
            	}
        }
    });
    return false; // cancel original event to prevent form submitting
});
</script>

</body>
</html>