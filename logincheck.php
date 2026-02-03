<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "fyp");
if (!$conn) die("DB Connection Failed");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM register WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['Password'])) {
            $_SESSION['name'] = $row['Name'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['usertype'] = $row['UserType'];

            header("Location: browsebooks.php");
            exit;
        } else {
            echo "❌ Incorrect password";
        }
    } else {
        echo "❌ Email not registered";
    }
}
?>
