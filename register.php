<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$pageTitle = "Register Akun | DIRKA UPNVJ";
$errorMessage = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;

$errorMap = [
        'password_weak' => 'Password terlalu lemah. Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.',
        'passwords_no_match' => 'Password dan Konfirmasi tidak cocok.',
        'nim_terdaftar' => 'NIM sudah terdaftar.',
        'empty' => 'Semua kolom wajib diisi.'
];
$displayError = isset($errorMap[$errorMessage]) ? $errorMap[$errorMessage] : $errorMessage;

require 'includes/header.php';
?>

    <div class="auth-container">
        <div class="auth-card">
            <a href="index.php" class="auth-logo-link">
                <img src="assets/images/logo.png" alt="Logo UPNVJ" class="auth-logo">
            </a>
            <h1 class="auth-title">Buat Akun Baru</h1>
            <p class="auth-subtitle">Daftar untuk mulai memberi vote.</p>

            <?php if ($displayError): ?>
                <div class="auth-message error"><?php echo $displayError; ?></div>
            <?php endif; ?>

            <form action="api/register_process.php" method="POST" class="auth-form" id="register-form">
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
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">👁️</button>
                    </div>
                    <ul class="password-requirements">
                        <li id="req-length" class="invalid">Min. 8 Karakter</li>
                        <li id="req-number" class="invalid">Kombinasi Angka</li>
                        <li id="req-letter" class="invalid">Kombinasi Huruf</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label for="password_confirm">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>
                    <small id="match-message" style="display:none; color: red; font-size: 0.8rem; margin-top: 4px;">Password tidak cocok</small>
                </div>
                <button type="submit" class="auth-button" id="btn-register">Daftar</button>
            </form>
            <p class="auth-footer-text">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </p>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>