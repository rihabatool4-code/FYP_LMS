<?php
$rollno     = $_POST['rollno'];
$name       = $_POST['name'];
$email      = $_POST['email'];
$mobile     = $_POST['mobile'];
$department = $_POST['department'];
$semester   = $_POST['semester'];

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

// Insert query
$qry = "INSERT INTO addstudent (Studentid, Name, Email, Phone, Department, Semester)
        VALUES ($rollno, '$name', '$email', '$mobile', '$department', '$semester')";

// Debug (optional): show query
// echo "Running query: $qry<br>";

// Run query
if (mysqli_query($conn, $qry)) {

    header("Location: stmanag.php");
    exit();

} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
