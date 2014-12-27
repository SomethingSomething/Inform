<?php
sleep(2);
include("i:/inform/platform/php_config.php");
$sessionID = $_COOKIE["sessionID"];
$sessionValid = $_COOKIE["valid"];
$begin = $_COOKIE["begin"];
$end = $_COOKIE["end"];

if(time() >= $end || !($sessionID)) {
	$valid = "false";
} else {
	$valid = "true";
}

echo json_encode(array("valid" => $valid));
?>