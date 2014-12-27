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
?>

<h3 class="amber">Payment Settings</h3>
<h4>System Status: <span class="green">OK</h4>

<?php echo settings_menu(); ?>

<br>
<br>

<h4>Amount owing: $173.162<sub>Tax inclusive</sub></h4>
<p>Messages Sent: 21,541</p>

<table border="0">
<h4>Pricing Details</h4>
<thead>
	<tr>
		<th><strong>Notifications</strong></th>
		<th><strong>Price per Notification</strong></th>
		<th><strong>Notifications</strong></th>
		<th><strong>Total Price</strong></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>0-1000</td>
		<td>$0.01</td>
		<td>1000</td>
		<td>$10</td>
	</tr>
	<tr>
		<td>1001-10000</td>
		<td>$0.0075</td>
		<td>9999</td>
		<td>$74.995</td>
	</tr>
	<tr>
		<td>10001-20000</td>
		<td>$0.005</td>
		<td>9999</td>
		<td>$49.995</td>
	</tr>
	<tr>
		<td>20001-50000</td>
		<td>$0.004</td>
		<td>543</td>
		<td>$2.172</td>
	</tr>
	<tr>
		<td>50001 - &infin;</td>
		<td>$0.002</td>
		<td>0</td>
		<td>$0.00</td>
	</tr>
<tfoot>
    <tr>
      <th colspan="3">Grand Total</th>
      <th>$173.162</th>
    </tr>
  </tfoot>
</tbody>
</table>
<p>Payment Due: 25/12/14 by 5PM AEST (NO DST)</p>
<br>
<p>An invoice will be e-mailed to <strong>accounts@shop.com</strong> 48 hours prior to when payment is due.</p>
<br>
<div class="infobox amberbg" id="settings_predef_info">Your payment is due soon.</div>
<div id="setting_warning"></div>