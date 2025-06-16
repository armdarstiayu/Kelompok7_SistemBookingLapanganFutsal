<?php
// admin/actions/process_venue.php

session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : 'add'; // 'add', 'edit', 'delete'
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; // ID untuk edit/hapus

    try {
        $conn = get_db_connection();

        if ($action == 'add' || $action == 'edit') {
            $name = trim($_POST['name']);
            $sport = trim($_POST['sport']);
            $address = trim($_POST['address']);
            $city = trim($_POST['city']);
            $price = (int)$_POST['price'];
            $description = trim($_POST['description']);
            $image = trim($_POST['image']);

            if (empty($name) || empty($sport) || empty($address) || empty($city) || $price < 0) {
                echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi kecuali deskripsi dan gambar, dan harga tidak boleh negatif.']);
                exit();
            }

            if ($action == 'add') {
                $stmt = $conn->prepare("INSERT INTO venues (name, sport, address, city, price, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $sport, $address, $city, $price, $description, $image]);
                echo json_encode(['status' => 'success', 'message' => 'Lapangan berhasil ditambahkan!', 'id' => $conn->lastInsertId()]);
            } else { // action == 'edit'
                $stmt = $conn->prepare("UPDATE venues SET name = ?, sport = ?, address = ?, city = ?, price = ?, description = ?, image = ? WHERE id = ?");
                $stmt->execute([$name, $sport, $address, $city, $price, $description, $image, $id]);
                echo json_encode(['status' => 'success', 'message' => 'Lapangan berhasil diperbarui!']);
            }
        } elseif ($action == 'delete') {
            if ($id <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'ID lapangan tidak valid untuk dihapus.']);
                exit();
            }
            $stmt = $conn->prepare("DELETE FROM venues WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'success', 'message' => 'Lapangan berhasil dihapus!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid.']);
        }

    } catch (PDOException $e) {
        error_log("Database error in process_venue: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan database: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak diizinkan.']);
}
exit();
?>