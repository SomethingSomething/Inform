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
$oldpass = $_POST['pass_old'];
$newpass_a = $_POST['pass_new'];
$newpass_b = $_POST['pass_new_conf'];
$email = $_POST['email'];

// Create connection
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 

$sql_a = "SELECT * FROM logins WHERE id = '$usrID'";
//echo $sql."<br>";
$result_a = $conn->query($sql_a);

if ($result_a->num_rows > 0) {
    // output data of each row
    while($row = $result_a->fetch_assoc()) {
    	$dbpass = $row["password"];
    	$salt = $row["salt"];
    }
}
$changepass = 0;
$hashedpass = hash('whirlpool', $salt.$newpass_a.$salt);
$hashedpass = hash('whirlpool', $hashedpass);
$hashedpass = hash('whirlpool', $hashedpass);

$oldhashedpass = hash('whirlpool', $salt.$oldpass.$salt);
$oldhashedpass = hash('whirlpool', $oldhashedpass);
$oldhashedpass = hash('whirlpool', $oldhashedpass);

if(strlen($newpass_a) > 0 && $newpass_a == $newpass_b) {
	$sql = "UPDATE logins SET email = '$email', password = '$hashedpass' WHERE id = $usrID AND password = '$oldhashedpass'";
	$changepass = 1;
} else {
	$sql = "UPDATE logins SET email = '$email' WHERE id = $usrID";
}


//echo $sql."<br>";


if(!($oldhashedpass == $dbpass)) {
	echo json_encode(array("valid" => "false", "usrid" => $usrID, "error" => "Incorrect Password"));
	die();
} else {
	if(!(preg_match('/[!@#$%*a-zA-Z0-9]{8,}/',$newpass_a) && preg_match_all('/[0-9]/',$newpass_a) >= 2))	{
    	echo json_encode(array("valid" => "false", "usrid" => $usrID, "error" => "Password too weak."));
    	die();
	}
}
$result = $conn->query($sql);


if ($result > 0 && $changepass == 1 && $oldhashedpass = $dbpass) {
    echo json_encode(array("valid" => "true", "usrid" => $usrID));
} else {
    echo json_encode(array("valid" => "false", "usrid" => $usrID));
}
$conn->close();
?>
