<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | SELA Venues</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">SELA</div>
            <ul>

                <li><a href="index.php">Beranda</a></li>
                <li><a href="venues.php">Cari Lapangan</a></li>
                <li><a href="about.php">Tentang Kami</a></li>
                <li><a href="contact.php">Kontak</a></li>

            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Temukan & Booking Lapangan Olahraga Disekitarmu!</h1>
            <p>Pesan lapangan Futsal, Badminton, Basket, dengan mudah di Pekanbaru.</p>
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Cari berdasarkan lokasi atau jenis lapangan...">
                <button id="search-button">Cari</button>
            </div>
        </section>

        <section class="venue-categories">
            <h2>Pilihan Olahraga Favorit</h2>
            <div class="categories-grid">
                <div class="category-item">
                    <img src="gambar/futsal1.jpg" alt="Futsal">
                    <h3>Futsal</h3>
                </div>
                <div class="category-item">
                    <img src="gambar/badmin1.jpg" alt="Badminton">
                    <h3>Badminton</h3>
                </div>
                <div class="category-item">
                    <img src="gambar/basket1.jpg" alt="Basket">
                    <h3>Basket</h3>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 SELA Venues. Semua Hak Dilindungi.</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>