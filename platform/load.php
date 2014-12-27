<?php
ob_implicit_flush(true);
ob_end_flush();
$things = array("Logging In...", "Setting up Session", "Downlaoding Images", "Downloading CSS", "Downloading Scripts", "Checking Session", "Caching Pages", "Done!");

foreach($things as &$thing) {
	echo $thing.'<br>';
	sleep(1);
}
?>