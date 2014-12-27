<?php
error_reporting(0);
if(!($_GET['message'])) {
$message = "";
}
?>

<html>
<head>
<title>Sign Up - Informer</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<link rel="stylesheet" text="text.css" href="/inform/css/misc.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
html {
font-family: "Segoe UI",Frutiger,"Frutiger Linotype","Dejavu Sans","Helvetica Neue",Arial,sans-serif;
background-image:url('/inform/img/background.png');
}
#title {
position:absolute;
left:0px;
top:100px;
width:100%;
text-align:center;
}
#subtitle {
position:absolute;
left:0px;
top:143px;
width:100%;
text-align:center;
}
#status {
position:absolute;
left:0px;
top:30%;
width:100%;
text-align:center;
font-size:50px;
margin-top:-67px;
}
#loader {
position:absolute;
top:50%;
left:50%;
width:64px;
height:64px;
margin-left:-32px;
fill:rgba(52, 152, 219,1.0);
}
#loadbar {
position:absolute;
left:0px;
top:0px;
width:100%;
height:29px;
font-size:20px;
color:rgba(241, 196, 15,1.0);
background-color:rgba(41, 128, 185,1.0);
text-align:center;
z-index:100;
}
#subload {
position:absolute;
left:0px;
top:0px;
width:100%;
height:29px;
font-size:20px;
color:rgba(241, 196, 15,1.0);
background-color:rgba(192, 57, 43,1.0);
text-align:center;
z-index:99;
}
.text {
width:512px;
font-size:0.5em;
border:0px;
text-align:center;
background-color:transparent;
}
.error {
color:red;
}
p {
font-size:0.4em;
}
#price_table {
position:absolute;
left:50%;
width:256px;
margin-left:-128px;
}
#go {
position:absolute;
bottom:10px;
left:50%;
margin-left:-60px;
}
@media all and (max-width: 640px) {
	.text {
		width:100%;
		font-size:0.5em;
		border:0px;
		text-align:center;
		background-color:transparent;
		}
	#price_table {
		position:relative;
		left:50%;
		width:256px;
		margin-left:-128px;
	}
	#status {
		position:absolute;
		left:0px;
		top:30%;
		right:0px;
	}
	#go {
		position:absolute;
		bottom:-15%;
		left:50%;
		margin-left:-60px;
	}
	html {
		height:120%;
	}
}
</style>
</head>
<body>
<h1 id="title">Sign Up</h1>
<h3 id="subtitle">INFORMER<br><span class="error"><?php echo $_GET['message']; ?></span></h3>
<div id="loadbar">Sign Up</div>
<div id="subload"></div>
<div id="status">
	<h4>Billing Details:</h4>
	<p>We bill by the notification, as you send more notifications, they become cheaper. See the table below for more details.</p>
	<table border="0" id="price_table">
<thead>
	<tr>
		<th><strong>Notifications</strong></th>
		<th><strong>Price per Notification</strong></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>0-1000</td>
		<td>$0.01</td>
	</tr>
	<tr>
		<td>1001-10000</td>
		<td>$0.0075</td>
	</tr>
	<tr>
		<td>10001-20000</td>
		<td>$0.005</td>
	</tr>
	<tr>
		<td>20001-50000</td>
		<td>$0.004</td>
	</tr>
	<tr>
		<td>50001 - &infin;</td>
		<td>$0.002</td>
	</tr>
</tbody>
<tfoot>

</tfoot>
</table>

</div>
<button id="go" class="button">Agree</button>
<script>
$("#go").click(function() {
	window.location.replace("/inform/console.php");
});
</script>

</body>
</html>