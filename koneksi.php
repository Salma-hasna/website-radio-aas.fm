<?php
$host = "localhost";
$user = "root";       // Coba ganti pakai 'root' (bawaan XAMPP)
$pass = "";           // Kosongkan password-nya seperti ini
$db   = "radio_aas_fm"; // Pastikan nama database di phpMyAdmin persis seperti ini

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>