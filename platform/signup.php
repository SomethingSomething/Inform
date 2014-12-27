<?php
error_reporting(0);
$sql_host = "192.168.1.14";
$sql_usr = "root";
$sql_pass = "root";
$sql_db = "inform";
// Create connection
$conn = new mysqli($sql_host, $sql_usr, $sql_pass, $sql_db);
// Check connection
if ($conn->connect_error) {
	echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
} 

$email = mysqli_real_escape_string($conn, $_POST["email"]);
$pass = mysqli_real_escape_string($conn, $_POST["pass"]);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$news = mysqli_real_escape_string($conn, $_POST['news']);

$check = $conn->query("SELECT id FROM logins WHERE email = '$email'");
if ($check->num_rows > 0) {
	echo json_encode(array("login_valid" => "taken", "error" => "Email already taken."));
	die();
}

$salt = hash("sha1", rand(10000,99999));

$hashedpass = hash('whirlpool', $salt.$pass.$salt);
$hashedpass = hash('whirlpool', $hashedpass);
$hashedpass = hash('whirlpool', $hashedpass);

$sql = "INSERT INTO logins (email, password, salt, name, news_emails) VALUES ('$email', '$hashedpass', '$salt', '$name', '$news')";
//echo $sql."<br>";
$result = $conn->query($sql);

$sql_a = "SELECT * FROM logins WHERE email = '$email'";
//echo $sql."<br>";
$result_a = $conn->query($sql_a);



if ($result_a->num_rows > 0) {
    // output data of each row
    while($row = $result_a->fetch_assoc()) {
    	$activation_token = substr(hash('whirlpool', time() * time() * rand(10000,99999)), 0,5);
		$activation_expire = (time() + (30*60));
    	$prep_sql = "INSERT INTO sendersettings (userid) VALUES ('".$row['id']."'); INSERT INTO activations (token, user_id, expires, used) VALUES ('$activation_token', '".$row['id']."', '$activation_expire', 0);";

			if(mysqli_multi_query($conn,$prep_sql)) {
			
			$activation_message = file_get_contents('confirm_message.txt');
			
			$act_replace = array('[custname]','[aid]');
			$act_with = array($name, $activation_token);
			
			$activation_message_filled = str_replace($act_replace, $act_with, $activation_message);
			
			$subject = "Account Activation";
			$headers = "From: activations@saga.systems";
			
			$url = 'http://cnspc2.net/mailer/index.php';
			$data = array('to' => $email, 'subject' => $subject, 'message' => $activation_message_filled, 'from' => 'activations@saga.systems');

			// use key 'http' even if you send the request to https://...
			$options = array(
  			  'http' => array(
      		  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      		  'method'  => 'POST',
      		  'content' => http_build_query($data),
   			 ),
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);

			//mail($email,$subject,$activation_message_filled,$headers);
    
    	$data = array("valid" => "signup");
    	
    	echo json_encode($data);
    	}
    }
} else {
    echo json_encode(array("login_valid" => "no"));
}
$conn->close();
?>