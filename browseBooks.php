<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$database = "fyp";

$conn = mysqli_connect($host, $user, $pass, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch books
$qry = "SELECT * FROM addbook ORDER BY id DESC";
$result = mysqli_query($conn, $qry);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GGCW Library - Browse Books</title>
  <link rel="stylesheet" href="browseBooks.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
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
        <li><a class="active" href="browseBooks.php">Browse Books</a></li>
        <li><a href="Pdf.html">PDFs</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="admin.html">Admin Dashboard</a></li>
        <li><a href="stdash.html">Student Dashboard</a></li>
        <li><a href="donationbooks.html">Donation Books</a></li>
      </ul>
    </nav>
    <div class="auth-buttons">
      <button class="login-btn" id="loginformBtn">Login</button>
      <button class="register-btn" id="registerBtn">Register</button>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Browse Our Collection</h1>
      <p>Discover thousands of books in our GGCW library collection. Search by title, author, category, or keywords.</p>
    </div>
  </section>

  <!-- Search Section -->
  <div class="book-search-section">
    <h4>Search Books</h4>
    <div class="search-box">
      <input type="text" id="searchInput" class="search-input" placeholder="Search by title, author, or keywords...">
      <select class="dropdown" id="fieldSelect">
        <option value="All">All Fields</option>
        <option value="Title">Title</option>
        <option value="Author">Author</option>
        <option value="Category">Category</option>
      </select>
      <button class="search-btn" id="searchBtn">Search</button>
    </div>
  </div>

  <!-- Available Books Section -->
  <section class="available-books">
    <div class="books-layout">
      <!-- Sidebar -->
      <aside class="sidebar">
        <h3>Departments</h3>
        <ul class="department-list">
          <li data-category="All" class="active">All</li>
          <li data-category="Computer Science">Computer Science</li>
          <li data-category="Literature">Literature</li>
          <li data-category="Science">Science</li>
          <li data-category="Mathematics">Mathematics</li>
          <li data-category="Psychology">Psychology</li>
          <li data-category="History">History</li>
        </ul>
      </aside>

      <!-- Book Grid -->
      <div class="books-grid" id="booksGrid">
        <?php
        if(count($books) > 0){
            foreach($books as $book){
                echo "<div class='book-card available'>
                        <h3>{$book['Title']}</h3>
                        <p>by {$book['Author']}</p>
                        <span class='category'>{$book['Category']}</span>
                        <p>Acc No: {$book['Accno']}</p>
                        <button class='request-btn'>Request</button>
                      </div>";
            }
        } else {
            echo "<p style='text-align:center; font-size:18px;'>No books available. Please add from Book Management.</p>";
        }
        ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-about">
        <h3>GGCW Library</h3>
        <p>Government Graduate College Women Library Management System. Streamline operations and enhance student learning experience.</p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    document.getElementById("registerBtn").addEventListener("click", function () {
      window.location.href = "register.html";
    });
    document.getElementById("loginformBtn").addEventListener("click", function () {
      window.location.href = "loginform.html";
    });

    // Department filter (client-side)
    const deptItems = document.querySelectorAll(".department-list li");
    const bookCards = document.querySelectorAll(".book-card");

    deptItems.forEach(item => {
      item.addEventListener("click", () => {
        deptItems.forEach(li => li.classList.remove("active"));
        item.classList.add("active");
        const selectedDept = item.dataset.category;

        bookCards.forEach(card => {
          if(selectedDept === "All" || card.querySelector('.category').textContent === selectedDept){
            card.style.display = "block";
          } else {
            card.style.display = "none";
          }
        });
      });
    });
  </script>
</body>
</html>
