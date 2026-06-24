<?php
session_start();
include 'koneksi.php';

// Jika sudah login, lempar ke dasbor
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

$pesan_sukses = "";
$pesan_error = "";

// Proses pendaftaran
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cek apakah username sudah dipakai orang lain
    $cek_user = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username = '$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        $pesan_error = "❌ Username sudah terdaftar! Pilih yang lain.";
    } else {
        // Enkripsi password biar aman (standar industri)
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO pengguna (username, password_hash, role) VALUES ('$username', '$password_hash', '$role')";
        
        if (mysqli_query($koneksi, $sql)) {
            $pesan_sukses = "✅ Pendaftaran berhasil! Silakan klik 'Masuk di sini'.";
        } else {
            $pesan_error = "❌ Terjadi kesalahan saat mendaftar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #008CBA; } /* Background biru seragam dengan Login */
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="card shadow-lg border-0" style="width: 400px; border-radius: 15px;">
    <div class="card-body p-5">
        <h3 class="text-center fw-bold text-success mb-4">Daftar Akun Baru</h3>
        
        <?php if ($pesan_error != "") { ?>
            <div class="alert alert-danger p-2 text-center" role="alert"><?php echo $pesan_error; ?></div>
        <?php } ?>
        <?php if ($pesan_sukses != "") { ?>
            <div class="alert alert-success p-2 text-center" role="alert"><?php echo $pesan_sukses; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted">Username Baru</label>
                <input type="text" name="username" class="form-control form-control-lg" placeholder="Buat username" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Buat password" required>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted">Daftar Sebagai</label>
                <select name="role" class="form-select form-select-lg" required>
                    <option value="Siswa">Siswa</option>
                    <option value="Instruktur">Instruktur</option>
                </select>
            </div>
            
            <button type="submit" name="register" class="btn btn-success btn-lg w-100 fw-bold rounded-pill">Daftar Sekarang</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted small">Sudah punya akun? <a href="login.php" class="text-decoration-none fw-bold">Masuk di sini</a></p>
        </div>
    </div>
</div>

</body>
</html>