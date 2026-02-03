<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GGCW Library</title>
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

  <div class="login-container">
    <div class="login-box">
      <div class="login-header">
        <h2>GGCW Library</h2>
        <p>Please enter your details to sign in</p>
      </div>

      <form method="POST" action="logincheck.php" onsubmit="return validateLogin()">
        <div class="input-group">
          <label>Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope icon-fade"></i>
            <input type="email" name="email" id="email" placeholder="e.g. name@example.com" required>
          </div>
        </div>

        <div class="input-group">
          <label>Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock icon-fade"></i>
            <input type="password" name="password" id="password" placeholder="••••••••" required>
            <span class="toggle-password" onclick="togglePassword()">
              <i class="fas fa-eye" id="eyeIcon"></i>
            </span>
          </div>
        </div>

        <div class="options">
          <a href="forgot_password.php">Forgot password?</a>
        </div>

        <button type="submit" class="btn-primary">Sign In</button>
      </form>

      <div class="footer">
        Don’t have an account? <a href="register.php">Create one now</a>
      </div>
    </div>
  </div>

  <script>
    // Toggle password visibility
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }

    // Login form validation
    function validateLogin() {
      var email = document.getElementById("email").value.trim();
      var password = document.getElementById("password").value.trim();

      // Check empty fields
      if (email === "" || password === "") {
        alert("Both email and password are required");
        return false;
      }

      // Validate email format
      var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
      if (!emailPattern.test(email)) {
        alert("Please enter a valid email address");
        return false;
      }

      // Optional: check password length
      if (password.length < 8) {
        alert("Password must be at least 8 characters");
        return false;
      }

      return true; // Form will submit if all validations pass
    }
  </script>

</body>
</html>
