<?php
// admin/modules/bookings.php

session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../../config/database.php'; // Sesuaikan path

$bookings = [];
$booking_message = '';

try {
    $conn = get_db_connection();
    // Contoh: Ambil semua booking atau filter berdasarkan status
    $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
    $sql = "SELECT b.*, v.name AS venue_name, v.sport FROM bookings b JOIN venues v ON b.venue_id = v.id";
    $params = [];
    if (!empty($status_filter)) {
        $sql .= " WHERE b.status = ?";
        $params[] = $status_filter;
    }
    $sql .= " ORDER BY b.booking_date DESC, b.start_time DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Error fetching bookings: " . $e->getMessage());
    $booking_message = '<p class="error-message">Gagal mengambil data booking dari database.</p>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Booking | SELA Venues Admin</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body class="admin-body">
    <?php include '../includes/admin_header.php'; ?>

    <div class="admin-wrapper">
        <?php include '../includes/admin_sidebar.php'; ?>

        <main class="admin-main-content">
            <section class="admin-section">
                <h1>Manajemen Booking Lapangan</h1>
                <div class="booking-filters">
                    <a href="bookings.php" class="filter-btn <?php echo empty($status_filter) ? 'active' : ''; ?>">Semua</a>
                    <a href="bookings.php?status=pending" class="filter-btn <?php echo ($status_filter == 'pending') ? 'active' : ''; ?>">Pending</a>
                    <a href="bookings.php?status=confirmed" class="filter-btn <?php echo ($status_filter == 'confirmed') ? 'active' : ''; ?>">Dikonfirmasi</a>
                    <a href="bookings.php?status=completed" class="filter-btn <?php echo ($status_filter == 'completed') ? 'active' : ''; ?>">Selesai</a>
                    <a href="bookings.php?status=cancelled" class="filter-btn <?php echo ($status_filter == 'cancelled') ? 'active' : ''; ?>">Dibatalkan</a>
                </div>

                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Booking</th>
                                <th>Lapangan</th>
                                <th>Pengguna</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td data-label="ID Booking"><?php echo htmlspecialchars($booking['id']); ?></td>
                                        <td data-label="Lapangan"><?php echo htmlspecialchars($booking['venue_name'] . ' (' . $booking['sport'] . ')'); ?></td>
                                        <td data-label="Pengguna"><?php echo htmlspecialchars($booking['user_name']); ?></td>
                                        <td data-label="Tanggal"><?php echo htmlspecialchars(date('d M Y', strtotime($booking['booking_date']))); ?></td>
                                        <td data-label="Waktu"><?php echo htmlspecialchars(date('H:i', strtotime($booking['start_time'])) . ' - ' . date('H:i', strtotime($booking['end_time']))); ?></td>
                                        <td data-label="Total Harga">Rp <?php echo number_format($booking['total_price'], 0, ',', '.'); ?></td>
                                        <td data-label="Status">
                                            <span class="status-badge status-<?php echo strtolower($booking['status']); ?>">
                                                <?php echo htmlspecialchars(ucfirst($booking['status'])); ?>
                                            </span>
                                        </td>
                                        <td data-label="Aksi">
                                            <?php if ($booking['status'] == 'pending'): ?>
                                                <button class="action-btn confirm-btn" data-id="<?php echo $booking['id']; ?>">Konfirmasi</button>
                                                <button class="action-btn cancel-btn" data-id="<?php echo $booking['id']; ?>">Batalkan</button>
                                            <?php elseif ($booking['status'] == 'confirmed'): ?>
                                                <button class="action-btn complete-btn" data-id="<?php echo $booking['id']; ?>">Selesai</button>
                                            <?php endif; ?>
                                            <button class="action-btn view-btn" data-id="<?php echo $booking['id']; ?>">Lihat</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="8">Belum ada booking yang ditemukan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <p id="table-message" class="message"><?php echo $booking_message; ?></p>
                </div>
            </section>
        </main>
    </div>

    <script src="../../js/admin.js"></script>
</body>
</html>