<?php
$sql_host = "192.168.1.14";
$sql_usr = "root";
$sql_pass = "root";
$sql_db = "inform";
?>
<html>
<head>
<title>Loading...</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="../js/jStorage.js"></script>
<script src="../js/PxLoader.js"></script>
<script src="../js/PxLoaderImage.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" text="text.css" href="/inform/css/misc.css">
<style>
html {
font-family: "Segoe UI",Frutiger,"Frutiger Linotype","Dejavu Sans","Helvetica Neue",Arial,sans-serif;
overflow:hidden;
background-image:url('../img/background.png');
cursor:progress;
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
#log {
position:absolute;
top:65%;
left:0px;
width:100%;
text-align:center;
bottom:0px;
}
.logchild {
display:none;
}
#logitems
</style>
</head>
<body>
<h1 id="title">INFORMER</h1>
<h3 id="subtitle">Saga Systems</h3>

<div id="loadbar"></div>
<div id="subload"></div>
<div id="loaderwrap" style="display:none;">
<div id="status">Logging Out...</div>
<svg id="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="white">
  <path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>
  <path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">
    <animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />
  </path>
</svg>
</div>



<div class="hidden">
<img src="img/4bars.png" alt="">
<img src="img/3bars.png" alt="">
<img src="img/2bars.png" alt="">
<img src="img/1bar.png" alt="">

</div>

<?php
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 
session_start();
$sessid = $_COOKIE['sessionID'];
$sql_b = "UPDATE sessions SET logout = 1 WHERE session_id = '$sessid'";
$result_b = $conn->query($sql_b);


unset($_SESSION['sessid']);
setcookie("valid", "false");
setcookie("sessionID", null, time() + 3600);
setcookie("sessid", null, time() + 3600);
setcookie("begin", null, time() + 3600);
setcookie("end", null, time() + 3600);
setcookie("usrid", null, time() + 3600);
$_SESSION['sessid'] = null;
session_unset(); 
session_destroy();
?>

<script>
$.jStorage.set("sessid", "");
$.jStorage.set("begin", "");
$.jStorage.set("end","<?php echo (time() - 3600); ?>");
window.setTimeout(function() {window.location.replace("/inform?message=You%20have%20logged%20out")}, 2000);
$("#loaderwrap").fadeIn("slow");
</script>
</body>
</html>