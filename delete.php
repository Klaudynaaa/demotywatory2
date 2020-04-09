<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['id'])) {
    $query = 'delete from demotywatory where id = ' . $_GET['id'];

    if (mysqli_query($conn, $query)) {
        echo 'Data Deleted';
        header("Location: index.php");
    }
}
$conn->close();
