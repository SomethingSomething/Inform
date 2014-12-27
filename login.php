<?php
sleep(1);
$email = $_POST["email"];
$pass = $_POST["pass"];
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

$sql_a = "SELECT salt FROM logins WHERE email = '$email'";
//echo $sql."<br>";
$result_a = $conn->query($sql_a);

if ($result_a->num_rows > 0) {
    // output data of each row
    while($row = $result_a->fetch_assoc()) {
    	$salt = $row["salt"];
    }
}



$hashedpass = hash('whirlpool', $salt.$pass.$salt);
$hashedpass = hash('whirlpool', $hashedpass);
$hashedpass = hash('whirlpool', $hashedpass);

$sql = "SELECT * FROM logins WHERE email = '$email' AND password = '$hashedpass'";
//echo $sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	
    	
    	session_start();
    	$sessstr = rand(10000,99999)."__".(time() * time());
    	$_SESSION["sessid"] = hash('whirlpool', $sessstr);
    	
    	$session_id = $_SESSION["sessid"];
    	
    	$expire = (time() + (60*60*24));
    	$client = $_SERVER['REMOTE_ADDR'];
    	$begin = (time() - 1);
    	
    	//$expire = 0;
    	
    	$data = array("valid" => "true","sessionID" => $_SESSION["sessid"], "begin" => time(), "end" => $expire);
    	
    	setcookie("valid", "true", (time() + (60*60*24)));
    	setcookie("sessionID", $_SESSION["sessid"], (time() + (60*60*24)));
    	setcookie("begin", time(), (time() + (60*60*24)));
    	setcookie("end", $expire, (time() + (60*60*24)));
    	setcookie("usrid", $row["id"], (time() + (60*60*24)));
    	
    	$sql_b = "INSERT INTO sessions (session_id, session_begin, session_end, session_ip) VALUES ('$session_id','$begin','$expire','$client')";

		$result_b = $conn->query($sql_b);
    	
    	echo json_encode($data);
    	
    	//echo $row["id"]."<br>";
    	//echo $row["firstname"]."<br>";
    	//echo $row["lastname"]."<br>";
    	//echo $row["email"]."<br>";
    }
} else {
    echo json_encode(array("login_valid" => "no"));
}
$conn->close();
?>