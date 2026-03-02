<?php
session_start();
include "connect.php";

// ✅ DELETE LOGIC MUST BE HERE (before header include)
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    $stmt = $con->prepare("SELECT image FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetch();

    if($image)
    {
        $file_path = __DIR__ . "/uploads/" . $image['image'];

        if(file_exists($file_path))
        {
            unlink($file_path);
        }

        $delete_stmt = $con->prepare("DELETE FROM gallery WHERE id = ?");
        $delete_stmt->execute([$id]);
    }

    header("Location: sample.php");
    exit();
}

// ✅ NOW include header
include "Includes/templates/header.php";

?>



<div class="container mt-4">
    <h3>Gallery Samples</h3>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="gallery_image" class="form-control" required>
        </div>
        <button type="submit" name="upload" class="btn btn-success mt-2">
            Upload Image
        </button>
    </form>

    <hr>
    <h4 class="mt-4">Uploaded Images</h4>

<div class="row">

<?php
$stmt = $con->prepare("SELECT * FROM gallery ORDER BY id DESC");
$stmt->execute();
$images = $stmt->fetchAll();

foreach($images as $row)
{
?>

    <div class="col-md-3 text-center mb-4">
        <img src="uploads/<?php echo $row['image']; ?>" 
             class="img-fluid mb-2" 
             style="height:150px; object-fit:cover;">

        <br>

        <a href="sample.php?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Are you sure you want to delete this image?');"
           class="btn btn-danger btn-sm">
           Delete
        </a>
    </div>

<?php
}
?>

</div>
<?php

if(isset($_POST['upload']))
{
    $image_name = $_FILES['gallery_image']['name'];
    $tmp_name = $_FILES['gallery_image']['tmp_name'];

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    if(!in_array($file_ext, $allowed_ext)){
        echo "<div class='alert alert-danger mt-3'>Only JPG, JPEG, PNG & GIF allowed!</div>";
        exit();
    }

    $upload_path = __DIR__ . "/uploads/" . $image_name;

    if(move_uploaded_file($tmp_name, $upload_path))
    {
        $stmt = $con->prepare("INSERT INTO gallery (image) VALUES (?)");
        $stmt->execute([$image_name]);

       echo "
<div class='alert alert-success mt-3'>
    Uploaded Successfully! Redirecting in 5 seconds...
</div>

<script>
    setTimeout(function(){
        window.location.replace('sample.php');
    }, 5000);
</script>
";
    }
    else
    {
        echo "<div class='alert alert-danger mt-3'>Failed to upload image!</div>";
    }
}
?>

</div>

<?php include "Includes/templates/footer.php"; ?>
