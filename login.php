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
    <title>Login - Kantin UPNVJ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    
    <div class="auth-container">
        <img src="assets/images/logo.png" alt="Logo UPNVJ" class="auth-logo">
        
        <h2>Selamat Datang</h2>
        <p class="subtitle">Login untuk melanjutkan ke Kantin UPNVJ.</p>
        
        <?php
        if (isset($_GET['error'])) {
            $errorMsg = "NIM atau Password salah."; 
            echo '<div class="message error">' . $errorMsg . '</div>';
        }
        
        if (isset($_GET['status'])) {
            if ($_GET['status'] == "register_sukses") {
                echo '<div class="message success">Registrasi berhasil! Silakan login.</div>';
            }
            if ($_GET['status'] == "logout_sukses") {
                echo '<div class="message success">Anda berhasil logout.</div>';
            }
        }
        ?>
        
        <form action="api/login_process.php" method="POST">
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="auth-button">Login</button>
        </form>
        
        <p class="auth-link">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </p>
    </div>

</body>
</html>