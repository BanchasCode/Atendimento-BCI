<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bnkms";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	header('location:server_down.php');
} 
else{
	// echo "Connection Established";
}

?>