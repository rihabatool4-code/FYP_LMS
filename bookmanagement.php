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

// ADD OR UPDATE BOOK
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode']; // add or edit
    $title = $_POST['title'];
    $author = $_POST['author'];
    $accno = $_POST['accno'];
    $category = $_POST['category'];
    $pdflink = $_POST['pdflink']; // direct link from user
    $content = $_POST['content']; // NEW: Content

    // Assign category image automatically
    $imagePath = $categoryImages[$category] ?? $defaultImage;

    if($mode === "add"){
        mysqli_query($conn, "INSERT INTO addbook (Title, Author, Accno, Category, Image, Pdf_file, Content) 
            VALUES ('$title','$author','$accno','$category','$imagePath','$pdflink','$content')");
    } elseif($mode === "edit"){
        $id = $_POST['bookid'];
        mysqli_query($conn, "UPDATE addbook SET Title='$title', Author='$author', Accno='$accno', Category='$category', Image='$imagePath', Pdf_file='$pdflink', Content='$content' WHERE id='$id'");
    }

    header("Location: bookmanagement.php");
    exit();
}

// DELETE BOOK
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM addbook WHERE id='$id'");
    header("Location: bookmanagement.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Management - GGCW Library</title>
<link rel="stylesheet" href="bookmanagement.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header class="navbar">
    <div class="logo-container">
        <img src="Pics/logo.PNG" alt="GGCW Library Logo" class="ggcw-logo">
    </div>

    <nav>
        <ul>
            <li><a href="Home.html">Home</a></li>
            <li><a href="browseBooks.php">Browse Books</a></li>
            <li><a href="first.html">PDFs</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="admin.php">Admin Dashboard</a></li>
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
  <h2>Book Management</h2>
  <p class="subtitle">Add, update, or delete book records</p>

  <div class="top-actions">
    <a href="admin.php"><button class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</button></a> 
    <button class="add-btn" id="openModal"><i class="fa-solid fa-plus"></i> Add New Book</button>
  </div>

  <table>
    <thead>
      <tr>
        <th>Book Details</th>
        <th>Accession no</th>
        <th>Category</th>
        <th>PDF Link</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM addbook ORDER BY id DESC");
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // Encode all values to prevent broken HTML
    $contentSafe = htmlspecialchars(str_replace(array("\n","\r"), ' ', $row['Content']), ENT_QUOTES);
    $titleSafe = htmlspecialchars($row['Title'], ENT_QUOTES);
    $authorSafe = htmlspecialchars($row['Author'], ENT_QUOTES);
    $accnoSafe = htmlspecialchars($row['Accno'], ENT_QUOTES);
    $categorySafe = htmlspecialchars($row['Category'], ENT_QUOTES);
    $pdfSafe = htmlspecialchars($row['Pdf_file'], ENT_QUOTES);

    echo "
    <tr>
      <td><strong>{$titleSafe}</strong><br><small>by {$authorSafe}</small></td>
      <td>{$accnoSafe}</td>
      <td><span class='tag blue'>{$categorySafe}</span></td>
      <td>";
      if(!empty($row['Pdf_file'])){
          echo "<a href='{$pdfSafe}' target='_blank'>View PDF</a>";
      } else {
          echo "No PDF Link";
      }
    echo "</td>
      <td class='actions'>
        <i class='fa-solid fa-pen edit' 
           data-id='{$row['id']}' 
           data-title='{$titleSafe}' 
           data-author='{$authorSafe}' 
           data-accno='{$accnoSafe}' 
           data-category='{$categorySafe}' 
           data-pdflink='{$pdfSafe}' 
           data-content='{$contentSafe}'
           title='Edit Book'></i>
        <i class='fa-solid fa-trash delete' data-id='{$row['id']}' title='Delete Book'></i>
      </td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='5'>No books found in the database.</td></tr>";
}
mysqli_close($conn);
?>
</tbody>
  </table>
