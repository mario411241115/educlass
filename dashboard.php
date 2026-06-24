<?php
session_start();

// Proteksi Keamanan
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduClass - Dasbor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; } /* Warna background lembut */
    </style>
</head>
<body>

<div class="container mt-5">
    
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex justify-content-between align-items-center bg-white rounded">
            <div>
                <h2 class="card-title text-primary fw-bold mb-1">Dasbor EduClass</h2>
                <p class="card-text text-muted mb-0">Halo, <span class="fw-bold text-dark"><?php echo $_SESSION['username']; ?></span>! Selamat datang kembali.</p>
            </div>
            <div>
                <span class="badge bg-info text-dark fs-6 px-3 py-2 shadow-sm">Peran: <?php echo $_SESSION['role']; ?></span>
            </div>
        </div>
    </div>

    <h4 class="mb-3 fw-bold text-secondary">Menu Navigasi</h4>
    <div class="row g-4 mb-5">
        
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-top border-4 border-primary">
                <div class="card-body text-center mt-2">
                    <h5 class="card-title fw-bold">Daftar Kelas</h5>
                    <p class="card-text text-muted small">Lihat semua kelas virtual yang tersedia saat ini.</p>
                    <a href="lihat_kelas.php" class="btn btn-outline-primary w-100 mt-2">Buka Menu</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-top border-4 border-success">
                <div class="card-body text-center mt-2">
                    <h5 class="card-title fw-bold">Ruang Belajar</h5>
                    <p class="card-text text-muted small">Akses modul pembelajaran dan video materi.</p>
                    <a href="lihat_modul.php" class="btn btn-outline-success w-100 mt-2">Buka Menu</a>
                </div>
            </div>
        </div>

        <?php 
        // Menu Khusus: Hanya muncul jika user adalah Instruktur atau Admin
        if ($_SESSION['role'] == 'Instruktur' || $_SESSION['role'] == 'Admin') { 
        ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-top border-4 border-warning">
                    <div class="card-body text-center mt-2">
                        <h5 class="card-title fw-bold">Tambah Kelas</h5>
                        <p class="card-text text-muted small">Buat kelas virtual baru (Khusus Instruktur).</p>
                        <a href="tambah_kelas.php" class="btn btn-outline-warning w-100 mt-2">Buka Menu</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-top border-4 border-danger">
                    <div class="card-body text-center mt-2">
                        <h5 class="card-title fw-bold">Tambah Modul</h5>
                        <p class="card-text text-muted small">Unggah materi dan link video (Khusus Instruktur).</p>
                        <a href="tambah_modul.php" class="btn btn-outline-danger w-100 mt-2">Buka Menu</a>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

    <div class="text-end">
        <a href="logout.php" class="btn btn-danger px-4 shadow">🚪 Keluar (Logout)</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
