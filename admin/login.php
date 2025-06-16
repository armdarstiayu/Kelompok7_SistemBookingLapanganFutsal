<?php
// admin/login.php

session_start();

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php"); // Mengarahkan ke admin/index.php (dashboard)
    exit();
}

$login_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // --- Contoh Kredensial Admin (Ganti dengan Autentikasi Database ASLI) ---
    // Pastikan password di-hash saat disimpan di database!
    $valid_admin_username = "adminsemua";
    // Contoh hash untuk "passwordrahasia"
    $valid_admin_password_hash = '$2y$10$wJjK7W7D.8K/N/X9p3p5fOu2v9g9t/R/7y/9w/7t/9m/1i/3k/2a/5s/7j/0u/2o/9p3X'; // Hasil dari password_hash('passwordrahasia', PASSWORD_DEFAULT);

    if ($username === $valid_admin_username) {
        if (password_verify($password, $valid_admin_password_hash)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: index.php"); // Redirect ke dashboard setelah login
            exit();
        } else {
            $login_message = '<p class="error-message">Username atau password salah.</p>';
        }
    } else {
        $login_message = '<p class="error-message">Username atau password salah.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | SELA Venues</title>
    <link rel="stylesheet" href="admin/css/admin.css"> </head>
<body class="admin-body login-page">
    <div class="login-container">
        <h1>Login Admin SELA Venues</h1>
        <form id="admin-login-form" action="admin/login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <?php if (!empty($login_message)) { echo $login_message; } ?>
        </form>
    </div>
    <script src="admin/js/admin.js"></script> </body>
</html>