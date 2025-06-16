<?php
// admin/index.php

session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// --- Koneksi Database dan Ambil Data Statistik (Contoh) ---
require_once '../config/database.php'; // Sesuaikan path jika berbeda

$total_venues = 0;
$total_bookings = 0;
$pending_bookings = 0;

try {
    $conn = get_db_connection(); // Fungsi untuk mendapatkan koneksi PDO atau MySQLi

    // Contoh query untuk statistik dashboard
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM venues");
    $total_venues = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $conn->query("SELECT COUNT(*) AS total FROM bookings");
    $total_bookings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $conn->query("SELECT COUNT(*) AS total FROM bookings WHERE status = 'pending'");
    $pending_bookings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

} catch (PDOException $e) {
    // Handle error (log it, show a friendly message)
    error_log("Database error on dashboard: " . $e->getMessage());
    $total_venues = "Error";
    $total_bookings = "Error";
    $pending_bookings = "Error";
}
// --- END Koneksi Database ---

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SELA Venues</title>
    <link rel="stylesheet" href="admin/css/admin.css"> </head>
<body class="admin-body">
    <?php include 'includes/admin_header.php'; ?>

    <div class="admin-wrapper">
        <?php include 'admin/includes/admin_sidebar.php'; ?>

        <main class="admin-main-content">
            <section class="admin-section">
                <h1>Dashboard Admin</h1>
                <p>Selamat datang di panel administrasi SELA Venues. Kelola lapangan dan booking Anda di sini.</p>

                <div class="dashboard-stats">
                    <div class="stat-card">
                        <h3>Total Lapangan</h3>
                        <p class="stat-number"><?php echo htmlspecialchars($total_venues); ?></p>
                        <a href="admin/modules/venues.php" class="stat-link">Lihat Lapangan</a>
                    </div>
                    <div class="stat-card">
                        <h3>Total Booking</h3>
                        <p class="stat-number"><?php echo htmlspecialchars($total_bookings); ?></p>
                        <a href="admin/modules/bookings.php" class="stat-link">Lihat Semua Booking</a>
                    </div>
                    <div class="stat-card pending">
                        <h3>Booking Pending</h3>
                        <p class="stat-number"><?php echo htmlspecialchars($pending_bookings); ?></p>
                        <a href="admin/modules/bookings.php?status=pending" class="stat-link">Proses Booking</a>
                    </div>
                </div>

                <div class="recent-activities">
                    <h2>Aktivitas Terbaru</h2>
                    <p>Belum ada aktivitas terbaru untuk ditampilkan.</p>
                </div>

            </section>
        </main>
    </div>

    <script src="admin/js/admin.js"></script>
</body>
</html>