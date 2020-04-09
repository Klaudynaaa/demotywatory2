<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed " . $conn->connect_error);
}

echo "connected successfully";


$sql = "select * from demotywatory order by id desc ";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['title'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["file"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";

            // Insert record
            $query = "insert into demotywatory(title,imgsrc) values('" . $name . "','" . $target_file . "')";

            mysqli_query($conn, $query) or die(mysqli_error($conn));

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }


    $sql = "select * from demotywatory order by id desc ";
    $result = $conn->query($sql);

    if ($conn->query($sql) === TRUE) {
        echo "new record created successfully";
    } else {
        echo "Error " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();
?>

<div class="add">

<h2>Dodaj wpis</h2>

<!-- Trigger/Open The Modal -->
<button id="myBtn">Dodaj wpis</button>
    <li>
        <a><i class="fas fa-arrow-up animated infinite bounce"></i></a>
    </li>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <form method="post" action="index.php" enctype='multipart/form-data'>
            Tytuł: <br>
            <input type="text" name="title">
            <br>
            Obrazek: <br>
            <input type="file" name="file">
            <br><br>
            <input type='submit' value='Zapisz' name='but_upload'>
        </form>
    </div>
</div>
</div>

<div class="container">

    <h1>Demotywatory<span> 2</span></h1>

    <div class="content">
        <?php foreach ($result as $r): ?>
        <div class="post">
            <h3><?php echo $r['title']?></h3>
            <img src='<?php echo $r['imgsrc'] ?>' >
            <a href="delete.php?id=<?php echo $r['id']?>">Click me</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
