<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-Kantin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Kantin UPNVJ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    
    <div class="auth-container">
        <img src="assets/images/logo.png" alt="Logo UPNVJ" class="auth-logo">
        
        <h2>Daftar Akun</h2>
        <p class="subtitle">Buat akun untuk mulai vote kantin favoritmu.</p>
        
        <?php
        if (isset($_GET['error'])) {
            $errorMsg = "Terjadi kesalahan.";
            if ($_GET['error'] == "empty") {
                $errorMsg = "Semua field wajib diisi.";
            } elseif ($_GET['error'] == "nim_invalid") {
                $errorMsg = "NIM tidak valid.";
            } elseif ($_GET['error'] == "passwords_no_match") {
                $errorMsg = "Konfirmasi password tidak sesuai.";
            } elseif ($_GET['error'] == "nim_terdaftar") {
                $errorMsg = "NIM ini sudah terdaftar.";
            }
            echo '<div class="message error">' . $errorMsg . '</div>';
        }
        ?>
        
        <form action="api/register_process.php" method="POST">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Konfirmasi Password</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>
            <button type="submit" class="auth-button">Daftar</button>
        </form>
        
        <p class="auth-link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </p>
    </div>

</body>
</html>