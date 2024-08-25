<?php
$servername = "localhost";
$username = "root"; // Change if you're using a different MySQL username
$password = ""; // Change if you have a MySQL password set
$dbname = "bs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
