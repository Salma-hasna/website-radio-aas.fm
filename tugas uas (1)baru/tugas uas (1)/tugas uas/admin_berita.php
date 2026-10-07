<?php
session_start();
include 'koneksi.php';

// PROTEKSI: Jika belum login, tendang kembali ke halaman login.php
if (!isset($_SESSION['login_admin'])) {
    header("Location: login.php");
    exit;
}

// Proses Tambah Berita
if (isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $link = mysqli_real_escape_string($koneksi, $_POST['link']);
    
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    if ($nama_gambar != "") {
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi_gambar = strtolower(end(explode('.', $nama_gambar)));

        if (in_array($ekstensi_gambar, $ekstensi_valid)) {
            $nama_gambar_baru = uniqid() . '.' . $ekstensi_gambar;
            move_uploaded_file($tmp_name, 'images/' . $nama_gambar_baru);
        } else {
            echo "<script>alert('Format gambar harus JPG, JPEG, PNG, atau WEBP!'); window.location='admin_berita.php';</script>";
            exit;
        }
    } else {
        $nama_gambar_baru = "berita_default.jpg"; 
    }

    $query = "INSERT INTO berita (judul, deskripsi, link, gambar) VALUES ('$judul', '$deskripsi', '$link', '$nama_gambar_baru')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berita berhasil ditambahkan!'); window.location='admin_berita.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}

// Proses Hapus Berita
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $cari_gambar = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id=$id");
    $data_gambar = mysqli_fetch_assoc($cari_gambar);
    if ($data_gambar['gambar'] != 'berita_default.jpg' && file_exists('images/' . $data_gambar['gambar'])) {
        unlink('images/' . $data_gambar['gambar']);
    }

    mysqli_query($koneksi, "DELETE FROM berita WHERE id=$id");
    echo "<script>alert('Berita berhasil dihapus!'); window.location='admin_berita.php';</script>";
}

// Proses Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manajemen Berita</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f4; color: #1c3221; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); position: relative; }
        h2 { border-bottom: 2px solid #1c3221; padding-bottom: 10px; margin-top: 30px; }
        .header-admin { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px double #1c3221; padding-bottom: 10px; }
        .btn-logout { background-color: #ff4d4d; color: white; text-decoration: none; padding: 8px 15px; font-weight: bold; border-radius: 4px; }
        .btn-logout:hover { background-color: #cc0000; }
        .btn-kembali-berita { background-color: #2196F3; color: white; text-decoration: none; padding: 8px 15px; font-weight: bold; border-radius: 4px; margin-right: 10px; }
        .btn-kembali-berita:hover { background-color: #0b7dda; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #1c3221; color: #f1ece1; border: none; padding: 10px 20px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #f1ece1; color: #1c3221; border: 1px solid #1c3221; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #1c3221; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn-aksi { text-decoration: none; padding: 6px 12px; border-radius: 4px; color: white; font-size: 13px; font-weight: bold; margin-right: 5px; display: inline-block; }
        .btn-edit { background-color: #f1b72c; color: #1c3221; }
        .btn-edit:hover { background-color: #d69f24; }
        .btn-hapus { background-color: #ff4d4d; }
        .btn-hapus:hover { background-color: #cc0000; }
        .img-tabel { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-admin">
        <span>Selamat Datang, <strong><?= htmlspecialchars($_SESSION['admin_user']); ?></strong></span>
        <div>
            <a href="admin_berita.php?logout=true" class="btn-logout" onclick="return confirm('Apakah Anda ingin keluar?')">Logout</a>
        </div>
    </div>

    <h2>Tambah Berita Baru</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Judul Berita</label>
            <input type="text" name="judul" required placeholder="Masukkan judul berita...">
        </div>
        <div class="form-group">
            <label>Deskripsi / Ringkasan Berita</label>
            <textarea name="deskripsi" rows="4" required placeholder="Tulis deskripsi singkat berita di sini..."></textarea>
        </div>
        <div class="form-group">
            <label>Link Berita Utama (Baca Selengkapnya)</label>
            <input type="text" name="link" required placeholder="Contoh: https://bawaslu.go.id">
        </div>
        <div class="form-group">
            <label>Upload Gambar Berita</label>
            <input type="file" name="gambar">
        </div>
        <button type="submit" name="tambah">Simpan Berita</button>
    </form>

    <h2>Daftar Berita Saat Ini</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul Berita (Klik untuk Cek Link)</th>
                <th>Deskripsi</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $ambil_data = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
            if(mysqli_num_rows($ambil_data) == 0){
                echo "<tr><td colspan='5' style='text-align:center; color:gray;'>Belum ada data berita.</td></tr>";
            }
            while($row = mysqli_fetch_assoc($ambil_data)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td>
                    <img src="images/<?= htmlspecialchars($row['gambar']); ?>" class="img-tabel" alt="Thumb">
                </td>
                <td>
                    <a href="<?= htmlspecialchars($row['link']); ?>" target="_blank" style="color: #2196F3; font-weight: bold; text-decoration: none;">
                        <?= htmlspecialchars($row['judul']); ?> ↗
                    </a>
                </td>
                <td><?= htmlspecialchars(substr($row['deskripsi'], 0, 70)) . '...'; ?></td>
                <td>
                    <!-- HANYA EDIT DAN HAPUS -->
                    <a href="edit_berita.php?id=<?= $row['id']; ?>" class="btn-aksi btn-edit">Edit</a>
                    <a href="admin_berita.php?hapus=<?= $row['id']; ?>" class="btn-aksi btn-hapus" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>