<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak | SELA Venues</title>
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
        <section class="page-header">
            <h1>Hubungi Kami</h1>
        </section>

        <section class="content-block">
            <p>Ada pertanyaan atau masukan? Jangan ragu untuk menghubungi kami!</p>
            <form class="contact-form">
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Pesan:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit">Kirim Pesan</button>
            </form>
            <div class="contact-info">
                <p><strong>Email:</strong> info@sela-venues.com</p>
                <p><strong>Telepon:</strong> +62 812-3456-7890</p>
                <p><strong>Alamat:</strong> Jl. Jend. Sudirman No. 123, Pekanbaru, Riau</p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 SELA Venues. Semua Hak Dilindungi.</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>