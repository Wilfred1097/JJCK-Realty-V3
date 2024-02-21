<?php
$servername = "localhost"; // Replace 'localhost' with your database host if necessary
$username = "root"; // Replace 'your_username' with your MySQL username
$password = ""; // Replace 'your_password' with your MySQL password
$database = "b4svrhz1pxumygusk30q"; // Replace 'your_database' with your MySQL database name

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

<!-- <?php
$servername = "b4svrhz1pxumygusk30q-mysql.services.clever-cloud.com"; // Replace 'localhost' with your database host if necessary
$username = "uvxa2eya4zuwpvll"; // Replace 'your_username' with your MySQL username
$password = "Q2SvUshnXekmsts9M2as"; // Replace 'your_password' with your MySQL password
$database = "b4svrhz1pxumygusk30q"; // Replace 'your_database' with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

// Close connection
// $conn->close();
?> -->