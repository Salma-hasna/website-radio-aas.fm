<?php
session_start();
include 'koneksi_crew.php';

// Proteksi: Jika admin belum login, lempar kembali ke halaman login admin_crew.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_crew.php");
    exit();
}

// Mengambil data crew berdasarkan ID yang diklik
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM crew WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    if (!$data) { 
        die("Data crew tidak ditemukan di database."); 
    }
} else {
    header("Location: admin_crew.php");
    exit();
}

// Proses update data ketika tombol simpan diklik
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $nama_siar    = mysqli_real_escape_string($conn, $_POST['nama_siar']);
    $jabatan      = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $foto         = mysqli_real_escape_string($conn, $_POST['foto']);

    mysqli_query($conn, "UPDATE crew SET nama_lengkap='$nama_lengkap', nama_siar='$nama_siar', jabatan='$jabatan', foto='$foto' WHERE id=$id");
    header("Location: admin_crew.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Informasi Crew</title>
    <style>
        body { background-color: #1c3221; color: #f1ece1; font-family: sans-serif; padding: 20px; }
        .edit-box { max-width: 500px; margin: 40px auto; background: #26422d; padding: 25px; border-radius: 8px; }
        input, button { width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 4px; border: none; box-sizing: border-box; }
        input { background: #f1ece1; color: #1c3221; }
        button { background: #007bff; color: white; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

<div class="edit-box">
    <a href="admin_crew.php" style="color: #ffc107; text-decoration: none; font-size: 14px;">← Kembali / Batalkan</a>
    <h2 style="margin-top: 10px;">Edit Data Anggota</h2>
    <hr style="border: 1px solid #a3b899; margin-bottom: 20px;">

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <label>Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" value="<?php echo htmlspecialchars($data['nama_lengkap']); ?>" required>

        <label>Nama Siar:</label>
        <input type="text" name="nama_siar" value="<?php echo htmlspecialchars($data['nama_siar']); ?>" required>

        <label>Jabatan:</label>
        <input type="text" name="jabatan" value="<?php echo htmlspecialchars($data['jabatan']); ?>" required>

        <label>Link/Path Foto:</label>
        <input type="text" name="foto" value="<?php echo htmlspecialchars($data['foto']); ?>">

        <button type="submit" name="update">Simpan Pembaruan Data</button>
    </form>
</div>

</body>
</html>