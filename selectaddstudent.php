<?php

$host     = "localhost";
$user     = "root";
$pass     = "";
$database = "FYP";

// Create connection
$connection = mysqli_connect($host, $user, $pass, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to select all students
$qry = "SELECT * FROM addstudent";
$result = mysqli_query($connection, $qry);

// Display table
echo "<table border=1 align=center width=250>
        <td>Student ID</td>
        <td>Name</td>
        <td>Email</td>
        <td>Phone</td>
        <td>Department</td>
        <td>Semester</td>
      </tr>";

// Fetch rows
while ($row = mysqli_fetch_array($result)) {
    echo "<tr align='center'>";
    echo "<td>" . $row['Studentid'] . "</td>";
    echo "<td>" . $row['Name'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['Phone'] . "</td>";
    echo "<td>" . $row['Department'] . "</td>";
    echo "<td>" . $row['Semester'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Close connection
mysqli_close($connection);
?>
