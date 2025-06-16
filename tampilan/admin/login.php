<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | SELA Venues</title>
    <link rel="stylesheet" href="../css/style.css"> <link rel="stylesheet" href="../css/admin.css"> </head>
<body class="admin-body">
    <div class="login-container">
        <h1>Login Admin SELA Venues</h1>
        <form id="admin-login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <p id="login-message" class="message"></p>
        </form>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>