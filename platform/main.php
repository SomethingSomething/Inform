<?php
include("i:/inform/platform/php_config.php");

$usrID = $_COOKIE["usrid"];

// Create connection
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM sendersettings WHERE userid = '$usrID'";
error_log($sql);
//echo $sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    
    	$valid = 1;
    
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
<h3 class="amber">Welcome to Inform</h3>
<h4>System Status: <span class="green">OK</h4>
<p>Page generated at: <?php echo time(); ?></p>
<button class="button" onclick="loadMainWindow();">Refresh</button>
<h4>Send Message</h4>
<form action="platform/sendmessage.php" method="POST" id="sendMessageForm">
<label for="msg_send_predef_sel">Predefined Message: </label>
<select name="predef_msg" id="msg_send_predef_sel">
	<option onselect="sendMessagePredefUpdate();" value="<?php echo $pac; ?>"><?php echo $pal; ?></option>
	<option onselect="sendMessagePredefUpdate();" value="<?php echo $pbc; ?>"><?php echo $pbl; ?></option>
	<option onselect="sendMessagePredefUpdate();" value="<?php echo $pcc; ?>"><?php echo $pcl; ?></option>
	<option onselect="sendMessagePredefUpdate();" value="<?php echo $pdc; ?>"><?php echo $pdl; ?></option>
	<option onselect="sendMessagePredefUpdate();" value="<?php echo $pec; ?>"><?php echo $pel; ?></option>
</select> <span class="highlight hand" onclick="viewPage('settings', true);">Edit Messages</span>
<p>Message Preview:</p>
<textarea class="liteform" placeholder="Message" id="predef_msg_preview" name="message" rows="4" cols="50" maxlength="200"></textarea>
<input type="text" class="liteform" placeholder="Customer ID" name="cid" id="msg_send_cid">
<br>
<input type="submit" class="button" value="Send Message">
</form>