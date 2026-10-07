<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AAS FM NEWS</title>
    <link rel="stylesheet" href="templatemo-amber-folio.css">
    <style>
        /* Mengambil font Poppins agar sama dengan halaman beranda */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        /* Terapkan font ke seluruh halaman berita */
        .berita-page-section, 
        .berita-page-section * {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Background Utama Hijau Sage */
        .berita-page-section {
            padding: 120px 0 80px 0;
            min-height: 80vh;
            background-color: #5c7c5d !important; 
        }

        .services-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 30px !important;
            width: 90% !important;
            max-width: 1200px !important;
            margin: 0 auto !important;
        }

        /* KARTU COKELAT DENGAN SUDUT MELENGKUNG LEBAR */
        .service-card {
            display: flex !important;
            flex-direction: column !important;
            background: #b29471 !important; 
            padding: 30px 25px;
            border-radius: 30px !important; 
            transition: all 0.4s ease;
            text-decoration: none !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        /* KARTU SAAT DISOROT (Hover) - BERUBAH JADI HITAM */
        .service-card:hover {
            background: #1a1a1a !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        /* Gambar di dalam kartu */
        .news-image {
            width: 100% !important;
            height: 200px !important;
            object-fit: cover !important;
            border-radius: 15px !important; 
            margin-bottom: 25px;
            display: block !important;
        }

        /* Judul Berita */
        .service-title { 
            font-size: 20px; 
            font-weight: 600; 
            margin-bottom: 20px; 
            color: #ffffff !important; 
            text-align: center; 
            line-height: 1.4;
        }
        
        /* Deskripsi Berita */
        .service-description { 
            font-size: 14px; 
            font-weight: 400;
            color: rgba(255, 255, 255, 0.9) !important; 
            margin-bottom: 25px; 
            line-height: 1.7;
            text-align: center; 
        }

        /* Tombol Baca Selengkapnya */
        .service-price { 
            font-weight: 600; 
            text-transform: uppercase; 
            font-size: 13px; 
            margin-top: auto;
            color: rgba(255, 255, 255, 0.8) !important;
            letter-spacing: 1px;
            text-align: center; 
        }

        .action-buttons-container {
            text-align: center;
            margin-top: 60px;
            display: flex;
            justify-content: center;
            gap: 40px;
            width: 100%;
        }
        
        .btn-link-bawah {
            color: #ffffff !important; 
            font-weight: 600;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <header id="header" class="fixed-header">
        <nav>
            <a href="index.html#home" class="logo">
                <img src="images/logo.png" width="60px" height="50px" alt="Logo">
                RADIO AAS FM
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.html#home">Home</a></li>
                <li><a href="index.html#portfolio">Broadcast Program</a></li>
                <li><a href="index.html#about">About AAS FM</a></li>
                <li><a href="index.html#streaming">Streaming</a></li>
                <li><a href="index.html#services" class="active">News</a></li>
            </ul>
        </nav>
    </header>

    <section class="services-section berita-page-section" id="all-news">
        <div class="services-container">
            <div class="section-header" style="text-align: center; margin-bottom: 40px;">
                <h2 class="section-title" style="color: #ffffff; font-weight: 700;">See Other News</h2>
            </div>

            <div class="services-grid">
                <?php
                // Mengirim koneksi (Sesuaikan nama file jika memakai koneksi_crew.php)
                if (file_exists('koneksi_crew.php')) {
                    include 'koneksi_crew.php';
                } else {
                    include 'koneksi.php';
                }

                // Cek nama variabel koneksi ($conn atau $koneksi)
                $db_conn = isset($conn) ? $conn : (isset($koneksi) ? $koneksi : null);

                if ($db_conn) {
                    $query = mysqli_query($db_conn, "SELECT * FROM berita ORDER BY id DESC");

                    if ($query && mysqli_num_rows($query) > 0) {
                        while($data = mysqli_fetch_assoc($query)) {
                            // Mendukung nama kolom 'gambar' maupun 'foto'
                            $gambar_file = !empty($data['gambar']) ? $data['gambar'] : (!empty($data['foto']) ? $data['foto'] : 'berita1.jpg');
                            
                            // Menyesuaikan jika di database tersimpan dengan prefix "images/" atau tidak
                            $path_gambar = (strpos($gambar_file, 'images/') === 0) ? $gambar_file : 'images/' . $gambar_file;

                            // Mendukung nama kolom 'link' maupun 'link_eksternal'
                            $link_tujuan = !empty($data['link']) ? $data['link'] : (!empty($data['link_eksternal']) ? $data['link_eksternal'] : '#');
                            ?>

                            <a href="<?php echo htmlspecialchars($link_tujuan); ?>" target="_blank" class="service-card">
                                <img src="<?php echo htmlspecialchars($path_gambar); ?>" class="news-image" alt="Berita">
                                <h3 class="service-title"><?php echo htmlspecialchars($data['judul']); ?></h3>
                                <p class="service-description"><?php echo htmlspecialchars($data['deskripsi']); ?></p>
                                <div class="service-price">BACA SELENGKAPNYA →</div>
                            </a>

                            <?php
                        }
                    } else {
                        echo "<p style='color: #ffffff; text-align: center; grid-column: 1 / -1;'>Belum ada berita yang diunggah.</p>";
                    }
                }
                ?>
            </div>

            <div class="action-buttons-container">
                <a href="index.html#services" class="btn-link-bawah">← Kembali ke Beranda</a>
                <a href="login.php" class="btn-link-bawah">Masuk admin berita →</a>
            </div>
        </div>
    </section>
</body>
</html>