<?php
$conn=mysqli_connect("localhost","root","","fyp");
if(!$conn) die("DB Error");

$roll=$_POST['Roll_no'];
$dept=$_POST['Department'];
$sem=$_POST['Semester'];
$book=$_POST['Book_Title'];
$acc=$_POST['Accession_no'];
$issue=$_POST['Issue_Date'];
$due=$_POST['Due_Date'];
$return=$_POST['Return_Date'];
$status=$_POST['Status'];

$fine=0;
if($return){
 $d=new DateTime($due);
 $r=new DateTime($return);
 if($r>$d){
   $fine=$d->diff($r)->days*10;
   $status="Overdue";
 } else {
   $status="Returned";
 }
}

mysqli_query($conn,"INSERT INTO issueform
(Roll_no,Department,Semester,Book_Title,Accession_no,Issue_Date,Due_Date,Return_Date,Status,Fine)
VALUES
('$roll','$dept','$sem','$book','$acc','$issue','$due','$return','$status','$fine')");

header("Location: try.php");
