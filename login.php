<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "No account found with this email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GGCW Library</title>
  <link rel="stylesheet" href="loginform.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="login-container">
    <div class="login-box">

      <div class="login-header">
        <h2>GGCW Library</h2>
        <h3>Welcome Back</h3>
        <p>Sign in to access your library account</p>
      </div>

      <!-- ERROR MESSAGE -->
      <?php if ($error != ""): ?>
      <div class="error-box">
        <?php echo $error; ?>
      </div>
      <?php endif; ?>

      <!-- FORM -->
      <form method="POST">
        <div class="input-group">
          <label>Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Enter your email" required>
          </div>
        </div>

        <div class="input-group">
          <label>Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <span class="toggle-password" onclick="togglePassword()"></span>
          </div>
        </div>

        <div class="options">
          <label><input type="checkbox" name="remember"> Remember me</label>
          <a href="forgot_password.php">Forgot password?</a>
        </div>

        <button type="submit" class="btn-primary">Sign In</button>
      </form>

      <p class="signup-text">Don’t have an account? <a href="register.php">Sign up here</a></p>

      <div class="quick-login">
        <hr><span>Quick Login Options</span><hr>
      </div>

      <p class="support">Having trouble accessing your account? <a href="#">Contact Support</a></p>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
