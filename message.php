<?php

$host     = "localhost";
$user     = "root";
$pass     = "";
$database = "fyp";

// Create connection
$connection = mysqli_connect($host, $user, $pass, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to select all students
$qry = "SELECT * FROM message";
$result = mysqli_query($connection, $qry);

// Display table
echo "<table border=1 align=center width=250>
        <td>Name</td>
        <td>Email</td>
        <td>Message</td>
      </tr>";

// Fetch rows
while ($row = mysqli_fetch_array($result)) {
    echo "<tr align='center'>";
    echo "<td>" . $row['Name'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['Message'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Close connection
mysqli_close($connection);
?>
