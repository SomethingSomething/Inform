<?php
sleep(1);
header('cache-control: no-cache,no-store,must-revalidate'); // HTTP 1.1.
header('pragma: no-cache'); // HTTP 1.0.
header('expires: 0'); // Proxies.
error_reporting(0);
$sql_settings = array("192.168.1.14", "root", "root", "inform");
$sql_host = "192.168.1.14";
$sql_usr = "root";
$sql_pass = "root";
$sql_db = "inform";
function settings_menu() {
return '<span class="settings_menu_item" data-href="client_settings">Client Settings</span>
<span class="settings_menu_item" data-href="settings">Preset Notifications</span>
<span class="settings_menu_item" data-href="account_settings">Account Settings</span>
<span class="settings_menu_item" data-href="payment_settings">Payment Settings</span>';
}


$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$sessionID = $_COOKIE["sessionID"];
$sessionValid = $_COOKIE["valid"];
$begin = $_COOKIE["begin"];
$end = $_COOKIE["end"];
$userid = $_COOKIE["usrid"];

if(time() >= $end || !($sessionID) || ($sessionValid == "false")) {
	header("Location: /inform?message=Invalid%20Session");
	//echo '<!DOCTYPE html><html><head><title>Redirecting...</title></head><body><h1>Invalid Session... ('.$actual_link.') Redirecting</h1>'.print_r($_COOKIE).'</body></html>';
	die();
}

// Create connection
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 

$sql_a = "SELECT * FROM sessions WHERE session_id = '$sessionID'";
//echo $sql."<br>";
$result_a = $conn->query($sql_a);

if ($result_a->num_rows > 0) {
    // output data of each row
    while($row = $result_a->fetch_assoc()) {
    	$begin = $row["session_begin"];
    	$end = $row["session_end"];
    	$ip = $row["session_ip"];
    	$logout = $row["logout"];
    }
}

$sql_b = "SELECT confirmed FROM logins WHERE id = $userid";
//echo $sql."<br>";
$result_b = $conn->query($sql_b);

if ($result_b->num_rows > 0) {
    // output data of each row
    while($row = $result_b->fetch_assoc()) {
		$activated = $row["confirmed"];
    }
}

if($activated != 1) {
header("Location: http://devbrain.sagabrain.com/inform/signup/splash_2.php?message=Please%20activate%20your%20account%20before%20logging%20in.");
die();
} 

$client = $_SERVER['REMOTE_ADDR'];

if(($begin > time()) || ($end < time()) || ($ip != $client) || ($logout == 1)) {
	header("Location: /inform?message=Invalid%20Session");
	//echo '<!DOCTYPE html><html><head><title>Redirecting...</title></head><body><h1>Invalid Session... ('.$actual_link.') Redirecting</h1>'.print_r($_COOKIE).'<br>'.$begin.'<br>'.$end.'<br>'.$client.'<br>'.$logout.'</body></html>';
	die();
}

$conn->close();
?>