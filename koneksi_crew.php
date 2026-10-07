<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "radio_aas_fm"; // 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database crew gagal: " . mysqli_connect_error());
}
?>