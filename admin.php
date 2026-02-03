<?php
// DATABASE CONNECTION
$host = "localhost";
$user = "root";
$pass = "";
$database = "fyp";

$conn = mysqli_connect($host, $user, $pass, $database);
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// GET TOTAL BOOKS
$books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM addbook"))['total'];

// GET TOTAL STUDENTS
$students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM addstudent"))['total'];

// (Optional) Issued, Overdue, Pending — add later
$issued = 0;
$overdue = 0;
$pending = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dynamic</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>

<body>

   <!-- Navigation Bar -->
  <header class="navbar">
    <div class="logo-container">
    <img src="Pics/logo.PNG" alt="GGCW Library Logo" class="ggcw-logo">
</div>
    <nav>
      <ul>
        <li><a href="Home.html">Home</a></li>
       <li><a  href="browseBooks.php">Browse Books</a></li>
        <li><a href="Pdf.html">PDFs</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a class="active" href="admin.php">Admin Dashboard</a></li>
        <li class="dropdown">
                <a href="#" >Dashboards <i class="fa-solid fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="staffdashboard.html"><i class="fa-solid fa-user-tie"></i> Staff Portal</a>
                    <a href="stdash.html"><i class="fa-solid fa-user-graduate"></i> Student Portal</a>
                </div>
            </li>
        <li><a href="donationbooks.html">Donation</a></li>
      </ul>
    </nav>
    <div class="auth-buttons">
      <button class="login-btn" id="loginformBtn">Login</button>
      <button class="register-btn" id="registerBtn">Register</button>
    </div>
  </header>

    <main>
        <h2>Admin Dashboard</h2>
        <p class="subtitle">Manage your library operations efficiently</p>

        <!-- DYNAMIC STATS -->
        <div class="stats">

            <div class="card blue">
                <h3><?php echo $books; ?></h3>
                <p>Total Books</p>
            </div>

            <div class="card green">
                <h3><?php echo $issued; ?></h3>
                <p>Issued Books</p>
            </div>

            <div class="card red">
                <h3><?php echo $overdue; ?></h3>
                <p>Overdue Books</p>
            </div>

            <div class="card purple">
                <h3><?php echo $students; ?></h3>
                <p>Total Students</p>
            </div>

            <div class="card orange">
                <h3><?php echo $pending; ?></h3>
                <p>Pending Requests</p>
            </div>

        </div>

        <div class="actions">
            <div class="action-box" onclick="window.location.href='bookmanagement.php'">
                <i class="fa-solid fa-book"></i>
                <h4>Manage Books</h4>
                <p>Add, update, or delete book records</p>
            </div>

            <div class="action-box" onclick="window.location.href='iissuebook.php'">
                <i class="fa-solid fa-book-open"></i>
                <h4>Issued Books</h4>
                <p>View and manage issued books</p>
            </div>

            <div class="action-box" onclick="window.location.href='stmanag.php'">
                <i class="fa-solid fa-user-graduate"></i>
                <h4>Student Management</h4>
                <p>Manage student registrations</p>
            </div>

            <div class="action-box" onclick="window.location.href='reports.html'">
                <i class="fa-solid fa-file-lines"></i>
                <h4>Generate Reports</h4>
                <p>View detailed library reports</p>
            </div>
        </div>

        <section class="recent-activities">
            <h2>Recent Activities</h2>

            <div class="activity-item">
                <div class="left-content">
                    <i class="fa-solid fa-book blue"></i>
                    <div class="details">
                        <span class="user">Sarah Johnson</span>
                        <span class="book-details">Clean Code • 2 hours ago</span>
                    </div>
                </div>
                <span class="status completed">Completed</span>
            </div>

            <div class="activity-item">
                <div class="left-content">
                    <i class="fa-solid fa-book green"></i>
                    <div class="details">
                        <span class="user">Mike Chen</span>
                        <span class="book-details">Introduction to Algorithms • 4 hours ago</span>
                    </div>
                </div>
                <span class="status completed">Completed</span>
            </div>

            <div class="activity-item">
                <div class="left-content">
                    <i class="fa-solid fa-book red"></i>
                    <div class="details">
                        <span class="user">Emma Wilson</span>
                        <span class="book-details">Psychology of Learning • 1 day ago</span>
                    </div>
                </div>
                <span class="status overdue">Overdue</span>
            </div>
        </section>
    </main>

    <!--footer-->

      <footer class="footer">
        <div class="footer-top">
            <div class="footer-about">
                <h3>GGCW Library</h3>
                <p>Government Graduate College Women Library Management System. Streamline operations and enhance student learning experience.</p>
                <div class="footer-socials">
                    <a href="https://www.facebook.com/groups/1232103560626611/"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/govt.graduate.college/?hl=en" target="_blank">
        <i class="fa-brands fa-instagram"></i>
    </a>
                    <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="Home.html">Home</a></li>
                    <li><a href="browseBooks.html">Browse Books</a></li>
                    <li><a href="aboutpage.html">About Us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="footer-support">
                <h4>Support</h4>
                <ul>
                    <li><a href="loginform.html">Login</a></li>
                    <li><a href="register.html">Register</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 GGCW Library Management System. All rights reserved. Built with modern technology for better library management.</p>
        </div>
    </footer>

    <script>
        document.getElementById("registerBtn").onclick = function () {
            window.location.href = "register.php";
        };
        document.getElementById("loginformBtn").onclick = function () {
            window.location.href = "loginform.php";
        };
    </script>

</body>
</html>

