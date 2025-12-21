<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "FYP";

$conn = mysqli_connect($host, $user, $pass, $database);

// ADD OR UPDATE STUDENT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['rollno'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['mobile'];
    $dept = $_POST['department'];
    $sem = $_POST['semester'];
    $mode = $_POST['mode'];

    if ($mode === "add") {
        $qry = "INSERT INTO addstudent (Studentid, Name, Email, Phone, Department, Semester)
                VALUES ('$id', '$name', '$email', '$phone', '$dept', '$sem')";
    } elseif ($mode === "edit") {
        $qry = "UPDATE addstudent SET 
                Name='$name', Email='$email', Phone='$phone',
                Department='$dept', Semester='$sem'
                WHERE Studentid='$id'";
    }

    mysqli_query($conn, $qry);
    header("Location: stmanag.php");
    exit();
}

// DELETE STUDENT
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM addstudent WHERE Studentid='$id'");
    header("Location: stmanag.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GSCW Library - Student Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="stmanag.css" />
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

<main class="container">
  <div class="management-header">
    <div>
      <h3>Student Management</h3>
      <p>Manage student registrations and accounts</p>
    </div>
    <div class="actions">
      <a href="admin.html">
        <button class="btn back"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</button>
      </a>
      <button class="btn add-student" id="openAddStudentModal"><i class="fa-solid fa-user-plus"></i> Add Student</button>
    </div>
  </div>

  <div class="student-table">
    <div class="table-row header">
      <div class="col student-details">Student Details</div>
      <div class="col contact">Contact</div>
      <div class="col department">Department</div>
      <div class="col books-issued">Books Issued</div>
      <div class="col status">Status</div>
      <div class="col actions">Actions</div>
    </div>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM addstudent");

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='table-row data'>
              <div class='col student-details'>
                <strong>{$row['Name']}</strong><br>
                ID: {$row['Studentid']}<br>
                {$row['Semester']} Semester
              </div>
              <div class='col contact'>
                {$row['Email']}<br>
                {$row['Phone']}
              </div>
              <div class='col department'>
                <span class='badge dept-cs'>{$row['Department']}</span>
              </div>
              <div class='col books-issued'>0</div>
              <div class='col status'>
                <span class='badge status-active'>Active</span>
              </div>
              <div class='col actions'>
                <span class='action-icon edit-icon'
                  data-id='{$row['Studentid']}'
                  data-name='{$row['Name']}'
                  data-email='{$row['Email']}'
                  data-phone='{$row['Phone']}'
                  data-dept='{$row['Department']}'
                  data-sem='{$row['Semester']}'>
                  <i class='fa-solid fa-pen'></i>
                </span>
                <span class='action-icon delete-icon'
                  data-id='{$row['Studentid']}'>
                  <i class='fa-solid fa-trash-can'></i>
                </span>
              </div>
            </div>
            ";
        }
    } else {
        echo "<p>No students found in the database.</p>";
    }
    mysqli_close($conn);
    ?>
  </div>
</main>

<!-- ADD / EDIT STUDENT MODAL -->
<div id="addStudentModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" id="closeAddStudentModal">&times;</span>
    <h3 id="modalTitle">Add New Student</h3>

    <form class="student-form" id="studentForm" method="POST">
      <input type="hidden" name="mode" id="formMode" value="add">

      <div class="form-row">
        <div class="form-group">
          <label for="studentId">Student ID *</label>
          <input type="text" id="studentId" name="rollno" placeholder="e.g., 41" required>
        </div>
        <div class="form-group">
          <label for="fullName">Full Name *</label>
          <input type="text" id="fullName" name="name" placeholder="Enter student's full name" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" placeholder="Enter student's email" required>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number *</label>
          <input type="tel" id="phone" name="mobile" placeholder="Enter 11-digit contact number" required pattern="[0-9]{11}">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="department">Department *</label>
          <select id="department" name="department" required>
            <option value="" disabled selected>Select Department</option>
            <option>Computer Science</option>
            <option>Information Technology</option>
            <option>Education</option>
            <option>Mathematics</option>
            <option>Islamiyat</option>
            <option>Psychology</option>
            <option>Economics</option>
          </select>
        </div>
        <div class="form-group">
          <label for="semester">Semester *</label>
          <select id="semester" name="semester" required>
            <option value="" disabled selected>Select Semester</option>
            <option>First</option>
            <option>Second</option>
            <option>Third</option>
            <option>Fourth</option>
            <option>Fifth</option>
            <option>Sixth</option>
            <option>Seventh</option>
            <option>Eighth</option>
          </select>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" class="cancel-btn" id="cancelAddStudentBtn">Cancel</button>
        <button type="submit" class="submit-btn">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById("addStudentModal");
  const openModalBtn = document.getElementById("openAddStudentModal");
  const closeModalBtn = document.getElementById("closeAddStudentModal");
  const cancelBtn = document.getElementById("cancelAddStudentBtn");
  const studentForm = document.getElementById("studentForm");
  const formMode = document.getElementById("formMode");
  const modalTitle = document.getElementById("modalTitle");

  const closeModal = () => { modal.style.display = "none"; studentForm.reset(); };

  openModalBtn.onclick = () => {
      formMode.value = "add";
      modalTitle.innerText = "Add New Student";
      modal.style.display = "block";
  };

  closeModalBtn.onclick = cancelBtn.onclick = closeModal;

  // EDIT BUTTON
  document.querySelectorAll(".edit-icon").forEach(btn => {
      btn.onclick = () => {
          formMode.value = "edit";
          modalTitle.innerText = "Edit Student";
          document.getElementById("studentId").value = btn.dataset.id;
          document.getElementById("fullName").value = btn.dataset.name;
          document.getElementById("email").value = btn.dataset.email;
          document.getElementById("phone").value = btn.dataset.phone;
          document.getElementById("department").value = btn.dataset.dept;
          document.getElementById("semester").value = btn.dataset.sem;
          modal.style.display = "block";
      };
  });

  // DELETE BUTTON
  document.querySelectorAll(".delete-icon").forEach(btn => {
      btn.onclick = () => {
          if(confirm("Are you sure you want to delete this student?")){
              window.location.href = "stmanag.php?delete=" + btn.dataset.id;
          }
      };
  });
});
</script>

</body>
</html>
