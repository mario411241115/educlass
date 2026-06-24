<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Instruktur dan Admin yang bisa masuk
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'Instruktur' && $_SESSION['role'] != 'Admin')) {
    header("Location: dashboard.php");
    exit();
}

$pesan = "";

if (isset($_POST['simpan'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "INSERT INTO kelas_virtual (nama_kelas, deskripsi) VALUES ('$nama_kelas', '$deskripsi')";
    if (mysqli_query($koneksi, $sql)) {
        $pesan = "<div class='alert alert-success'>✅ Kelas baru berhasil dibuat!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>❌ Gagal membuat kelas.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Tambah Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h3 class="fw-bold text-primary mb-3">🛠 Buat Kelas Virtual</h3>
            <?php echo $pesan; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Nama Kelas / Mata Kuliah</label>
                    <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: Pemrograman Web" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Deskripsi Kelas</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan singkat tentang kelas ini..." required></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="dashboard.php" class="btn btn-outline-secondary">◀ Batal</a>
                    <button type="submit" name="simpan" class="btn btn-primary px-4 fw-bold">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>