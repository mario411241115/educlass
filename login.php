<?php
// Pemaksa munculnya pesan error
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

// Jika sudah login, langsung lempar ke dasbor
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

$pesan_error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM pengguna WHERE username = '$username'";
    $hasil = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($hasil) === 1) {
        $user = mysqli_fetch_assoc($hasil);
        
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $pesan_error = "❌ Password yang kamu masukkan salah!";
        }
    } else {
        $pesan_error = "❌ Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #008CBA; } /* Background biru elegan */
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="card shadow-lg border-0" style="width: 400px; border-radius: 15px;">
    <div class="card-body p-5">
        <h3 class="text-center fw-bold text-primary mb-4">Masuk EduClass</h3>
        
        <?php if ($pesan_error != "") { ?>
            <div class="alert alert-danger p-2 text-center" role="alert">
                <?php echo $pesan_error; ?>
            </div>
        <?php } ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted">Username</label>
                <input type="text" name="username" class="form-control form-control-lg" placeholder="Masukkan username" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label text-muted">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password" required>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary btn-lg w-100 fw-bold rounded-pill">Masuk</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted small">Belum punya akun? <a href="register.php" class="text-decoration-none fw-bold">Daftar di sini</a></p>
        </div>
    </div>
</div>

</body>
</html>