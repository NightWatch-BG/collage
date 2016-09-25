<?php    
	// INSERT with named parameters
    $host = "localhost";
	$username = "username";
	$password = "";
	$dbname ="collage";

	// Create connection
	//$conn = new mysqli($host, $username, $password, $dbname);
	$conn = new Mysqli('localhost','root','','collage');
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>