<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - GGCW Library</title>
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-container">
  <div class="login-box">
    <div class="login-header">
      <h2>Forgot Password</h2>
      <p>Enter your registered email to reset your password</p>
    </div>

    <form method="POST" action="forgot_password_process.php" onsubmit="return validateEmail()">
      <div class="input-group">
        <label>Email Address</label>
        <div class="input-wrapper">
          <i class="fas fa-envelope icon-fade"></i>
          <input type="email" name="email" id="email" placeholder="e.g. name@example.com" required>
        </div>
      </div>

      <button type="submit" class="btn-primary">Verify Email</button>
    </form>

    <div class="footer">
      <a href="loginform.php">Back to Sign In</a>
    </div>
  </div>
</div>

<script>
function validateEmail() {
  var email = document.getElementById("email").value.trim();
  var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
  if(!emailPattern.test(email)) {
    alert("Please enter a valid email address");
    return false;
  }
  return true;
}
</script>

</body>
</html>
