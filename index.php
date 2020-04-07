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


if(isset($_POST['but_upload'])){
//    $name = $_FILES['file']['name'];
    $name = $_POST['title'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){

        // Convert to base64
        $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

        // Insert record
        $query = "insert into demotywatory(title,imgsrc) values('".$name."','".$image."')";

        mysqli_query($conn,$query) or die(mysqli_error($conn));

    }

}

//$images_sql = 'SELECT * from demotywatory order by id desc';
//$result = mysqli_query($conn, $images_sql);


$sql = "select * from demotywatory order by id desc ";
$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
    echo "new record created successfully";
} else {
    echo "Error " .$sql . "<br>" . $conn->error;
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

            <button id="<?php echo $r['id'] ?>" onClick="reply_click(this)">Usun</button>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function reply_click(obj) {
        var id = obj.id;
        console.log(id);

        if (confirm("Czy na pewno usunac?")) {
            $.ajax({
                method: "POST",
                url: "delete.php",
                data: {id: id},
                success: function (data) {
                    alert('usunieto')
                },
                error: function (data) {
                    alert('nie usunieto');

                }
            });
        }
    }

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
