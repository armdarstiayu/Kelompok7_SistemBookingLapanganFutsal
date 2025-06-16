<?php
// admin/actions/process_booking.php

session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : ''; // 'confirm', 'cancel', 'complete'
    $booking_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($booking_id <= 0 || empty($action)) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak valid.']);
        exit();
    }

    try {
        $conn = get_db_connection();
        $new_status = '';
        $message = '';

        switch ($action) {
            case 'confirm':
                $new_status = 'confirmed';
                $message = 'Booking berhasil dikonfirmasi!';
                break;
            case 'cancel':
                $new_status = 'cancelled';
                $message = 'Booking berhasil dibatalkan!';
                break;
            case 'complete':
                $new_status = 'completed';
                $message = 'Booking berhasil diselesaikan!';
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Aksi tidak dikenal.']);
                exit();
        }

        $stmt = $conn->prepare("UPDATE bookings SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$new_status, $booking_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => $message]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status booking. Mungkin booking tidak ditemukan atau sudah dalam status tersebut.']);
        }

    } catch (PDOException $e) {
        error_log("Database error in process_booking: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan database: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak diizinkan.']);
}
exit();
?>