<?php
// admin/modules/venues.php

session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php"); // Kembali ke login jika belum login
    exit();
}

require_once '../../config/database.php'; // Sesuaikan path ke file database.php

$venues = [];
try {
    $conn = get_db_connection();
    $stmt = $conn->query("SELECT * FROM venues ORDER BY id DESC");
    $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching venues: " . $e->getMessage());
    // Optionally display an error message to the admin
    $venues_message = '<p class="error-message">Gagal mengambil data lapangan dari database.</p>';
}

$venues_message = isset($venues_message) ? $venues_message : ''; // Ensure message is defined
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Lapangan | SELA Venues Admin</title>
    <link rel="stylesheet" href="../../css/admin.css"> </head>
<body class="admin-body">
    <?php include '../includes/admin_header.php'; ?>

    <div class="admin-wrapper">
        <?php include '../includes/admin_sidebar.php'; ?>

        <main class="admin-main-content">
            <section class="admin-section">
                <h1>Manajemen Lapangan Olahraga</h1>
                <button id="add-venue-button" class="add-btn">Tambah Lapangan Baru</button>

                <div class="venue-form-modal" id="venue-form-modal">
                    <div class="modal-content">
                        <span class="close-button">&times;</span>
                        <h2 id="form-title">Tambah Lapangan</h2>
                        <form id="venue-crud-form" action="../actions/process_venue.php" method="POST">
                            <input type="hidden" id="venue-id" name="id">
                            <div class="form-group">
                                <label for="venue-name">Nama Lapangan:</label>
                                <input type="text" id="venue-name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="venue-sport">Jenis Olahraga:</label>
                                <select id="venue-sport" name="sport" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="Futsal">Futsal</option>
                                    <option value="Badminton">Badminton</option>
                                    <option value="Basket">Basket</option>
                                    <option value="Tenis">Tenis</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="venue-address">Alamat:</label>
                                <input type="text" id="venue-address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label for="venue-city">Kota:</label>
                                <input type="text" id="venue-city" name="city" value="Pekanbaru" required>
                            </div>
                            <div class="form-group">
                                <label for="venue-price">Harga Per Jam (Rp):</label>
                                <input type="number" id="venue-price" name="price" step="1000" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="venue-description">Deskripsi:</label>
                                <textarea id="venue-description" name="description" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="venue-image">URL Gambar:</label>
                                <input type="url" id="venue-image" name="image" placeholder="Contoh: https://example.com/gambar.jpg">
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
                            <?php if (!empty($venues)): ?>
                                <?php foreach ($venues as $venue): ?>
                                    <tr>
                                        <td data-label="ID"><?php echo htmlspecialchars($venue['id']); ?></td>
                                        <td data-label="Nama Lapangan"><?php echo htmlspecialchars($venue['name']); ?></td>
                                        <td data-label="Olahraga"><?php echo htmlspecialchars($venue['sport']); ?></td>
                                        <td data-label="Alamat"><?php echo htmlspecialchars($venue['address']); ?></td>
                                        <td data-label="Harga/Jam">Rp <?php echo number_format($venue['price'], 0, ',', '.'); ?></td>
                                        <td data-label="Aksi">
                                            <button class="edit-btn" data-id="<?php echo $venue['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($venue['name']); ?>"
                                                    data-sport="<?php echo htmlspecialchars($venue['sport']); ?>"
                                                    data-address="<?php echo htmlspecialchars($venue['address']); ?>"
                                                    data-city="<?php echo htmlspecialchars($venue['city']); ?>"
                                                    data-price="<?php echo htmlspecialchars($venue['price']); ?>"
                                                    data-description="<?php echo htmlspecialchars($venue['description']); ?>"
                                                    data-image="<?php echo htmlspecialchars($venue['image']); ?>">Edit</button>
                                            <button class="delete-btn" data-id="<?php echo $venue['id']; ?>">Hapus</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">Belum ada lapangan yang ditambahkan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <p id="table-message" class="message"><?php echo $venues_message; ?></p>
                </div>
            </section>
        </main>
    </div>

    <script src="../../js/admin.js"></script> </body>
</html>