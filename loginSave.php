<?php
session_start();

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
$database = "fyp";

$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Connection failed");
}

// 🔐 Password hash (recommended)
$password = password_hash($pass1, PASSWORD_DEFAULT);

// Insert query
$qry = "INSERT INTO register 
(Name, UserType, Email, Rollno, Phone, Semester, Department, Password)
VALUES 
('$name', '$usertype', '$email', '$rollno', '$mobile', '$semester', '$department', '$password')";

if (mysqli_query($conn, $qry)) {

    // ✅ Auto login after registration (optional but professional)
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['usertype'] = $usertype;

    //  Redirect to browse books
    header("Location: Home.html");
    exit;

} else {
    echo "<script>alert('Registration failed'); window.location.href='register.php';</script>";
}

mysqli_close($conn);
?>
