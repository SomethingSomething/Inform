<?php
include("i:/inform/platform/php_config.php");
$t_title = "Home";
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $t_title; ?> - Inform</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="js/jStorage.js"></script>
<script src="/inform/js/main.js"></script>
<link rel="stylesheet" text="text.css" href="/inform/css/main.css">
<link rel="stylesheet" text="text.css" href="/inform/css/misc.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<audio id="warningsound" src="/inform/img/bingbong.mp3"></audio>
</head>
<body>
<!-- Start Status Bar -->
<div id="statusbar">
<img id="pingtime" src="/inform/img/4bars.png">
<div id="responsetime">--</div>
<div id="warning">Warning</div>
<div id="title">Inform - <?php echo $t_title; ?></div>
<div id="settings" onclick='viewPage("settings");' class="hover">Settings</div>
<div id="reports" class="hover">Reports</div>
<div id="home" onclick='viewPage("main");' class="hover">Home</div>
<div id="logout" onclick='logoutPrep();' class="hover">Logout</div>
</div>
<!-- End Status Bar -->
<!-- Loader Area -->
<div id="popup_bg"></div>
<svg id="popup_loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="white">
  <path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>
  <path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">
    <animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />
  </path>
</svg>
<!-- End Loader -->
<!-- Begin Modal Dialog -->
<div id="modal_dialog">
<div id="modal_title"></div>
<p id="modal_message"></p>
<div id="modal_actions"></div>
</div>
<!-- End Modal Dialog -->
<!-- Begin Content -->
<div id="content_wrap">
<div id="main_content">