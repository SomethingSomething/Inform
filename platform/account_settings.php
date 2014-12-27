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

$sql = "SELECT * FROM logins WHERE id = '$usrID'";
//echo $sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	
    	$email = $row["email"];
    	$lastlogin = $row["lastlogin"];
    	$lastip = $row["loginIP"];
    	
    }
} else {
    //echo json_encode(array("valid" => "no"));
}
$conn->close();
?>

<h3 class="amber">Account Settings</h3>
<h4>System Status: <span class="green">OK</h4>

<?php echo settings_menu(); ?>

<br><br>

<form action="/inform/platform/saveaccountsettings.php" method="POST" id="accountsettingssave" onsubmit="saveData('accountsettingssave');">
	<input type="email" class="predef_label wideform" placeholder="Login E-Mail" name="email" value="<?php echo $email; ?>" length="100" maxlength="256"><br>
	<input type="password" class="predef_label wideform" placeholder="Old Password" name="pass_old"><br>
	<input type="password" class="predef_label wideform" id="clientaccountpassword" placeholder="New Password" name="pass_new"><br>
	<input type="password" class="predef_label wideform" id="clientaccountpasswordconf" placeholder="Confirm New Password" name="pass_new_conf"><br>
	<input type="submit" value="Save" class="button">
</form>

<br><br>

<p>Your last login was from <strong><?php echo $lastip; ?></strong> and occurred at <strong><?php echo $lastlogin; ?></strong>.</p>

<div class="infobox" id="settings_predef_info">Press "Save" to save settings.</div>

<div id="setting_warning"></div>