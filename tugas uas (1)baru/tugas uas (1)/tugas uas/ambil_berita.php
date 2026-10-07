<?php
// Cek file koneksi yang kamu pakai
if (file_exists('koneksi_crew.php')) {
    include 'koneksi_crew.php';
} else {
    include 'koneksi.php';
}

header('Content-Type: application/json');

$db_conn = isset($conn) ? $conn : (isset($koneksi) ? $koneksi : null);

$data = array();

if ($db_conn) {
    // Ambil 3 berita TERBARU berdasarkan ID terbesar
    $query = mysqli_query($db_conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
    
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            // Menyesuaikan nama kolom gambar & link agar cocok dengan database admin
            $foto = !empty($row['gambar']) ? $row['gambar'] : (!empty($row['foto']) ? $row['foto'] : '');
            $link = !empty($row['link']) ? $row['link'] : (!empty($row['link_eksternal']) ? $row['link_eksternal'] : '');
            
            // Format path gambar
            if (!empty($foto) && strpos($foto, 'images/') !== 0) {
                $foto = 'images/' . $foto;
            }

            $data[] = array(
                'id' => $row['id'],
                'judul' => $row['judul'],
                'deskripsi' => $row['deskripsi'],
                'foto' => $foto,
                'link' => $link
            );
        }
    }
}

echo json_encode($data);
?>