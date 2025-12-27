<?php
$name     = $_POST['name'];
$email    = $_POST['email'];
$message  = $_POST['message'];


$host     = "localhost";
$user     = "root";
$pass     = "";
$database = "fyp";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert query
$qry = "INSERT INTO message (Name, Email, Message)
        VALUES ('$name', '$email', '$message')";

// Debug (optional): show query
// echo "Running query: $qry<br>";

// Run query
if (mysqli_query($conn, $qry)) {
    echo "Message record added successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
