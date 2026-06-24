<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'Instruktur' && $_SESSION['role'] != 'Admin')) {
    header("Location: dashboard.php");
    exit();
}

$pesan = "";

if (isset($_POST['simpan'])) {
    $id_kelas = $_POST['id_kelas'];
    $judul_modul = $_POST['judul_modul'];
    $url_youtube = $_POST['url_youtube'];

    $sql = "INSERT INTO modul (id_kelas, judul_modul, url_youtube) VALUES ('$id_kelas', '$judul_modul', '$url_youtube')";
    if (mysqli_query($koneksi, $sql)) {
        $pesan = "<div class='alert alert-success'>✅ Modul materi berhasil diunggah!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>❌ Gagal mengunggah modul.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Tambah Modul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h3 class="fw-bold text-success mb-3">📤 Unggah Modul Materi</h3>
            <?php echo $pesan; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Pilih Kelas Virtual</label>
                    <select name="id_kelas" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        $kelas = mysqli_query($koneksi, "SELECT * FROM kelas_virtual");
                        while($k = mysqli_fetch_assoc($kelas)) {
                            echo "<option value='".$k['id_kelas']."'>".$k['nama_kelas']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Judul Modul Materi</label>
                    <input type="text" name="judul_modul" class="form-control" placeholder="Contoh: Pengenalan Dasar HTML" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Link Video YouTube</label>
                    <input type="url" name="url_youtube" class="form-control" placeholder="Contoh: https://www.youtube.com/watch?v=..." required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="dashboard.php" class="btn btn-outline-secondary">◀ Batal</a>
                    <button type="submit" name="simpan" class="btn btn-success px-4 fw-bold">Unggah Modul</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>