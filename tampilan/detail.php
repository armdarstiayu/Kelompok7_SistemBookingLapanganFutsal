<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lapangan | SELA Venues</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">SELA</div>
            <ul>
                <li><a href="index.html">Beranda</a></li>
                <li><a href="venues.html">Cari Lapangan</a></li>
                <li><a href="about.html">Tentang Kami</a></li>
                <li><a href="contact.html">Kontak</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="page-header">
            <h1>Detail Lapangan</h1>
        </section>

        <section class="venue-detail-content">
            <div class="venue-image">
                <img id="detail-venue-img" src="https://via.placeholder.com/600x400/ADD8E6/000000?text=Detail+Lapangan" alt="Nama Lapangan">
            </div>
            <div class="venue-info">
                <h2 id="detail-venue-name">Nama Lapangan</h2>
                <p><strong class="label">Jenis Olahraga:</strong> <span id="detail-venue-sport"></span></p>
                <p><strong class="label">Alamat:</strong> <span id="detail-venue-address"></span></p>
                <p><strong class="label">Harga Per Jam:</strong> Rp <span id="detail-venue-price"></span></p>
                <p><strong class="label">Deskripsi:</strong> <span id="detail-venue-description"></span></p>
                <button class="booking-button">Booking Sekarang</button>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 SELA Venues. Semua Hak Dilindungi.</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>