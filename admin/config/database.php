<?php
// config/database.php

function get_db_connection() {
    $host = 'localhost'; // Ganti jika database Anda di server lain
    $db   = 'seladatabase'; // Ganti dengan nama database Anda
    $user = 'root'; // Ganti dengan username database Anda
    $pass = ''; // Ganti dengan password database Anda
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (\PDOException $e) {
        // Log error and terminate
        error_log("Database connection failed: " . $e->getMessage());
        // In a production environment, you might just show a generic error page
        die("Koneksi database gagal. Silakan coba lagi nanti.");
    }
}
?>