</main>

<!-- Modal -->
<div class="modal" id="addBookModal">
  <div class="modal-content">
    <h2 id="modalTitle">Add New Book</h2>
    <form class="add-book-form" method="POST">
      <input type="hidden" name="mode" id="formMode" value="add">
      <input type="hidden" name="bookid" id="bookId">

      <div class="form-row">
        <div class="form-group">
          <label>Book Title *</label>
          <input type="text" name="title" id="bookTitle" placeholder="Enter book title" required />
        </div>
        <div class="form-group">
          <label>Author *</label>
          <input type="text" name="author" id="bookAuthor" placeholder="Enter author name" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Acc No *</label>
          <input type="text" name="accno" id="bookAccno" placeholder="Enter accession number" required />
        </div>
        <div class="form-group">
          <label>Category *</label>
          <select name="category" id="bookCategory" required>
            <option value="">Select category</option>
            <option value="Information Technology">Information Technology</option>
            <option value="Psychology">Psychology</option>
            <option value="Computer Science">Computer Science</option>
            <option value="education">Education</option>
            <option value="Mathematics">Mathematics</option>
            <option value="Economics">Economics</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Content *</label>
          <textarea name="content" id="bookContent" placeholder="Enter full book content here" required></textarea>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>PDF Link (Optional)</label>
          <input type="text" name="pdflink" id="pdfLink" placeholder="Enter full PDF URL">
        </div>
      </div>

      <div class="form-actions">
        <button type="button" class="cancel-btn" id="cancelBtn">Cancel</button>
        <button type="submit" class="submit-btn">Save</button>
      </div>
    </form>
  </div>
</div>

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
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="#">Help Center</a></li>
                </ul>
            </div>
            <div class="footer-support">
                <h4>Support</h4>
                <ul>
                    <li><a href="loginform.html">Login</a></li>
                    <li><a href="register.html">Register</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Made with Readdy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 GGCW Library Management System. All rights reserved. Built with modern technology for better library management.</p>
        </div>
    </footer>

<script>
const modal = document.getElementById("addBookModal");
const openBtn = document.getElementById("openModal");
const cancelBtn = document.getElementById("cancelBtn");

const modalTitle = document.getElementById("modalTitle");
const formMode = document.getElementById("formMode");
const bookId = document.getElementById("bookId");
const bookTitle = document.getElementById("bookTitle");
const bookAuthor = document.getElementById("bookAuthor");
const bookAccno = document.getElementById("bookAccno");
const bookCategory = document.getElementById("bookCategory");
const pdfLink = document.getElementById("pdfLink");
const bookContent = document.getElementById("bookContent");

// Open modal for Add
openBtn.onclick = () => {
  formMode.value = "add";
  modalTitle.innerText = "Add New Book";
  bookId.value = "";
  bookTitle.value = "";
  bookAuthor.value = "";
  bookAccno.value = "";
  bookCategory.value = "";
  pdfLink.value = "";
  bookContent.value = "";
  modal.style.display = "block";
};

// Cancel button
cancelBtn.onclick = () => modal.style.display = "none";

// Edit button
document.querySelectorAll(".edit").forEach(btn => {
  btn.onclick = () => {
    formMode.value = "edit";
    modalTitle.innerText = "Edit Book";
    bookId.value = btn.dataset.id;
    bookTitle.value = btn.dataset.title;
    bookAuthor.value = btn.dataset.author;
    bookAccno.value = btn.dataset.accno;
    bookCategory.value = btn.dataset.category;
    pdfLink.value = btn.dataset.pdflink;
    bookContent.value = btn.dataset.content;
    modal.style.display = "block";
  };
});

// Delete button
document.querySelectorAll(".delete").forEach(btn => {
btn.onclick = () => {
window.location.href = "bookmanagement.php?delete=" + btn.dataset.id;
};
});
</script>

</body>
</html>
