<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "radio_aas_fm";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Ambil data dengan aman dan bersihkan spasi yang mengunci
    $nama     = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $pesan    = trim(mysqli_real_escape_string($koneksi, $_POST['pesan']));
    
    // Validasi input lagu & penyanyi: jika dikosongkan user, otomatis diisi strip "-"
    $lagu     = !empty(trim($_POST['lagu'])) ? mysqli_real_escape_string($koneksi, $_POST['lagu']) : '-';
    $penyanyi = !empty(trim($_POST['penyanyi'])) ? mysqli_real_escape_string($koneksi, $_POST['penyanyi']) : '-';

    $query = "INSERT INTO request_lagu (nama, judul_lagu, penyanyi, pesan) VALUES ('$nama', '$lagu', '$penyanyi', '$pesan')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.html?status=sukses");
        exit();
    } else {
        echo "Gagal mengirim request: " . mysqli_error($koneksi);
    }
} else {
    header("Location: index.html");
    exit();
}
?>