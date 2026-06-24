<?php
session_start();
include 'koneksi.php';

// Proteksi keamanan role
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'Instruktur' && $_SESSION['role'] != 'Admin')) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_kelas = $_GET['id'];

    // Jalankan perintah hapus data di database
    $sql = "DELETE FROM kelas_virtual WHERE id_kelas = '$id_kelas'";
    
    if (mysqli_query($koneksi, $sql)) {
        header("Location: lihat_kelas.php?status=hapussukses");
    } else {
        header("Location: lihat_kelas.php?status=hapusgagal");
    }
} else {
    header("Location: lihat_kelas.php");
}
?>