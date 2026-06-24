<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id_kelas = $_GET['id_kelas'];
$username_sekarang = $_SESSION['username'];
$role_sekarang = $_SESSION['role'];

// Ambil info nama kelas
$ambil_kelas = mysqli_query($koneksi, "SELECT nama_kelas FROM kelas_virtual WHERE id_kelas = '$id_kelas'");
$data_kelas = mysqli_fetch_assoc($ambil_kelas);

$pesan = "";

// Aksi simpan tugas untuk Siswa
if (isset($_POST['kirim_tugas'])) {
    $link_tugas = $_POST['link_tugas'];
    
    // Cek apakah siswa ini sudah pernah ngumpulin di kelas ini sebelumnya
    $cek_tugas = mysqli_query($koneksi, "SELECT * FROM pengumpulan_tugas WHERE id_kelas='$id_kelas' AND username_siswa='$username_sekarang'");
    
    if (mysqli_num_rows($cek_tugas) > 0) {
        // Jika sudah ada, kita update link yang baru
        $sql = "UPDATE pengumpulan_tugas SET link_tugas='$link_tugas', waktu_kumpul=NOW() WHERE id_kelas='$id_kelas' AND username_siswa='$username_sekarang'";
    } else {
        // Jika belum ada, kita insert baru
        $sql = "INSERT INTO pengumpulan_tugas (id_kelas, username_siswa, link_tugas) VALUES ('$id_kelas', '$username_sekarang', '$link_tugas')";
    }

    if (mysqli_query($koneksi, $sql)) {
        $pesan = "<div class='alert alert-success'>✅ Tugas kamu berhasil disimpan/diperbarui!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>❌ Gagal mengumpulkan tugas.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Ruang Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-primary mb-1">Ruang Tugas</span>
            <h2 class="fw-bold text-dark"><?php echo $data_kelas['nama_kelas']; ?></h2>
        </div>
        <a href="lihat_kelas.php" class="btn btn-outline-secondary">◀ Kembali</a>
    </div>

    <?php echo $pesan; ?>

    <?php if ($role_sekarang == 'Siswa') { 
        // Cek link tugas lama jika ada
        $tugas_lama = mysqli_query($koneksi, "SELECT link_tugas FROM pengumpulan_tugas WHERE id_kelas='$id_kelas' AND username_siswa='$username_sekarang'");
        $data_tugas_lama = mysqli_fetch_assoc($tugas_lama);
        $url_lama = isset($data_tugas_lama['link_tugas']) ? $data_tugas_lama['link_tugas'] : "";
    ?>
        <div class="card shadow border-0 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold text-info mb-3">Form Pengumpulan Tugas</h4>
                <p class="text-muted small">Silakan masukkan link pengumpulan tugas kamu (Google Drive, GitHub, dll) pada kolom di bawah ini:</p>
                
                <form action="" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Link URL Tugas</label>
                        <input type="url" name="link_tugas" class="form-control form-control-lg" placeholder="https://example.com/tugas-kamu" value="<?php echo $url_lama; ?>" required>
                    </div>
                    <button type="submit" name="kirim_tugas" class="btn btn-info text-dark fw-bold btn-lg w-100 rounded-pill">Kirim Tugas Saya</button>
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ($role_sekarang == 'Instruktur' || $role_sekarang == 'Admin') { ?>
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white fw-bold py-3">
                📋 Daftar Tugas Mahasiswa / Siswa Terkumpul
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th class="px-4">No</th>
                                <th>Nama Siswa</th>
                                <th>Link Tugas</th>
                                <th>Waktu Mengumpulkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ambil_semua_tugas = mysqli_query($koneksi, "SELECT * FROM pengumpulan_tugas WHERE id_kelas='$id_kelas' ORDER BY waktu_kumpul DESC");
                            $no_tugas = 1;

                            if (mysqli_num_rows($ambil_semua_tugas) > 0) {
                                while($t = mysqli_fetch_assoc($ambil_semua_tugas)) {
                                    echo "<tr>";
                                    echo "<td class='px-4'>".$no_tugas++."</td>";
                                    echo "<td class='fw-bold text-primary'>".$t['username_siswa']."</td>";
                                    echo "<td><a href='".$t['link_tugas']."' target='_blank' class='btn btn-sm btn-outline-primary rounded-pill px-3'>Buka Link Tugas 🔗</a></td>";
                                    echo "<td class='text-muted small'>".$t['waktu_kumpul']."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada siswa yang mengumpulkan tugas di kelas ini.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

</body>
</html>