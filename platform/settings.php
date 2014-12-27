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
    
    	$pal = $row["m1t"];
    	$pbl = $row["m2t"];
    	$pcl = $row["m3t"];
    	$pdl = $row["m4t"];
    	$pel = $row["m5t"];
    	
    	$pac = $row["m1b"];
    	$pbc = $row["m2b"];
    	$pcc = $row["m3b"];
    	$pdc = $row["m4b"];
    	$pec = $row["m5b"];
    	
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
<h3 class="amber">Settings</h3>
<h4>System Status: <span class="green">OK</h4>

<?php echo settings_menu(); ?>

<br><br>

<form action="/inform/platform/savesettings.php?module=predefined_messages" method="POST" id="predef">
	<input class="predef_label autosave" type="text" maxlength="50" size="50" name="predef1name" placeholder="Message 1 Title" value="<?php echo $pal; ?>">
	<textarea id="predef_a" class="autosave" placeholder="Predefined Message 1" name="predef1" rows="3" cols="50"><?php echo $pac; ?></textarea>
	
	
	<input class="predef_label autosave" type="text" maxlength="50" size="50" name="predef2name" placeholder="Message 2 Title" value="<?php echo $pbl; ?>">
	<textarea id="predef_b" class="autosave" placeholder="Predefined Message 2" name="predef2" rows="3" cols="50"><?php echo $pbc; ?></textarea>
	
	
	<input class="predef_label autosave" type="text" maxlength="50" size="50" name="predef3name" placeholder="Message 3 Title" value="<?php echo $pcl; ?>">
	<textarea id="predef_b" class="autosave" placeholder="Predefined Message 3" name="predef3" rows="3" cols="50"><?php echo $pcc; ?></textarea>
	
	
	<input class="predef_label autosave" type="text" maxlength="50" size="50" name="predef4name" placeholder="Message 4 Title" value="<?php echo $pdl; ?>">
	<textarea id="predef_b" class="autosave" placeholder="Predefined Message 4" name="predef4" rows="3" cols="50"><?php echo $pdc; ?></textarea>
	
	
	<input class="predef_label autosave" type="text" maxlength="50" size="50" name="predef5name" placeholder="Message 5 Title" value="<?php echo $pel; ?>">
	<textarea id="predef_b" class="autosave" placeholder="Predefined Message 5" name="predef5" rows="3" cols="50"><?php echo $pec; ?></textarea>
	
</form>

<div class="infobox" id="settings_predef_info">Changes are saved as you type.</div>

<div id="setting_warning"></div>