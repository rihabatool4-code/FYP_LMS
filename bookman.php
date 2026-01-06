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

// ADD OR UPDATE BOOK
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode']; // add or edit
    $title = $_POST['title'];
    $author = $_POST['author'];
    $accno = $_POST['accno'];
    $category = $_POST['category'];

    if($mode === "add"){
        mysqli_query($conn, "INSERT INTO addbook (Title, Author, Accno, Category) VALUES ('$title','$author','$accno','$category')");
    } elseif($mode === "edit"){
        $id = $_POST['bookid'];
        mysqli_query($conn, "UPDATE addbook SET Title='$title', Author='$author', Accno='$accno', Category='$category' WHERE id='$id'");
    }

    header("Location: bookman.php");
    exit();
}

// DELETE BOOK
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM addbook WHERE id='$id'");
    header("Location: bookman.php");
    exit();
}
?>

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

<header class="navbar">
  <div class="logo-container">
    <img src="Pics/logo.PNG" alt="GGCW Library Logo" class="ggcw-logo">
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
      <li><a href="donationbooks.html">Donation Books</a></li>
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
        <th>Copies</th>
        <th>Available</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM addbook");

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "
    <tr>
      <td><strong>{$row['Title']}</strong><br><small>by {$row['Author']}</small></td>
      <td>{$row['Accno']}</td>
      <td><span class='tag blue'>{$row['Category']}</span></td>
      <td>—</td>
      <td>—</td>
      <td><span class='status active'>Active</span></td>
      <td class='actions'>
        <i class='fa-solid fa-pen edit' 
           data-id='{$row['id']}' 
           data-title='{$row['Title']}' 
           data-author='{$row['Author']}' 
           data-accno='{$row['Accno']}' 
           data-category='{$row['Category']}' 
           title='Edit Book'></i>
        <i class='fa-solid fa-trash delete' data-id='{$row['id']}' title='Delete Book'></i>
      </td>
    </tr>
    ";
  }
} else {
  echo "<tr><td colspan='7'>No books found in the database.</td></tr>";
}

mysqli_close($conn);
?>
</tbody>
  </table>
</main>

<div class="modal" id="addBookModal">
  <div class="modal-content">
    <h2 id="modalTitle">Add New Book</h2>
    <form class="form-box" method="POST">
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
            <option value="Mathematics">Mathematics</option>
            <option value="Economics">Economics</option>
          </select>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" class="cancel-btn" id="cancelBtn">Cancel</button>
        <button type="submit" class="submit-btn">Save</button>
      </div>
    </form>
  </div>
</div>

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

// Open Add Modal
openBtn.onclick = () => {
  formMode.value = "add";
  modalTitle.innerText = "Add New Book";
  bookId.value = "";
  bookTitle.value = "";
  bookAuthor.value = "";
  bookAccno.value = "";
  bookCategory.value = "";
  modal.style.display = "block";
};

// Close modal
cancelBtn.onclick = () => modal.style.display = "none";
window.onclick = (e) => { if(e.target === modal) modal.style.display = "none"; };

// Edit Book
document.querySelectorAll(".edit").forEach(btn => {
  btn.onclick = () => {
    formMode.value = "edit";
    modalTitle.innerText = "Edit Book";
    bookId.value = btn.dataset.id;
    bookTitle.value = btn.dataset.title;
    bookAuthor.value = btn.dataset.author;
    bookAccno.value = btn.dataset.accno;
    bookCategory.value = btn.dataset.category;
    modal.style.display = "block";
  };
});

// Delete Book
document.querySelectorAll(".delete").forEach(btn => {
  btn.onclick = () => {
    if(confirm("Are you sure you want to delete this book?")){
      window.location.href = "bookman.php?delete=" + btn.dataset.id;
    }
  };
});

// Navigation
document.getElementById("registerBtn").onclick = () => window.location.href = "register.html";
document.getElementById("loginformBtn").onclick = () => window.location.href = "loginform.html";
</script>

</body>
</html>
