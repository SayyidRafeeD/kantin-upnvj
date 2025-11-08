<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$pageTitle = "Register Akun | Kantin UPNVJ";
$errorMessage = isset($_GET['error']) ? htmlspecialchars($_GET['error'])." Silakan coba lagi." : null;

require 'includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <a href="index.php" class="auth-logo-link">
            <img src="assets/images/logo.png" alt="Logo UPNVJ" class="auth-logo">
        </a>
        <h1 class="auth-title">Buat Akun Baru</h1>
        <p class="auth-subtitle">Daftar untuk mulai memberi vote.</p>

        <?php if ($errorMessage): ?>
            <div class="auth-message error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form action="api/register_process.php" method="POST" class="auth-form">
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
            <button type="submit" class="auth-button">Daftar</button>
        </form>
        <p class="auth-footer-text">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </p>
    </div>
</div>

<?php
require 'includes/footer.php';
?>