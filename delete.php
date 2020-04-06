<?php
$x = $_POST['title'];
$y = $_POST['image'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db1";

$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_POST['id'];

if(isset($_POST['id']))
{
    $query = 'delete from tabela where id = ' . $id;

    if(mysqli_query($conn, $query))
    {
        echo 'Data Deleted';
    }
}

$conn->close();
?>
