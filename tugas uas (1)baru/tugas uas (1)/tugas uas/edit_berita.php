<?php
session_start();
include 'koneksi.php';

// PROTEKSI: Jika belum login, tendang kembali
if (!isset($_SESSION['login_admin'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah ada ID yang mau diedit
if (!isset($_GET['id'])) {
    header("Location: admin_berita.php");
    exit;
}

$id = $_GET['id'];
$query_ambil = mysqli_query($koneksi, "SELECT * FROM berita WHERE id = $id");
$data = mysqli_fetch_assoc($query_ambil);

// Jika data tidak ditemukan
if (mysqli_num_rows($query_ambil) < 1) {
    die("Data tidak ditemukan...");
}

// Proses Update Data
if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $link = mysqli_real_escape_string($koneksi, $_POST['link']);
    
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    // Jika admin mengupload gambar baru
    if ($nama_gambar != "") {
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi_gambar = strtolower(end(explode('.', $nama_gambar)));

        if (in_array($ekstensi_gambar, $ekstensi_valid)) {
            $nama_gambar_baru = uniqid() . '.' . $ekstensi_gambar;
            move_uploaded_file($tmp_name, 'images/' . $nama_gambar_baru);

            // Hapus gambar lama dari folder (kecuali default)
            if ($data['gambar'] != 'berita_default.jpg' && file_exists('images/' . $data['gambar'])) {
                unlink('images/' . $data['gambar']);
            }
            
            $query_update = "UPDATE berita SET judul='$judul', deskripsi='$deskripsi', link='$link', gambar='$nama_gambar_baru' WHERE id=$id";
        } else {
            echo "<script>alert('Format gambar tidak valid!'); window.location='admin_berita.php';</script>";
            exit;
        }
    } else {
        // Jika tidak ganti gambar
        $query_update = "UPDATE berita SET judul='$judul', deskripsi='$deskripsi', link='$link' WHERE id=$id";
    }

    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Berita berhasil diperbarui!'); window.location='admin_berita.php';</script>";
    } else {
        echo "Gagal memperbarui: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Edit Berita</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f4; color: #1c3221; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h2 { border-bottom: 2px solid #1c3221; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #1c3221; color: #f1ece1; border: none; padding: 10px 20px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        .btn-batal { background-color: #ff4d4d; color: white; text-decoration: none; padding: 10px 20px; font-weight: bold; border-radius: 4px; display: inline-block; margin-left: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Berita</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Judul Berita</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']); ?>" required>
        </div>
        <div class="form-group">
            <label>Deskripsi / Ringkasan Berita</label>
            <textarea name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Link Berita Utama</label>
            <input type="text" name="link" value="<?= htmlspecialchars($data['link']); ?>" required>
        </div>
        <div class="form-group">
            <label>Ganti Gambar (Kosongkan jika tidak ingin diubah)</label>
            <input type="file" name="gambar">
            <p style="margin-top: 5px;"><small>Gambar saat ini: <strong><?= $data['gambar']; ?></strong></small></p>
        </div>
        <button type="submit" name="update">Simpan Perubahan</button>
        <a href="admin_berita.php" class="btn-batal">Batal</a>
    </form>
</div>

</body>
</html>