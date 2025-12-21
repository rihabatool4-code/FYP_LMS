<?php
$title     = $_POST['title'];
$author       = $_POST['author'];
$accno      = $_POST['accno'];
$category     = $_POST['category'];


$host     = "localhost";
$user     = "root";
$pass     = "";
$database = "fyp";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert query
$qry = "INSERT INTO addbook (Title, Author, Accno, Category)
        VALUES ('$title', '$author', $accno, '$category')";

// Debug (optional): show query
// echo "Running query: $qry<br>";

// Run query
if (mysqli_query($conn, $qry)) {

    header("Location: bookman.php");
    exit();

} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
