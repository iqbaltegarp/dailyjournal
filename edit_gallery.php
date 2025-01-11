<?php
$conn = new mysqli('localhost', 'root', '', 'webdailyjournal');
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM gallery WHERE id = $id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Gallery</title>
</head>
<body>
    <h1>Edit Gallery</h1>
    <form action="edit_gallery.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <label>Judul:</label>
        <input type="text" name="title" value="<?= $row['title'] ?>" required><br>
        <label>Deskripsi:</label>
        <textarea name="description"><?= $row['description'] ?></textarea><br>
        <label>Gambar:</label>
        <input type="file" name="image"><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $query = "UPDATE gallery SET title = '$title', description = '$description'";
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $imagePath = 'galery' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
        $query .= ", image_path = '$imagePath'";
    }
    $query .= " WHERE id = $id";

    $conn->query($query);
    header('Location: gallery.php');
}
?>
