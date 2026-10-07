<?php 
include 'koneksi_crew.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREW AAS FM</title>
    <style>
        body { 
            /* 🎨 BACKGROUND HIJAU UTAMA */
            background-color: #365745; 
            color: #f1ece1; 
            font-family: sans-serif; 
            padding: 40px 20px; 
            margin: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .header-title h1 {
            margin: 0;
            font-size: 36px;
            color: #ffc107;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        .header-title p {
            color: #cedfd1;
            margin-top: 8px;
            font-size: 15px;
        }

        .division-block {
            margin-bottom: 50px;
        }

        /* 🛠️ PERBAIKAN: Tulisan divisi diubah menjadi warna ABU-ABU */
        .division-title {
            font-size: 22px;
            color: #cccccc; /* DIUBAH: Abu-abu terang */
            text-transform: uppercase;
            margin-bottom: 25px;
            letter-spacing: 1px;
            font-weight: bold;
            text-align: center; 
        }

        .crew-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center; 
        }

        .crew-card {
            /* 🟩 KOTAK SEWARNA DENGAN BACKGROUND */
            background-color: #365745;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            width: 280px;
            box-sizing: border-box;
            
            /* Border tipis & shadow halus agar tetap terlihat batas kotaknya */
            border: 1px solid rgba(241, 236, 225, 0.25);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .crew-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
            border-color: rgba(204, 204, 204, 0.5); /* Border berubah abu-abu saat di-hover */
        }

        .crew-img-container {
            width: 140px;
            height: 140px;
            margin: 0 auto 20px;
            position: relative;
        }

        .crew-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid #f1ece1;
            object-fit: cover;
        }

        /* 🛠️ PERBAIKAN: Tulisan nama crew diubah menjadi warna ABU-ABU */
        .crew-name {
            font-size: 20px;
            font-weight: bold;
            color: #cccccc; /* DIUBAH: Abu-abu terang */
            margin: 15px 0 8px 0;
            line-height: 1.3;
        }

        /* 🛠️ PERBAIKAN: Tulisan nama siar diubah menjadi warna ABU-ABU */
        .crew-siar {
            font-size: 15px;
            color: #cccccc; /* DIUBAH: Abu-abu terang */
            font-style: italic;
        }

        /* 🌐 AREA TOMBOL NAVIGASI BAWAH */
        .footer-nav {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 60px;
            border-top: 1px solid rgba(251, 236, 225, 0.15);
            padding-top: 30px;
        }

        .nav-link {
            color: #ffc107;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .nav-link:hover { 
            color: #f1ece1;
            text-decoration: underline; 
        }
    </style>
</head>
<body>

<div class="container">
    
    <div class="header-title">
        <h1>CREW AAS FM</h1>
        <p>Orang-orang kreatif di balik layar kaca udara Radio AAS FM</p>
    </div>

    <?php
    // 1. Ambil data dari database
    $query = mysqli_query($conn, "SELECT * FROM crew ORDER BY id ASC");
    
    // 2. Kelompokkan berdasarkan jabatan
    $divisi_group = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $divisi_group[$row['jabatan']][] = $row;
    }

    // 3. Urutan Struktur Organisasi Baku
    $susunan_baku = [
        'ketua', 
        'wakil', 
        'sekretaris', 
        'bendahara', 
        'script writer', 
        'on air', 
        'off air', 
        'music director', 
        'media', 
        'marketing'
    ];

    uksort($divisi_group, function($a, $b) use ($susunan_baku) {
        $index_a = 999; 
        $index_b = 999;
        
        foreach ($susunan_baku as $key => $val) {
            if (stripos($a, $val) !== false) { $index_a = $key; break; }
        }
        foreach ($susunan_baku as $key => $val) {
            if (stripos($b, $val) !== false) { $index_b = $key; break; }
        }
        return $index_a - $index_b;
    });

    // 4. Render Tampilan
    if (!empty($divisi_group)) {
        foreach ($divisi_group as $nama_divisi => $anggota_crew) {
            ?>
            <div class="division-block">
                <div class="division-title"><?php echo htmlspecialchars($nama_divisi); ?></div>
                
                <div class="crew-grid">
                    <?php
                    foreach ($anggota_crew as $row) {
                        $foto_src = (!empty($row['foto'])) ? $row['foto'] : 'images/default-avatar.jpg';
                        ?>
                        
                        <div class="crew-card">
                            <div class="crew-img-container">
                                <img src="<?php echo htmlspecialchars($foto_src); ?>" alt="Foto Crew" class="crew-img">
                            </div>
                            
                            <div class="crew-name">
                                <?php echo htmlspecialchars($row['nama_lengkap']); ?>
                            </div>
                            
                            <div class="crew-siar">Nama Siar: <?php echo htmlspecialchars($row['nama_siar']); ?></div>
                        </div>

                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p style='text-align:center; color:#cedfd1;'>Belum ada data crew yang dimasukkan.</p>";
    }
    ?>

    <div class="footer-nav">
        <a href="index.html" class="nav-link">← Kembali ke Beranda</a>
        <a href="admin_crew.php" class="nav-link">Masuk Panel Pengurus →</a>
    </div>
</div>

</body>
</html>