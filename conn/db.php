<?php
// $servername = "localhost";
// $username = "root"; 
// $password = "";
// $database = "jjck_realty_db";

$servername = "b4svrhz1pxumygusk30q-mysql.services.clever-cloud.com";
$username = "uvxa2eya4zuwpvll"; 
$password = "Q2SvUshnXekmsts9M2as";
$database = "b4svrhz1pxumygusk30q";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

// Close connection
// $conn->close();
?>