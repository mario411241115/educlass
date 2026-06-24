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

// Ambil nama kelas
$ambil_kelas = mysqli_query($koneksi, "SELECT nama_kelas FROM kelas_virtual WHERE id_kelas = '$id_kelas'");
$data_kelas = mysqli_fetch_assoc($ambil_kelas);

$pesan = "";

// PROSES PENILAIAN OTOMATIS OLEH MESIN
if (isset($_POST['kirim_kuis'])) {
    $jawaban1 = isset($_POST['soal1']) ? $_POST['soal1'] : "";
    $jawaban2 = isset($_POST['soal2']) ? $_POST['soal2'] : "";
    
    $skor = 0;
    
    // Kunci Jawaban Soal 1 = A, Soal 2 = B
    if ($jawaban1 == "A") { $skor += 50; }
    if ($jawaban2 == "B") { $skor += 50; }

    // Cek apakah siswa sudah pernah kerja kuis di kelas ini
    $cek_nilai = mysqli_query($koneksi, "SELECT * FROM nilai_kuis WHERE id_kelas='$id_kelas' AND username_siswa='$username_sekarang'");
    
    if (mysqli_num_rows($cek_nilai) > 0) {
        // Update nilai kalau sudah pernah kerja sebelumnya
        $sql = "UPDATE nilai_kuis SET skor='$skor', waktu_kerja=NOW() WHERE id_kelas='$id_kelas' AND username_siswa='$username_sekarang'";
    } else {
        // Simpan nilai baru
        $sql = "INSERT INTO nilai_kuis (id_kelas, username_siswa, skor) VALUES ('$id_kelas', '$username_sekarang', '$skor')";
    }

    if (mysqli_query($koneksi, $sql)) {
        $pesan = "<div class='alert alert-success text-center shadow-sm'><h4>🎉 Kuis Selesai!</h4>Nilai kamu berhasil dihitung otomatis oleh mesin: <b class='fs-3 text-primary'>$skor</b> / 100</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>❌ Gagal menyimpan nilai kuis.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Ujian Kuis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-purple text-white mb-1" style="background-color: #6f42c1;">Kuis Online</span>
            <h2 class="fw-bold text-dark"><?php echo $data_kelas['nama_kelas']; ?></h2>
        </div>
        <a href="lihat_kelas.php" class="btn btn-outline-secondary">◀ Kembali</a>
    </div>

    <?php echo $pesan; ?>

    <?php if ($role_sekarang == 'Siswa') { ?>
        <form action="" method="POST">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">1. Apa kepanjangan dari SDLC dalam rekayasa perangkat lunak?</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="soal1" value="A" id="s1a" required>
                        <label class="form-check-label" for="s1a">A. Software Development Life Cycle</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="soal1" value="B" id="s1b">
                        <label class="form-check-label" for="s1b">B. System Design Logic Code</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="soal1" value="C" id="s1c">
                        <label class="form-check-label" for="s1c">C. Structural Data Line Connection</label>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">2. Manakah di bawah ini yang merupakan bahasa standar untuk pemodelan diagram sistem (seperti Use Case / Class Diagram)?</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="soal2" value="A" id="s2a" required>
                        <label class="form-check-label" for="s2a">A. HTML</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="soal2" value="B" id="s2b">
                        <label class="form-check-label" for="s2b">B. UML (Unified Modeling Language)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="soal2" value="C" id="s2c">
                        <label class="form-check-label" for="s2c">C. SQL</label>
                    </div>
                </div>
            </div>

            <button type="submit" name="kirim_kuis" class="btn btn-purple text-white btn-lg w-100 rounded-pill shadow-sm fw-bold mb-5" style="background-color: #6f42c1;">Kirim & Hitung Nilai Otomatis</button>
        </form>
    <?php } ?>


    <?php if ($role_sekarang == 'Instruktur' || $role_sekarang == 'Admin') { ?>
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white fw-bold py-3">
                📊 Rekap Nilai Kuis Mahasiswa (Dinilai Otomatis Oleh Sistem)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th class="px-4">No</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Skor Akhir</th>
                                <th>Waktu Pengerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ambil_nilai = mysqli_query($koneksi, "SELECT * FROM nilai_kuis WHERE id_kelas='$id_kelas' ORDER BY skor DESC");
                            $no_nilai = 1;

                            if (mysqli_num_rows($ambil_nilai) > 0) {
                                while($n = mysqli_fetch_assoc($ambil_nilai)) {
                                    echo "<tr>";
                                    echo "<td class='px-4'>".$no_nilai++."</td>";
                                    echo "<td class='fw-bold text-primary'>".$n['username_siswa']."</td>";
                                    echo "<td class='text-center fw-bold fs-5 text-success'>".$n['skor']."</td>";
                                    echo "<td class='text-muted small'>".$n['waktu_kerja']."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada siswa yang menyelesaikan kuis di kelas ini.</td></tr>";
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