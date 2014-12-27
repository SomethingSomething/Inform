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

$sql = "SELECT * FROM sendersettings WHERE userid = '$usrID'";
//echo $sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$checked = "";
    	if($row["enablesounds"] == 1) {
    		$checked = "checked";
    	}
    	
    	$cs_a = '';
    	$cs_b = '';
    	$cs_c = '';
    	
    	if($row["colourscheme"] == 1) {
    		$cs_a = 'checked';
    		$cs_b = '';
    		$cs_c = '';
    	} else if ($row["colourscheme"] == 2) {
    		$cs_a = '';
    		$cs_b = 'checked';
    		$cs_c = '';
    	} else {
    		$cs_a = '';
    		$cs_b = '';
    		$cs_c = 'checked';
    	}
    	
    	//echo $row["id"]."<br>";
    	//echo $row["firstname"]."<br>";
    	//echo $row["lastname"]."<br>";
    	//echo $row["email"]."<br>";
    }
} else {
    //echo json_encode(array("valid" => "no"));
}
$conn->close();
?>

<h3 class="amber">Client Settings</h3>
<h4>System Status: <span class="green">OK</h4>

<?php echo settings_menu(); ?>

<form action="/inform/platform/saveclientsettings.php" method="POST" id="clientsettingssave" onsubmit="saveData('clientsettingssave');">
	
	<br><input type="checkbox" id="client_settings_sounds" name="sounds" value="1" <?php echo $checked; ?>><label for="client_settings_sounds">Enable Sounds</label>
	<fieldset class="noborder">
		<p class="legend">Colour Scheme</p>
		<input type="radio" name="colour" value="1" id="client_settings_colours_1" <?php echo $cs_a; ?>><label for="client_settings_colours_1">Blue</label><br>
		<input type="radio" name="colour" value="2" id="client_settings_colours_2" <?php echo $cs_b; ?>><label for="client_settings_colours_2">Red</label><br>
		<input type="radio" name="colour" value="3" id="client_settings_colours_3" <?php echo $cs_c; ?>><label for="client_settings_colours_3">Dark</label><br>
	</fieldset>
	
<input type="submit" value="Save" class="button savebtn">
	
</form>

<div class="infobox" id="settings_predef_info">Press "Save" to save settings.</div>

<div id="setting_warning"></div>