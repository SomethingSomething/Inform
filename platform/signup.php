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
    
    
    	$prep_sql = "INSERT INTO sendersettings (userid) VALUES ('".$row['id']."');";

			if(mysqli_multi_query($conn,$prep_sql)) {
    
    	$data = array("valid" => "signup");
    	
    	echo json_encode($data);
    	}
    }
} else {
    echo json_encode(array("login_valid" => "no"));
}
$conn->close();
?>