   <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SELA Venues</title>
    <link rel="stylesheet" href="../css/style.css"> <link rel="stylesheet" href="../css/admin.css"> </head>
<body class="admin-body">
    <header class="admin-header">
        <div class="admin-logo">SELA Admin</div>
        <nav class="admin-nav">
            <span id="welcome-message">Selamat Datang, Admin!</span>
            <button id="logout-button" class="logout-btn">Logout</button>
        </nav>
    </header>

    <main class="admin-main">
        <section class="admin-section">
            <h1>Manajemen Lapangan Olahraga</h1>
            <button id="add-venue-button" class="add-btn">Tambah Lapangan Baru</button>

            <div class="venue-form-modal" id="venue-form-modal">
                <div class="modal-content">
                    <span class="close-button">&times;</span>
                    <h2 id="form-title">Tambah Lapangan</h2>
                    <form id="venue-crud-form">
                        <input type="hidden" id="venue-id">
                        <div class="form-group">
                            <label for="venue-name">Nama Lapangan:</label>
                            <input type="text" id="venue-name" required>
                        </div>
                        <div class="form-group">
                            <label for="venue-sport">Jenis Olahraga:</label>
                            <select id="venue-sport" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Futsal">Futsal</option>
                                <option value="Badminton">Badminton</option>
                                <option value="Basket">Basket</option>
                                <option value="Tenis">Tenis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="venue-address">Alamat:</label>
                            <input type="text" id="venue-address" required>
                        </div>
                        <div class="form-group">
                            <label for="venue-city">Kota:</label>
                            <input type="text" id="venue-city" value="Pekanbaru" required>
                        </div>
                        <div class="form-group">
                            <label for="venue-price">Harga Per Jam (Rp):</label>
                            <input type="number" id="venue-price" step="1000" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="venue-description">Deskripsi:</label>
                            <textarea id="venue-description" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="venue-image">URL Gambar:</label>
                            <input type="url" id="venue-image" placeholder="Contoh: https://example.com/gambar.jpg">
                        </div>
                        <button type="submit" id="form-submit-button">Simpan Lapangan</button>
                        <p id="form-message" class="message"></p>
                    </form>
                </div>
            </div>

            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lapangan</th>
                            <th>Olahraga</th>
                            <th>Alamat</th>
                            <th>Harga/Jam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="venues-table-body">
                        </tbody>
                </table>
                <p id="table-message" class="message"></p>
            </div>
        </section>
    </main>

    <script src="../js/admin.js"></script>
</body>
</html>