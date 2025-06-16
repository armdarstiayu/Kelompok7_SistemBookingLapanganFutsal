<?php
// admin/includes/admin_header.php

// Pastikan sesi sudah dimulai di halaman yang menyertakan header ini
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ambil username dari sesi
$admin_username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';
?>
<header class="admin-header">
    <div class="admin-logo">SELA Admin</div>
    <nav class="admin-nav">
        <span id="welcome-message">Selamat Datang, <?php echo htmlspecialchars($admin_username); ?>!</span>
        <button id="logout-button" class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </nav>
</header>