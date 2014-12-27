<?php
error_reporting(0);
$sql_host = "192.168.1.14";
$sql_usr = "root";
$sql_pass = "root";
$sql_db = "inform";
// Create connection
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 

$userid = $_COOKIE['usrid'];
$sql = "SELECT * FROM activations WHERE user_id = $userid AND used = 0";
$check = $conn->query($sql);
if ($check->num_rows == 0) {
	echo json_encode(array("valid" => "expired"));
	mysqli_multi_query($conn,"DELETE FROM logins WHERE id = $userid;");
	die();
}
$ip = $_SERVER['REMOTE_ADDR'];
$token = $_POST['actid'];
$prep_sql = "UPDATE activations SET reg_ip = '$ip', used = 1 WHERE token = '$token'; UPDATE logins SET confirmed = 1 WHERE id = $userid";

if(mysqli_multi_query($conn,$prep_sql)) {
echo json_encode(array("valid" => "true"));
} else {
echo json_encode(array("valid" => "false"));
}

?>