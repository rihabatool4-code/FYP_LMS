<?php
session_start();

$conn = mysqli_connect("localhost","root","","fyp");
if(!$conn) die("DB Error");

if(!isset($_SESSION['reset_email'])){
    die("Unauthorized access");
}

$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

if($new !== $confirm){
    die(" Passwords do not match");
}

// Hash the new password
$hashed = password_hash($new, PASSWORD_DEFAULT);
$email = $_SESSION['reset_email'];

$sql = "UPDATE register SET Password = ? WHERE Email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $hashed, $email);
mysqli_stmt_execute($stmt);

unset($_SESSION['reset_email']); // clear session after update

// ✅ Direct redirect to login page
header("Location: loginform.php?reset=success");
exit;
?>
