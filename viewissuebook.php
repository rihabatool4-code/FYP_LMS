<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fyp_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all issued/returned books
$sql = "SELECT * FROM issueform ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Issued & Returned Books</title>
  <link rel="stylesheet" href="issuebook.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<main>
  <h2>Issued & Returned Books</h2>
  <p class="subtitle">Real Data from Database</p>

  <table>
    <thead>
      <tr>
        <th>Student</th>
        <th>Book Title</th>
        <th>Issue Date</th>
        <th>Due Date</th>
        <th>Return Date</th>
        <th>Status</th>
        <th>Fine</th>
      </tr>
    </thead>

    <tbody>
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $statusClass = strtolower($row['Status']);
              echo "<tr>
                      <td>{$row['Roll_no']}<br><small>{$row['Department']} - {$row['Semester']}</small></td>
                      <td><strong>{$row['Book_Title']}</strong><br><small>Acc: {$row['Accession_no']}</small></td>
                      <td>{$row['Issue_Date']}</td>
                      <td>{$row['Due_Date']}</td>
                      <td>" . ($row['Return_Date'] ?? "—") . "</td>
                      <td>
                        <span class='status {$row['Status']}'>{$row['Status']}</span>
                      </td>
                      <td>Rs " . ($row['Fine'] ?? "0") . "</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='7' style='text-align:center;'>No records found</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <br>
  <a href="issuebook.html">
    <button class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</button>
  </a>

</main>

</body>
</html>

<?php $conn->close(); ?>