<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Tambah Gallery</h1>
        <div class="card p-4">
            <form action="add_gallery.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Masukkan deskripsi"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" id="image" name="image" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];
    $uploadDir = 'galery/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Membuat folder jika belum ada
    }

    $imagePath = 'galery' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $imagePath);

    $conn = new mysqli('localhost', 'root', '', 'webdailyjournal');
    $conn->query("INSERT INTO gallery (title, description, image_path) VALUES ('$title', '$description', '$imagePath')");
    header('Location: gallery.php');
}
?>
