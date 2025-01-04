<?php
// Memulai session
session_start();

// Cek jika pengguna sudah login
if (isset($_SESSION['username'])) {
    // Jika sudah login, arahkan ke halaman logout atau halaman lain
    header("Location: logout.php");
    exit();
}

// Menyertakan file koneksi
include "koneksi.php";

// Memproses login jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil input username dan password
    $username = $_POST['username']; 
    $password = md5($_POST['password']); // Mengenkripsi password dengan md5

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("SELECT username FROM user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password); // Mengikat parameter ke prepared statement
    $stmt->execute(); // Menjalankan statement
    $hasil = $stmt->get_result(); // Mendapatkan hasil query
    $row = $hasil->fetch_array(MYSQLI_ASSOC); // Mengambil baris sebagai array asosiatif

    // Jika ditemukan user dengan username dan password yang cocok
    if (!empty($row)) {
        $_SESSION['username'] = $row['username']; // Simpan username ke session
        header("location:admin.php"); // Redirect ke halaman admin
        exit(); // Menghentikan eksekusi lebih lanjut
    } else {
        // Jika login gagal, arahkan kembali ke halaman login
        header("location:login.php"); 
        exit(); // Menghentikan eksekusi lebih lanjut
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daily Journal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
    <h1 class="text-center my-4">Daily Journal Login</h1>
</header>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Login</h3>
                    <!-- Form Login -->
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="text-center py-3">
    <p>Iqbal Tegar Pratama © 2024</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
