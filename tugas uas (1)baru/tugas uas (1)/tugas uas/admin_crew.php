<?php
session_start();
include 'koneksi_crew.php';

$PASSWORD_ADMIN = "adminaasfm"; 

// Proses Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_crew.php");
    exit();
}

// Proses Login (VERSI ANTI-LOOP)
if (isset($_POST['login'])) {
    $password_input = $_POST['password'];
    if ($password_input === $PASSWORD_ADMIN) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error_login = "Password salah! Silakan coba lagi.";
    }
}

// Jika belum login, tampilkan form login
if (!isset($_SESSION['admin_logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login Admin Crew</title>
        <style>
            body { background-color: #1c3221; color: #f1ece1; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
            .login-box { background: #26422d; padding: 30px; border-radius: 8px; width: 300px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
            input, button { width: 100%; padding: 10px; margin-top: 15px; border-radius: 4px; border: none; box-sizing: border-box; }
            button { background: #ffc107; font-weight: bold; cursor: pointer; color: #1c3221;}
            .err { color: #ff4d4d; margin-top: 10px; font-size: 14px; font-weight: bold; background: rgba(255,0,0,0.1); padding: 5px; border-radius: 4px; }
            
            .blink-eye {
                transform-origin: center;
                animation: eyeBlinkEffect 3.5s infinite;
            }

            @keyframes eyeBlinkEffect {
                0%, 95%, 100% { transform: scaleY(1); }
                97.5% { transform: scaleY(0.1); }
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h3>Pintu Masuk Admin</h3>
            <p style="font-size: 13px; color: #a3b899;">Ubah data crew hanya diizinkan bagi pengurus</p>
            
            <?php if(isset($error_login)) echo "<div class='err'>$error_login</div>"; ?>
            
            <form action="admin_crew.php" method="POST">
                <div style="position: relative; margin-top: 15px; text-align: left; width: 100%;">
                    <input type="password" name="password" id="passwordInput" placeholder="Masukkan Password Admin" required style="width: 100%; padding: 10px; padding-right: 45px; border-radius: 4px; border: none; box-sizing: border-box; background: #f1ece1; color: #1c3221; margin-top: 0;">
                    
                    <span id="togglePassword" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; display: flex; align-items: center; justify-content: center; width: 26px; height: 26px; user-select: none; z-index: 10;">
                        <svg id="eyeOpen" class="blink-eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1c3221" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="width: 22px; height: 22px;">
                            <path d="M3 12C6 7 18 7 21 12" />
                            <path d="M3 12C6 17 18 17 21 12" />
                            <circle cx="12" cy="12" r="3.5" fill="#1c3221" />
                            <circle cx="10.8" cy="10.8" r="0.9" fill="#f1ece1" />
                            <line x1="12" y1="7" x2="12" y2="4" /><line x1="8.5" y1="7.8" x2="7.3" y2="5" /><line x1="15.5" y1="7.8" x2="16.7" y2="5" /><line x1="5.5" y1="9.5" x2="4" y2="7.5" /><line x1="18.5" y1="9.5" x2="20" y2="7.5" />
                            <line x1="12" y1="17" x2="12" y2="20" /><line x1="8.5" y1="16.2" x2="7.3" y2="19" /><line x1="15.5" y1="16.2" x2="16.7" y2="19" /><line x1="5.5" y1="14.5" x2="4" y2="16.5" /><line x1="18.5" y1="14.5" x2="20" y2="16.5" />
                        </svg>

                        <svg id="eyeClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1c3221" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="width: 22px; height: 22px; display: none;">
                            <path d="M3 10C6 15 18 15 21 10" />
                            <line x1="12" y1="13.5" x2="12" y2="16.5" /><line x1="8.5" y1="13" x2="7.3" y2="15.8" /><line x1="15.5" y1="13" x2="16.7" y2="15.8" /><line x1="5.5" y1="11.8" x2="4" y2="14" /><line x1="18.5" y1="11.8" x2="20" y2="14" /><line x1="3.2" y1="10.2" x2="2" y2="12" /><line x1="20.8" y1="10.2" x2="22" y2="12" />
                        </svg>
                    </span>
                </div>
                
                <button type="submit" name="login">Masuk Sistem</button>
            </form>
            <br><a href="crew.php" style="color: #ffc107; text-decoration: none; font-size: 13px;">← Kembali</a>
        </div>

        <script>
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('passwordInput');
                const eyeOpen = document.getElementById('eyeOpen');
                const eyeClose = document.getElementById('eyeClose');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeOpen.style.display = 'none';
                    eyeClose.style.display = 'block';
                } else {
                    passwordInput.type = 'password';
                    eyeOpen.style.display = 'block';
                    eyeClose.style.display = 'none';
                }
            });
        </script>
    </body>
    </html>
    <?php
    exit(); 
}

// =========================================================================
// LOGIKA PEMROSESAN DATABASE (TAMBAH / HAPUS)
// =========================================================================

// 1. PROSES TAMBAH CREW DENGAN UPLOAD FOTO
if (isset($_POST['tambah'])) {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $nama_siar    = mysqli_real_escape_string($conn, $_POST['nama_siar']);
    $jabatan      = mysqli_real_escape_string($conn, $_POST['jabatan']);
    
    $foto_path = 'images/default-avatar.jpg'; // Path default jika tidak upload foto

    // Cek apakah ada file foto yang diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $allowed_types  = array("jpg", "jpeg", "png", "webp");

        if (in_array($file_extension, $allowed_types)) {
            $new_filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES["foto"]["name"]);
            $target_file  = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto_path = $target_file;
            }
        }
    }

    mysqli_query($conn, "INSERT INTO crew (nama_lengkap, nama_siar, jabatan, foto) VALUES ('$nama_lengkap', '$nama_siar', '$jabatan', '$foto_path')");
    header("Location: admin_crew.php");
    exit();
}

// 2. PROSES HAPUS CREW
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    
    // Hapus file foto dari folder jika ada
    $get_foto = mysqli_query($conn, "SELECT foto FROM crew WHERE id = $id");
    if ($get_foto && $data_f = mysqli_fetch_assoc($get_foto)) {
        if (!empty($data_f['foto']) && file_exists($data_f['foto']) && $data_f['foto'] != 'images/default-avatar.jpg') {
            unlink($data_f['foto']);
        }
    }

    mysqli_query($conn, "DELETE FROM crew WHERE id = $id");
    header("Location: admin_crew.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panel Pengurus - Kelola Crew</title>
    <style>
        body { background-color: #1c3221; color: #f1ece1; font-family: sans-serif; padding: 20px; }
        .admin-box { max-width: 900px; margin: 0 auto; background: #26422d; padding: 25px; border-radius: 8px; }
        input, button { width: 100%; padding: 10px; margin-bottom: 12px; border-radius: 4px; border: none; box-sizing: border-box; }
        input { background: #f1ece1; color: #1c3221; }
        input[type="file"] { padding: 8px; cursor: pointer; }
        button { background: #ffc107; color: #1c3221; font-weight: bold; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #1c3221; }
        th, td { border: 1px solid #a3b899; padding: 10px; text-align: left; }
        th { background-color: #142418; color: #ffc107; }
        .tumb-img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #f1ece1; }
        .btn-action { padding: 6px 12px; text-decoration: none; color: white; border-radius: 4px; font-size: 13px; display: inline-block; }
        .btn-edit { background: #007bff; margin-right: 5px; }
        .btn-delete { background: #dc3545; }
        .header-panel { display: flex; justify-content: space-between; align-items: center; }
        .logout-btn { background: #dc3545; color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-size: 14px; font-weight: bold; }
        label { font-size: 14px; color: #a3b899; display: block; margin-bottom: 5px; }
    </style>
</head>
<body>

<div class="admin-box">
    <div class="header-panel">
        <div>
            <h2>Dashboard Manajemen Crew</h2>
        </div>
        <a href="admin_crew.php?logout=1" class="logout-btn">Keluar (Logout)</a>
    </div>
    <hr style="border: 1px solid #a3b899; margin-bottom: 25px;">

    <h3>Tambah Anggota Crew Baru</h3>
    
    <!-- FORM MULTIPART UNTUK UPLOAD FILE -->
    <form action="admin_crew.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap Sesuai KTP / KTM" required>
        <input type="text" name="nama_siar" placeholder="Nama Siar Udara" required>
        <input type="text" name="jabatan" placeholder="Jabatan (Contoh: Music Director / Announcer)" required>
        <input type="file" name="foto" accept="image/png, image/jpeg, image/jpg, image/webp">
        
        <button type="submit" name="tambah">Simpan Anggota Baru</button>
    </form>

    <h3 style="margin-top: 40px;">Daftar Tabel Informasi Crew</h3>
    <table>
        <thead>
            <tr>
                <th width="10%">Foto</th>
                <th>Nama Lengkap</th>
                <th>Nama Siar</th>
                <th>Jabatan</th>
                <th width="18%">Aksi Opsional</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM crew ORDER BY id DESC");
            if ($query && mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $foto_table = (!empty($row['foto']) && file_exists($row['foto'])) ? $row['foto'] : 'images/default-avatar.jpg';
                    ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($foto_table); ?>" class="tumb-img" alt="Foto"></td>
                        <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_siar']); ?></td>
                        <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                        <td>
                            <a href="edit_crew.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">Edit</a>
                            <a href="admin_crew.php?hapus=<?php echo $row['id']; ?>" onclick="return confirm('Hapus crew ini?')" class="btn-action btn-delete">Hapus</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; color:#a3b899;'>Belum ada data crew.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>