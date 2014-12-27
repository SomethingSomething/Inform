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



// Create connection
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 

//get form variables
$pal = mysqli_real_escape_string($conn, $_POST["predef1name"]);
$pbl = mysqli_real_escape_string($conn, $_POST["predef2name"]);
$pcl = mysqli_real_escape_string($conn, $_POST["predef3name"]);
$pdl = mysqli_real_escape_string($conn, $_POST["predef4name"]);
$pel = mysqli_real_escape_string($conn, $_POST["predef5name"]);

$pac = mysqli_real_escape_string($conn, $_POST["predef1"]);
$pbc = mysqli_real_escape_string($conn, $_POST["predef2"]);
$pcc = mysqli_real_escape_string($conn, $_POST["predef3"]);
$pdc = mysqli_real_escape_string($conn, $_POST["predef4"]);
$pec = mysqli_real_escape_string($conn, $_POST["predef5"]);

$sql = "UPDATE sendersettings SET m1t = '$pal', m1b = '$pac', m2t = '$pbl', m2b = '$pbc', m3t = '$pcl', m3b = '$pcc', m4t = '$pdl', m4b = '$pdc', m5t = '$pel', m5b = '$pec' WHERE userid = $usrID";
//echo $sql."<br>";
$result = $conn->query($sql);



if ($result > 0) {
    echo json_encode(array("valid" => "true", "usrid" => $usrID));
} else {
    echo json_encode(array("valid" => "false", "usrid" => $usrID));
}
$conn->close();
?>