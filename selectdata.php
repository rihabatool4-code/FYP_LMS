<?php

$host     = "localhost";
$user     = "root";
$pass     = "";
$database = "FYP";
$connection = mysqli_connect($host, $user, $pass, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$qry = "select * from register";
$result = mysqli_query($connection,$qry);
echo "<table border=1 align=center width=250><tr><td>id</td><td>Name</td><td>UserType</td><td>Email</td><td>Rollno</td><td>Phone</td><td>Semester</td><td>Department</td><td>Password</td>";
while($row=mysqli_fetch_array($result))
{
	echo "<tr>";
	        echo "<td>".$row['id'];
	        echo "<td>".$row['Name'];
	        echo "<td>".$row['UserType'];
	        echo "<td>".$row['Email'];
	        echo "<td>".$row['Rollno'];
	        echo "<td>".$row['Phone'];
	        echo "<td>".$row['Semester'];
	        echo "<td>".$row['Department'];
	        echo "<td>".$row['Password'];
	echo "</tr>";
}
mysqli_close($connection);
?>