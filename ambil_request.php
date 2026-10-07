<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "radio_aas_fm";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die(json_encode(["error" => "Koneksi database gagal"]));
}

// Ambil 5 request terbaru
$query = "SELECT * FROM request_lagu ORDER BY id DESC LIMIT 5";
$result = mysqli_query($koneksi, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Memformat tanggal database menjadi format Indonesia (Tanggal-Bulan-Tahun Jam:Menit)
    $tanggal_asli = $row['waktu']; 
    $tanggal_format = date('d-m-Y H:i', strtotime($tanggal_asli));

    $data[] = [
        "id"       => $row['id'], 
        "nama"     => htmlspecialchars($row['nama']),
        "lagu"     => htmlspecialchars($row['judul_lagu']),
        "penyanyi" => htmlspecialchars($row['penyanyi']),
        "pesan"    => htmlspecialchars($row['pesan']),
        "waktu"    => $tanggal_format 
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>