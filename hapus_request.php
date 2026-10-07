<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "radio_aas_fm";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Proses hapus baris data dari database berdasarkan ID
    $query = "DELETE FROM request_lagu WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        // Balikkan halaman ke website utama setelah berhasil hapus
        header("Location: index.html?status=terhapus");
        exit();
    } else {
        echo "Gagal menghapus request: " . mysqli_error($koneksi);
    }
} else {
    header("Location: index.html");
    exit();
}
?>