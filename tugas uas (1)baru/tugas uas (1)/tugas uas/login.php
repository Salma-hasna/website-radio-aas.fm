<?php
session_start();
include 'koneksi.php';

// Jika sudah login sebelumnya, langsung lempar ke halaman manajemen berita
if (isset($_SESSION['login_admin'])) {
    header("Location: admin_berita.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; 

    $result = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        if ($password === $row['password']) {
            $_SESSION['login_admin'] = true;
            $_SESSION['admin_user'] = $row['username'];
            
            // MASUK KE HALAMAN ADMIN BERITA
            echo "<script>alert('Login Berhasil!'); window.location='admin_berita.php';</script>";
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - RADIO AAS FM</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #1c3221; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 100%; max-width: 350px; text-align: center; }
        h2 { color: #1c3221; margin-bottom: 20px; font-size: 24px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #1c3221; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #1c3221; color: #f1ece1; border: none; padding: 12px; width: 100%; font-weight: bold; border-radius: 4px; cursor: pointer; margin-top: 10px; font-size: 16px; transition: 0.2s; }
        button:hover { background-color: #2d4f35; }
        .error-msg { color: #ff4d4d; font-size: 14px; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Admin</h2>
    
    <?php if (isset($error)) : ?>
        <div class="error-msg">Username atau Password salah!</div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required placeholder="Masukkan username...">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Masukkan password...">
        </div>
        <button type="submit" name="login">Masuk</button>
        
        <a href="berita.php" style="display: block; margin-top: 15px; color: #1c3221; text-decoration: none; font-size: 14px; font-weight: bold;">
            ← Kembali ke berita
        </a>
    </form>
</div>

</body>
</html>