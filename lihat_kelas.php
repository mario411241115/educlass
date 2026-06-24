<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$pesan = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'hapussukses') {
        $pesan = "<div class='alert alert-success'>✅ Kelas berhasil dihapus!</div>";
    } elseif ($_GET['status'] == 'hapusgagal') {
        $pesan = "<div class='alert alert-danger'>❌ Gagal menghapus kelas.</div>";
    } elseif ($_GET['status'] == 'editsukses') {
        $pesan = "<div class='alert alert-success'>✅ Perubahan kelas berhasil disimpan!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Daftar Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">📚 Daftar Kelas Virtual</h2>
        <a href="dashboard.php" class="btn btn-outline-secondary shadow-sm">◀ Kembali ke Dasbor</a>
    </div>

    <?php echo $pesan; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3">Nama Kelas</th>
                            <th class="py-3">Deskripsi</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM kelas_virtual ORDER BY id_kelas DESC";
                        $hasil = mysqli_query($koneksi, $sql);
                        $no = 1;

                        if (mysqli_num_rows($hasil) > 0) {
                            while($baris = mysqli_fetch_assoc($hasil)) {
                                echo "<tr>";
                                echo "<td class='px-4'>" . $no++ . "</td>";
                                echo "<td class='fw-bold text-dark'>" . $baris['nama_kelas'] . "</td>";
                                echo "<td class='text-muted'>" . $baris['deskripsi'] . "</td>";
                                echo "<td class='text-center'>";
                                
                                // Tombol Materi
                                echo "<a href='lihat_modul.php?id_kelas=".$baris['id_kelas']."' class='btn btn-sm btn-success px-3 rounded-pill me-1'>Materi</a>";
                                
                                // Tombol Tugas
                                echo "<a href='kumpul_tugas.php?id_kelas=".$baris['id_kelas']."' class='btn btn-sm btn-info text-dark px-3 rounded-pill me-1'>Tugas</a>";

                                // TOMBOL KUIS (BARU)
                                echo "<a href='kuis.php?id_kelas=".$baris['id_kelas']."' class='btn btn-sm btn-purple text-white px-3 rounded-pill me-1' style='background-color: #6f42c1;'>Kuis</a>";

                                // Tombol Edit & Hapus khusus Instruktur/Admin
                                if ($_SESSION['role'] == 'Instruktur' || $_SESSION['role'] == 'Admin') {
                                    echo "<a href='edit_kelas.php?id=".$baris['id_kelas']."' class='btn btn-sm btn-warning px-3 rounded-pill me-1'>Edit</a>";
                                    echo "<a href='hapus_kelas.php?id=".$baris['id_kelas']."' class='btn btn-sm btn-danger px-3 rounded-pill' onclick='return confirm(\"Apakah kamu yakin?\")'>Hapus</a>";
                                }

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center py-5 text-muted'>Belum ada kelas yang tersedia saat ini.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>