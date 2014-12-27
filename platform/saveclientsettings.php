<?php
include("i:/inform/platform/php_config.php");
$sessionID = $_COOKIE["sessionID"];
$sessionValid = $_COOKIE["valid"];
$begin = $_COOKIE["begin"];
$end = $_COOKIE["end"];

if(time() >= $end || !($sessionID)) {
	echo '<h1>Session IS NOT valid</h1><META http-equiv="refresh" content="5;URL=/inform">'; 
	die();
}

$usrID = $_COOKIE["usrid"];

//get form variables
$colour = $_POST['colour'];
$sound = $_POST['sounds'];

// Create connection
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE sendersettings SET enablesounds = '$sound', colourscheme = '$colour' WHERE userid = $usrID";
//echo $sql."<br>";
$result = $conn->query($sql);



if ($result > 0) {
    echo json_encode(array("valid" => "true", "usrid" => $usrID));
} else {
    echo json_encode(array("valid" => "false", "usrid" => $usrID));
}
$conn->close();
?>