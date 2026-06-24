<?php
session_start();
session_destroy(); // Menghapus semua data sesi (username & role)
header("Location: login.php"); // Mengarahkan kembali ke halaman login
exit();
?>