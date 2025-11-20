<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$pageTitle = "Ulasan Saya";
require 'includes/header.php';
?>

<div class="container">
    <h1 class="page-title">Riwayat Ulasan Kamu</h1>

    <div id="reviews-list" class="reviews-container">
        <p style="text-align:center;">Memuat data...</p>
    </div>

    <div id="empty-state" class="empty-state" style="display: none;">
        <div class="empty-icon">🍽️</div>
        <p class="empty-text">Kamu belum pernah memberikan ulasan di kantin manapun.</p>
        <a href="index.php" class="auth-button" style="display:inline-block; width:auto; padding: 0.8rem 2rem; text-decoration:none;">Mulai Jelajah</a>
    </div>
</div>

<div id="edit-modal" class="modal-overlay">
    <div class="modal-box">
        <h3 class="modal-title">Edit Ulasan</h3>
        <textarea id="edit-input" class="modal-textarea" maxlength="200"></textarea>
        <div style="text-align:right; font-size:0.8rem; color:#888;" id="edit-char-count">0/200</div>

        <div class="modal-actions">
            <button class="btn-action btn-cancel" onclick="closeEditModal()">Batal</button>
            <button class="btn-action btn-save" id="btn-save-edit" onclick="saveEdit()">Simpan Perubahan</button>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>

<script src="assets/js/my_reviews.js"></script>