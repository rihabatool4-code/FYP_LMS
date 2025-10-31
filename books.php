<?php
include 'db.php';

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Books</title>
</head>
<body>
    <h1>Library Book List</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['category']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No books found</td></tr>";
        }
        ?>

    </table>
</body>
</html>

<?php $conn->close(); ?>
