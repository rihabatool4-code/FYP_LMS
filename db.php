<?php
$servername = "localhost";
$username = "root"; // change if different
$password = "";     // change if you set a password
$database = "finalproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
