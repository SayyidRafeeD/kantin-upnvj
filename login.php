<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$pageTitle = "Login | Kantin UPNVJ";
$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;
require 'includes/header.php';
?>

    <div class="auth-container">
        <div class="auth-card">
            <a href="index.php" class="auth-logo-link">
                <img src="assets/images/logo.png" alt="Logo UPNVJ" class="auth-logo">
            </a>
            <h1 class="auth-title">Login Akun</h1>
            <p class="auth-subtitle">Selamat datang kembali!</p>

            <?php if ($successMessage): ?>
                <div class="auth-message success"><?php echo $successMessage; ?></div>
            <?php endif; ?>

            <div id="login-popup" class="popup-overlay" style="display: none;">
                <div class="popup-content error">
                    <span id="popup-message">Error message here</span>
                    <button class="popup-close" onclick="document.getElementById('login-popup').style.display='none'">&times;</button>
                </div>
            </div>

            <form id="login-form" class="auth-form">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="auth-button" id="btn-login">Login</button>
            </form>
            <p class="auth-footer-text">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </p>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>