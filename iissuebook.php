<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fyp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cards data
$totalIssued = $conn->query("SELECT COUNT(*) AS total FROM issueform WHERE Status='Issued'")->fetch_assoc()['total'];
$overdueBooks = $conn->query("SELECT COUNT(*) AS total FROM issueform WHERE Status='Overdue'")->fetch_assoc()['total'];
$totalFines = $conn->query("SELECT SUM(Fine) AS total FROM issueform")->fetch_assoc()['total'];
$totalFines = $totalFines ?? 0;

// Table data
$result = $conn->query("SELECT * FROM issueform ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Issued & Returned Books - GGCW Library</title>
  <link rel="stylesheet" href="issuebook.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Navigation Bar -->
  <header class="navbar">
    <div class="logo-container">
      <img src="Pics/clglogo.png" alt="GGCW Library Logo" class="ggcw-logo">
    </div>
    <nav>
      <ul>
        <li><a href="Home.html">Home</a></li>
        <li><a href="browseBooks.html">Browse Books</a></li>
        <li><a href="Pdf.html">PDFs</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="admin.html">Admin Dashboard</a></li>
        <li><a href="stdash.html">Student Dashboard</a></li>
        <li><a href="donationbooks.html">Donation</a></li>
      </ul>
    </nav>
    <div class="auth-buttons">
      <button class="login-btn" id="loginformBtn">Login</button>
      <button class="register-btn" id="registerBtn">Register</button>
    </div>
  </header>

  <main>
    <h2>Issued & Returned Books</h2>
    <p class="subtitle">Manage book issues and returns</p>

    <div class="stats">
      <div class="stat-card blue"> 
        <h3><?php echo $totalIssued; ?></h3>
        <p>Total Issued</p>
      </div>
      <div class="stat-card red"> 
        <h3><?php echo $overdueBooks; ?></h3>
        <p>Overdue Books</p>
      </div>
      <div class="stat-card green"> 
        <h3>Rs <?php echo $totalFines; ?></h3>
        <p>Total Fines</p>
      </div>
    </div>

    <div class="top-actions">
      <a href="admin.html">
        <button class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</button>
      </a>
      <button class="issue-btn" id="openModal"><i class="fa-solid fa-plus"></i> Issue/Return Book</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Student</th>
          <th>Book Details</th>
          <th>Issue Date</th>
          <th>Due Date</th>
          <th>Status</th>
          <th>Fine</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
<tr>
  <td data-label="Student">
    <?php echo $row['Roll_no']; ?><br>
    <small><?php echo $row['Department']." - ".$row['Semester']; ?></small>
  </td>

  <td data-label="Book Details">
    <strong><?php echo $row['Book_Title']; ?></strong><br>
    <small>Accession: <?php echo $row['Accession_no']; ?></small>
  </td>

  <td data-label="Issue Date"><?php echo $row['Issue_Date']; ?></td>
  <td data-label="Due Date"><?php echo $row['Due_Date']; ?></td>

  <td data-label="Status">
    <span class="status <?php echo strtolower($row['Status']); ?>">
      <?php echo $row['Status']; ?>
    </span>
  </td>

  <td data-label="Fine">Rs <?php echo $row['Fine'] ?? 0; ?></td>

  <td class="actions">
    <i class="fa-solid fa-check return" title="Return Book"></i>
    <i class="fa-solid fa-trash delete" title="Delete Issue"></i>
  </td>
</tr>
<?php } ?>
      </tbody>
    </table>
  </main>

  <!-- Modal for Issue Book Form -->
  <div id="issueModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="closeModal">&times;</span>
      <h3>Issue/Return Book</h3>
      <form action="issuebook.php" method="POST" id="issueForm" class="issue-form">
        <!-- Row 1: Roll_no and Department -->
        <div class="form-row">
          <div class="form-group">
            <label for="roll_no">Roll_no:</label>
            <input type="text" id="roll_no" name="Roll_no" required>
          </div>
          <div class="form-group">
            <label for="department">Department:</label>
            <select id="department" name="Department" required>
              <option value="">Select Department</option>
              <option>Computer Science</option>
              <option>Information Technology</option>
              <option>Mathematics</option>
              <option>Education</option>
              <option>Psychology</option>
              <option>Economics</option>
              <option>Islamiat</option>
            </select>
          </div>
        </div>
        <!-- Row 2: Semester and Book_Title -->
        <div class="form-row">
          <div class="form-group">
            <label for="semester">Semester:</label>
            <select id="semester" name="Semester" required>
              <option value="">Select Semester</option>
              <option>First</option>
              <option>Second</option>
              <option>Third</option>
              <option>Fourth</option>
              <option>Fifth</option>
              <option>Sixth</option>
              <option>Seventh</option>
              <option>Eight</option>
            </select>
          </div>
          <div class="form-group">
            <label for="book_title">Book_Title:</label>
            <input type="text" id="book_title" name="Book_Title" required>
          </div>
        </div>
        <!-- Row 3: Accession_no and Issue_Date -->
        <div class="form-row">
          <div class="form-group">
            <label for="accession_no">Accession_no:</label>
            <input type="text" id="accession_no" name="Accession_no" required>
          </div>
          <div class="form-group">
            <label for="issue_date">Issue_Date:</label>
            <input type="date" id="issue_date" name="Issue_Date" required>
          </div>
        </div>
        <!-- Row 4: Due_Date and Return_Date -->
        <div class="form-row">
          <div class="form-group">
            <label for="due_date">Due_Date:</label>
            <input type="date" id="due_date" name="Due_Date" required>
          </div>
          <div class="form-group">
            <label for="return_date">Return_Date:</label>
            <input type="date" id="return_date" name="Return_Date">
          </div>
        </div>
        <!-- Row 5: Status (single) -->
        <div class="form-row single">
          <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="Status" required>
              <option value="Issued">Issued</option>
              <option value="Returned">Returned</option>
              <option value="Overdue">Overdue</option>
            </select>
          </div>
        </div>
        <!-- Row 6: Fine (single) -->
        <div class="form-row single">
          <div class="form-group">
            <label for="fine">Fine:</label>
            <input type="text" id="fine" name="Fine" readonly>
          </div>
        </div>
        <button type="submit" id="submitBtn" class="submit-btn">Issue Book</button>
      </form>
    </div>
  </div>

  <!-- Footer -->
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
    const modal = document.getElementById("issueModal");
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const submitBtn = document.getElementById("submitBtn");
    const statusSelect = document.getElementById("status");

    // Function to close modal with animation
    const closeTheModal = () => {
      const modalContent = document.querySelector("#issueModal .modal-content");
      modalContent.style.transform = "scale(0.9)";
      modalContent.style.opacity = "0";
      setTimeout(() => {
        modal.style.display = "none";
        modalContent.style.transform = "scale(0.9)";
        modalContent.style.opacity = "0";
      }, 400);
    };

    openModal.onclick = () => modal.style.display = "block";
    closeModal.onclick = closeTheModal;

    // Close modal if user clicks outside
    window.onclick = (e) => {
      if (e.target == modal) closeTheModal();
    };

    // Dynamic submit button text based on status
    statusSelect.addEventListener("change", function() {
      const value = statusSelect.value;
      if (value === "Issued") {
        submitBtn.textContent = "Issue Book";
      } else if (value === "Returned") {
        submitBtn.textContent = "Return Book";
      } else if (value === "Overdue") {
        submitBtn.textContent = "Mark as Overdue";
      }
    });

    // Navigation buttons
    document.getElementById("registerBtn").addEventListener("click", function () {
      window.location.href = "register.html";
    });
    document.getElementById("loginformBtn").addEventListener("click", function () {
      window.location.href = "loginform.html";
    });
    <?php
?>
  </script>
</body>
</html>
<?php $conn->close(); ?>