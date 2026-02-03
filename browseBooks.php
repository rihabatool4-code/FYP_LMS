<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "fyp";

$conn = mysqli_connect($host, $user, $pass, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// CATEGORY DEFAULT IMAGES
$categoryImages = [
    "Computer Science" => "Pics/cs.jpg",
    "Literature"       => "Pics/literature.jpg",
    "Science"          => "Pics/science.jpg",
    "Mathematics"      => "Pics/math.jpg",
    "Psychology"       => "Pics/psychology.jpg",
    "History"          => "Pics/history.jpg",
    "Information Technology" => "Pics/it.jpg",
    "Economics"        => "Pics/economics.jpg"
];
$defaultImage = "Pics/default.jpg";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Browse Books - GGCW Library</title>
<link rel="stylesheet" href="browseBooks.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        <li><a href="admin.php">Admin Dashboard</a></li>
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

<section class="hero">
    <div class="hero-content">
        <h1 class="animate-text">Browse Our Collection</h1>
        <p class="animate-text-delay">Find your next favorite book from our extensive library.</p>
    </div>
</section>

<div class="search-container">
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search by title, author, or keyword...">
        <button id="searchBtn"><i class="fa fa-search"></i> Search</button>
    </div>
</div>

<main class="main-container">
    <aside class="sidebar">
        <h3>Categories</h3>
        <ul class="category-list">
            <li class="active" data-filter="all">All Departments</li>
            <li data-filter="information technology">Information Technology</li>
            <li data-filter="psychology">Psychology</li>
            <li data-filter="computer science">Computer Science</li>
            <li data-filter="mathematics">Mathematics</li>
            <li data-filter="education">Education</li>
            <li data-filter="islamiyat">Islamiyat</li>
            <li data-filter="economics">Economics</li>

        </ul>
    </aside>

    <div class="books-grid" id="booksGrid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM addbook ORDER BY id DESC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $bookImg = !empty($row['Image']) ? $row['Image'] : ($categoryImages[$row['Category']] ?? $defaultImage);
                $dataContent = htmlspecialchars(strtolower($row['Content']), ENT_QUOTES); // escape quotes
                ?>
                <div class="book-card" 
                     data-category="<?php echo strtolower($row['Category']); ?>" 
                     data-title="<?php echo htmlspecialchars(strtolower($row['Title']), ENT_QUOTES); ?>"
                     data-author="<?php echo htmlspecialchars(strtolower($row['Author']), ENT_QUOTES); ?>"
                     data-content="<?php echo $dataContent; ?>">
                    
                    <div class="book-img-wrapper">
                        <img src="<?php echo $bookImg; ?>" onerror="this.src='Pics/default.jpg'">
                    </div>
                    
                    <div class="book-info">
                        <span class="badge"><?php echo $row['Category']; ?></span>
                        <h3><?php echo htmlspecialchars($row['Title']); ?></h3>
                        <p class="author">By <?php echo htmlspecialchars($row['Author']); ?></p>
                        <p class="acc-no">Acc No: <?php echo $row['Accno']; ?></p>
                    </div>

                    <div class="book-actions">
                        <?php if(!empty($row['Pdf_file'])): ?>
                            <a href="<?php echo $row['Pdf_file']; ?>" target="_blank" class="btn-pdf">View PDF</a>
                        <?php endif; ?>
                        <a href="request.php?id=<?php echo $row['id']; ?>" class="btn-request">Request</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='empty-msg'>No books found in the database.</div>";
        }
        mysqli_close($conn);
        ?>
    </div>
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
                    <li><a href="loginform.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 GGCW Library Management System. All rights reserved. Built with modern technology for better library management.</p>
        </div>
    </footer>

<script>
    const categoryLinks = document.querySelectorAll('.category-list li');
    const bookCards = document.querySelectorAll('.book-card');
    const searchBtn = document.getElementById('searchBtn');
    const searchInput = document.getElementById('searchInput');

    function filterBooks() {
        const searchText = searchInput.value.toLowerCase();
        const activeCategory = document.querySelector('.category-list li.active').getAttribute('data-filter');

        bookCards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            const cardTitle = card.getAttribute('data-title');
            const cardAuthor = card.getAttribute('data-author');
            const cardContent = card.getAttribute('data-content');

            const matchesSearch = cardTitle.includes(searchText) || cardAuthor.includes(searchText) || cardCat.includes(searchText) || cardContent.includes(searchText);
            const matchesCategory = activeCategory === 'all' || cardCat === activeCategory;

            card.style.display = (matchesSearch && matchesCategory) ? 'flex' : 'none';
        });
    }

    categoryLinks.forEach(link => {
        link.addEventListener('click', () => {
            categoryLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            filterBooks();
        });
    });

    searchBtn.addEventListener('click', filterBooks);
    searchInput.addEventListener('keyup', filterBooks);

    document.getElementById("registerBtn").addEventListener("click", () => window.location.href = "register.php");
    document.getElementById("loginformBtn").addEventListener("click", () => window.location.href = "loginform.php");
</script>

</body>
</html>
