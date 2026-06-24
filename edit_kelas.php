<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'Instruktur' && $_SESSION['role'] != 'Admin')) {
    header("Location: dashboard.php");
    exit();
}

$id_kelas = $_GET['id'];
// Ambil data lama kelas yang mau diedit
$ambil_data = mysqli_query($koneksi, "SELECT * FROM kelas_virtual WHERE id_kelas = '$id_kelas'");
$data = mysqli_fetch_assoc($ambil_data);

$pesan = "";

if (isset($_POST['update'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "UPDATE kelas_virtual SET nama_kelas='$nama_kelas', deskripsi='$deskripsi' WHERE id_kelas='$id_kelas'";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: lihat_kelas.php?status=editsukses");
        exit();
    } else {
        $pesan = "<div class='alert alert-danger'>❌ Gagal memperbarui kelas.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Edit Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h3 class="fw-bold text-warning mb-3">✏️ Edit Kelas Virtual</h3>
            <?php echo $pesan; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Nama Kelas / Mata Kuliah</label>
                    <input type="text" name="nama_kelas" class="form-control" value="<?php echo $data['nama_kelas']; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Deskripsi Kelas</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required><?php echo $data['deskripsi']; ?></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="lihat_kelas.php" class="btn btn-outline-secondary">◀ Batal</a>
                    <button type="submit" name="update" class="btn btn-warning px-4 fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>