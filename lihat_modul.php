<?php
// 1. Wajib login untuk melihat halaman ini
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    die("Eits, kamu harus login dulu untuk melihat ruang belajar!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>EduClass - Ruang Belajar</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">

    <h2>📺 Ruang Belajar: Daftar Modul & Video Materi</h2>
    <p><a href="dashboard.php" style="text-decoration: none;">◀ Kembali ke Dasbor</a></p>
    <hr>

    <?php
    // 2. Ambil data dari tabel modul dan gabungkan dengan nama kelasnya
    $sql = "SELECT modul.*, kelas_virtual.nama_kelas 
            FROM modul 
            JOIN kelas_virtual ON modul.id_kelas = kelas_virtual.id_kelas 
            ORDER BY modul.id_modul DESC";
    $hasil = mysqli_query($koneksi, $sql);

    // 3. Tampilkan datanya satu per satu
    if (mysqli_num_rows($hasil) > 0) {
        while($m = mysqli_fetch_assoc($hasil)) {
            echo "<div style='background-color: #f9f9f9; padding: 15px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px;'>";
            echo "<h3 style='margin-top: 0; color: #333;'>" . $m['judul_modul'] . "</h3>";
            echo "<p style='color: #666;'>Mata Pelajaran: <b>" . $m['nama_kelas'] . "</b></p>";

            // 4. Logika Pintar: Mengubah link YouTube biasa menjadi video player (Embed)
            $url = $m['url_youtube'];
            $video_id = "";
            
            // Mencari ID Video dari link panjang (v=...) atau link pendek (youtu.be/...)
            if (strpos($url, 'v=') !== false) {
                $video_id = explode('v=', $url)[1];
                $video_id = explode('&', $video_id)[0];
            } elseif (strpos($url, 'youtu.be/') !== false) {
                $video_id = explode('youtu.be/', $url)[1];
            }

            // Tampilkan pemutar video YouTube jika ID ditemukan
            if ($video_id != "") {
                echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen style="border-radius: 8px;"></iframe>';
            } else {
                echo "<p><a href='".$url."' target='_blank' style='color: blue;'>Tonton Video di sini</a></p>";
            }
            
            echo "</div>";
        }
    } else {
        echo "<p>Belum ada modul materi yang diunggah.</p>";
    }
    ?>

</body>
</html>