<?php
$name       = $_POST['name'];
$usertype   = $_POST['usertype'];
$email      = $_POST['email'];
$rollno     = $_POST['rollno'];
$mobile     = $_POST['mobile'];
$semester   = $_POST['semester'];
$department = $_POST['department'];
$pass1      = $_POST['pass1'];

$host     = "localhost";
$user     = "root";
$pass     = "";
$database = "FYP";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Wrap all values in quotes
$qry = "INSERT INTO register (Name, UserType, Email, Rollno, Phone, Semester, Department, Password)
        VALUES ('$name', '$usertype', '$email', $rollno, $mobile, '$semester', '$department', '$pass1')";

// Debug: print query
echo "Running query: $qry<br>";

// Run the query
if (mysqli_query($conn, $qry) === TRUE) {
    echo "new records created successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
