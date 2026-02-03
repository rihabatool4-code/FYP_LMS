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
$totalFines = $conn->query("SELECT SUM(Fine) AS total FROM issueform")->fetch_assoc()['total'] ?? 0;

// Table data
$result = $conn->query("SELECT * FROM issueform ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Issued & Returned Books - GGCW Library</title>
  <link rel="stylesheet" href="try.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Specific styles for Status Tags to match the reference look */
    .status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status.issued { background: #dbeafe; color: #1e40af; } /* Blueish */
    .status.returned { background: #d1fae5; color: #065f46; } /* Greenish */
    .status.overdue { background: #fee2e2; color: #991b1b; } /* Reddish */
    
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
        border-bottom: 4px solid var(--primary-color);
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card h3 { font-size: 28px; color: var(--text-dark); margin-bottom: 5px; }
    .stat-card p { color: var(--text-medium); font-weight: 500; }
    .stat-card.red { border-color: var(--danger-color); }
    .stat-card.green { border-color: #10b981; }

    /* Modal Form Textarea to match reference */
    .issue-form textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-family: inherit;
    }
  </style>
</head>
<body>

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
        <li><a href="admin.html" class="active">Admin Dashboard</a></li>
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
    <p class="subtitle">Manage book issues and returns with precision</p>

    <div class="stats">
      <div class="stat-card"> 
        <h3><?php echo $totalIssued; ?></h3>
        <p>Total Issued</p>
      </div>
      <div class="stat-card red"> 
        <h3><?php echo $overdueBooks; ?></h3>
        <p>Overdue Books</p>
      </div>
      <div class="stat-card green"> 
        <h3>Rs <?php echo $totalFines; ?></h3>
        <p>Total Fines Collected</p>
      </div>
    </div>

    <div class="top-actions">
      <a href="admin.html">
        <button class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</button>
      </a>
      <button class="add-btn" id="openModal"><i class="fa-solid fa-plus"></i> Issue New Book</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Student Details</th>
          <th>Book Information</th>
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
          <td>
            <strong><?php echo $row['Roll_no']; ?></strong><br>
            <small><?php echo $row['Department']." - ".$row['Semester']; ?></small>
          </td>
          <td>
            <strong><?php echo $row['Book_Title']; ?></strong><br>
            <small>ID: <?php echo $row['Accession_no']; ?></small>
          </td>
          <td><?php echo date('d M, Y', strtotime($row['Issue_Date'])); ?></td>
          <td><?php echo date('d M, Y', strtotime($row['Due_Date'])); ?></td>
          <td>
            <span class="status <?php echo strtolower($row['Status']); ?>">
              <?php echo $row['Status']; ?>
            </span>
          </td>
          <td><strong>Rs <?php echo $row['Fine'] ?? 0; ?></strong></td>
          <td class="actions">
            <i class="fa-solid fa-rotate-left edit" title="Update/Return" style="background: var(--edit-color);"></i>
            <i class="fa-solid fa-trash delete" title="Delete record"></i>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </main>

  <div id="issueModal" class="modal">
    <div class="modal-content">
      <h2 id="modalTitle">Issue / Return Book</h2>
      <form action="issuebook_save.php" method="POST" class="add-book-form">
        <div class="form-row">
          <div class="form-group">
            <label>Roll No *</label>
            <input type="text" name="Roll_no" required placeholder="e.g. CSC-001">
          </div>
          <div class="form-group">
            <label>Department *</label>
            <select name="Department" required>
              <option value="">Select Department</option>
              <option>Computer Science</option>
              <option>Information Technology</option>
              <option>Mathematics</option>
              <option>Economics</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Book Title *</label>
            <input type="text" name="Book_Title" required placeholder="Enter Book Name">
          </div>
          <div class="form-group">
            <label>Accession No *</label>
            <input type="text" name="Accession_no" required placeholder="Unique ID">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Issue Date</label>
            <input type="date" name="Issue_Date" required>
          </div>
          <div class="form-group">
            <label>Due Date</label>
            <input type="date" name="Due_Date" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Status</label>
            <select name="Status" id="statusSelect">
              <option value="Issued">Issued</option>
              <option value="Returned">Returned</option>
              <option value="Overdue">Overdue</option>
            </select>
          </div>
          <div class="form-group">
            <label>Fine (If any)</label>
            <input type="number" name="Fine" value="0">
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="cancel-btn" id="closeModal">Cancel</button>
          <button type="submit" class="submit-btn" id="submitBtn">Issue Book</button>
        </div>
      </form>
    </div>
  </div>

  <footer class="footer">
    <div class="footer-top">
      <div class="footer-about">
        <h3>📘 GGCW Library</h3>
        <p>Government Graduate College Women Library Management System. Modern technology for better education.</p>
        <div class="footer-socials">
          <a href="#"><i class="fa-brands fa-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
        </div>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="Home.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
      <div class="footer-support">
        <h4>Support</h4>
        <ul>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 GGCW Library Management System. All rights reserved.</p>
    </div>
  </footer>

  <script>
    const modal = document.getElementById("issueModal");
    const openBtn = document.getElementById("openModal");
    const closeBtn = document.getElementById("closeModal");
    const statusSelect = document.getElementById("statusSelect");
    const submitBtn = document.getElementById("submitBtn");

    // Modal Animation logic
    openBtn.onclick = () => {
      modal.style.display = "block";
    };

    closeBtn.onclick = () => {
      modal.style.display = "none";
    };

    window.onclick = (e) => {
      if (e.target == modal) modal.style.display = "none";
    };

    statusSelect.onchange = () => {
      submitBtn.textContent = statusSelect.value === "Issued" ? "Issue Book" : "Update Status";
    };

    // Navigation
    document.getElementById("registerBtn").onclick = () => window.location.href = "register.html";
    document.getElementById("loginformBtn").onclick = () => window.location.href = "loginform.html";
  </script>
</body>
</html>
<?php $conn->close(); ?>