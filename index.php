<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
</head>
<body>
<?php

$x = $_POST['title'];
$y = $_POST['image'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed " . $conn->connect_error);
}

echo "connected successfully";

$sql = "INSERT INTO `demotywatory`(`title`, `imgsrc`) VALUES ('$x', '$y')";

if ($conn->query($sql) === TRUE) {
    echo "new record created successfully";
} else {
    echo "Error " .$sql . "<br>" . $conn->error;
}

$sql = "SELECT * FROM demotywatory ORDER BY id desc ";
$result = $conn->query($sql);

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
        <form action="index.php" method="post">
            Tytuł: <br>
            <input type="text" name="title">
            <br>
            Obrazek: <br>
            <input type="text" name="image">
            <br><br>
            <button type="submit">Zapisz</button>
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

            <img src="<?php echo $r['imgsrc']?>">
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
