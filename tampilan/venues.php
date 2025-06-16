<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Lapangan | SELA Venues</title>
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
            <h1>Cari Lapangan Olahraga</h1>
            <p>Jelajahi berbagai pilihan lapangan di Pekanbaru.</p>
        </section>

        <section class="venue-list">
            <div class="filters">
                <h3>Filter Pencarian</h3>
                <label for="sport-filter">Jenis Olahraga:</label>
                <select id="sport-filter">
                    <option value="">Semua</option>
                    <option value="Futsal">Futsal</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Basket">Basket</option>
                </select>

                <label for="location-filter">Lokasi:</label>
                <input type="text" id="location-filter" placeholder="Contoh: Panam">

                <button id="apply-filters">Terapkan Filter</button>
            </div>

            <div id="all-venues-container">
                <h2>Semua Lapangan Tersedia</h2>
                <div class="venues-grid" id="all-venues-list">
                    </div>
            </div>

            <hr> <div class="category-group">
                <h2>Lapangan Futsal</h2>
                <div class="venues-grid" id="futsal-venues-list">
                    </div>
                <div class="see-more-link">
                    <a href="venues.html?sport=Futsal">Lihat Semua Lapangan Futsal &raquo;</a>
                </div>
            </div>

            <hr>

            <div class="category-group">
                <h2>Lapangan Badminton</h2>
                <div class="venues-grid" id="badminton-venues-list">
                    </div>
                <div class="see-more-link">
                    <a href="venues.html?sport=Badminton">Lihat Semua Lapangan Badminton &raquo;</a>
                </div>
            </div>

            <hr>

            <div class="category-group">
                <h2>Lapangan Basket</h2>
                <div class="venues-grid" id="basket-venues-list">
                    </div>
                <div class="see-more-link">
                    <a href="venues.html?sport=Basket">Lihat Semua Lapangan Basket &raquo;</a>
                </div>
            </div>

            <hr>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 SELA Venues. Semua Hak Dilindungi.</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>