<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Management - GGCW Library</title>
  <link rel="stylesheet" href="bookman.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
 
   <!-- Navigation Bar -->
  <header class="navbar">
    <div class="logo">📘 GGCW Library</div>
    <nav>
      <ul>
        <li><a href="Home.html">Home</a></li>
       <li><a href="browseBooks.html">Browse Books</a></li>
        <li><a href="pdf.html">PDFs</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="admin.html">Admin Dashboard</a></li>
        <li><a href="stdash.html">Student Dashboard</a></li>
      </ul>
    </nav>
    <div class="auth-buttons">
      <button class="login-btn" id="loginformBtn">Login</button>
      <button class="register-btn" id="registerBtn">Register</button>
    </div>
  </header>

  <main>
    <h2>Book Management</h2>
    <p class="subtitle">Add, update, or delete book records</p>

    <div class="top-actions">
      <a href="admin.html">
        <button class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</button>
      </a> 
      <button class="add-btn" id="openModal"><i class="fa-solid fa-plus"></i> Add New Book</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Book Details</th>
          <th>Accession no</th>
          <th>Department</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "fyp";

// Connect to database
$conn = mysqli_connect($host, $user, $pass, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Fetch all books
$qry = "SELECT * FROM addbook";
$result = mysqli_query($conn, $qry);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "
    <tr>
      <td><strong>{$row['Title']}</strong><br><small>by {$row['Author']}</small></td>
      <td>{$row['Accno']}</td>
      <td><span class='tag blue'>{$row['Category']}</span></td>
      <td class='actions'>
        <i class='fa-solid fa-pen edit' title='Edit Book'></i>
        <i class='fa-solid fa-trash delete' title='Delete Book'></i>
      </td>
    </tr>
    ";
  }
} else {
  echo "<tr><td colspan='4'>No books found in the database.</td></tr>";
}

mysqli_close($conn);
?>
</tbody>

    </table>
  </main>
<div class="modal" id="addBookModal">
  <div class="modal-content">
    
    <h2>Add New Book</h2>
    <form class="form-box" action="addbook.php" method="POST">

      <div class="form-row">
        <div class="form-group">
          <label>Book Title *</label>
          <input type="text" name="title" placeholder="Enter book title" required />
        </div>
        <div class="form-group">
          <label>Author *</label>
          <input type="text" name="author" placeholder="Enter author name" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Acc No *</label>
          <input type="text" name="accno" placeholder="Enter accession number" required />
        </div>
        <div class="form-group">
          <label>Category *</label>
          <select name="category" required>
               <option value="">Select category</option>
               <option value="Information Technology">Information Technology</option>
               <option value="Psychology">Psychology</option>
               <option value="Computer Science">Computer Science</option>
               <option value="Mathematics">Mathematics</option>
               <option value="Economics">Economics</option>
          </select>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" class="cancel-btn" id="cancelBtn">Cancel</button>
        <button type="submit" class="submit-btn">Add Book</button>
      </div>

    </form>
  </div>
</div>

   <footer class="footer">
    <div class="footer-top">
      <div class="footer-about">
        <h3>📘 GGCW Library</h3>
        <p>Government Graduate College Women Library Management System. Streamline operations and enhance student learning experience.</p>
        <div class="footer-socials">
          <a href="#"><i class="fa-brands fa-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
        </div>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Browse Books</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Help Center</a></li>
        </ul>
      </div>
      <div class="footer-support">
        <h4>Support</h4>
        <ul>
          <li><a href="#">Login</a></li>
          <li><a href="#">Register</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Made with Readdy</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2024 GGCW Library Management System. All rights reserved. Built with modern technology for better library management.</p>
    </div>
  </footer>

  
  <script>
    const modal = document.getElementById("addBookModal");
    const openBtn = document.getElementById("openModal");
    const cancelBtn = document.getElementById("cancelBtn");

    const closeModal = () => modal.style.display = "none";

    openBtn.onclick = () => modal.style.display = "block";
    cancelBtn.onclick = closeModal;
    
    window.onclick = (e) => { 
        if(e.target === modal) {
            closeModal();
        } 
    }

    document.getElementById("registerBtn").addEventListener("click", function () {
      window.location.href = "register.html";
    });

    document.getElementById("loginformBtn").addEventListener("click", function () {
      window.location.href = "loginform.html";
    });
  </script>
</body>
</html>
