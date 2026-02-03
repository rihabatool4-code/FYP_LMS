<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - GGCW Library</title>
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-container">
  <div class="login-box">
    <div class="login-header">
      <h2>Reset Password</h2>
      <p>Enter your new password below</p>
    </div>

    <form method="POST" action="reset_password_process.php" onsubmit="return validatePassword()">
      <div class="input-group">
        <label>New Password</label>
        <div class="input-wrapper">
          <i class="fas fa-lock icon-fade"></i>
          <input type="password" name="new_password" id="new_password" placeholder="••••••••" required>
        </div>
      </div>

      <div class="input-group">
        <label>Confirm Password</label>
        <div class="input-wrapper">
          <i class="fas fa-lock icon-fade"></i>
          <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required>
        </div>
      </div>

      <button type="submit" class="btn-primary">Update Password</button>
    </form>

    <div class="footer">
      <a href="loginform.php">Back to Sign In</a>
    </div>
  </div>
</div>

<script>
function validatePassword(){
  var p1 = document.getElementById("new_password").value.trim();
  var p2 = document.getElementById("confirm_password").value.trim();

  if(p1 === "" || p2 === ""){
    alert("Both fields are required");
    return false;
  }

  if(p1.length < 8){
    alert("Password must be at least 8 characters");
    return false;
  }

  if(p1 !== p2){
    alert("Passwords do not match");
    return false;
  }

  return true;
}
</script>

</body>
</html>
