<?php
session_start();

// Connect to database
$conn = mysqli_connect("localhost","root","","fyp");
if (!$conn) die("DB Error");

if(isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $sql = "SELECT * FROM register WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1){
        $_SESSION['reset_email'] = $email; // Separate session for password reset
        header("Location: reset_password.php");
        exit;
    } else {
        echo "<p style='text-align:center; color:red;'>❌ Email not found</p>";
        echo "<p style='text-align:center;'><a href='forgot_password.php'>Try Again</a></p>";
    }
}
?>
