<?php
$pageTitle = "Detail Toko";
require 'includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$store_id = (int)$_GET['id'];

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$stmt_store = $conn->prepare(
        "SELECT s.store_name, s.description, s.image_url, c.canteen_name 
     FROM stores s 
     JOIN canteens c ON s.canteen_id = c.canteen_id 
     WHERE s.store_id = ?"
);
$stmt_store->bind_param("i", $store_id);
$stmt_store->execute();
$result_store = $stmt_store->get_result();

if ($result_store->num_rows == 0) {
    header("Location: index.php");
    exit();
}
$store = $result_store->fetch_assoc();

$pageTitle = $store['store_name'];

$stmt_menu = $conn->prepare("SELECT item_name, price FROM menu_items WHERE store_id = ?");
$stmt_menu->bind_param("i", $store_id);
$stmt_menu->execute();
$result_menu = $stmt_menu->get_result();

$stmt_total_votes = $conn->prepare("SELECT COUNT(vote_id) as total_votes FROM votes WHERE store_id = ?");
$stmt_total_votes->bind_param("i", $store_id);
$stmt_total_votes->execute();
$total_votes = $stmt_total_votes->get_result()->fetch_assoc()['total_votes'];

$today = date('Y-m-d');
$stmt_user_vote = $conn->prepare("SELECT vote_id FROM votes WHERE store_id = ? AND user_id = ? AND vote_date = ?");
$stmt_user_vote->bind_param("iis", $store_id, $user_id, $today);
$stmt_user_vote->execute();
$user_has_voted_today = $stmt_user_vote->get_result()->num_rows > 0;

require 'includes/header.php';
?>

<input type="hidden" id="store-id-hidden" value="<?php echo $store_id; ?>">

<div class="store-detail-container">

    <img src="<?php echo htmlspecialchars($store['image_url'] ?? 'https://placehold.co/800x400/ddd/777?text=Gambar+Toko'); ?>"
         alt="<?php echo htmlspecialchars($store['store_name']); ?>"
         class="store-header-image">

    <div class="store-detail-grid">

        <div class="store-info">
            <h1><?php echo htmlspecialchars($store['store_name']); ?></h1>
            <p class="location"><?php echo htmlspecialchars($store['canteen_name']); ?></p>

            <p class="description"><?php echo nl2br(htmlspecialchars($store['description'])); ?></p>

            <hr style="border: 0; border-top: 1px solid var(--light-gray); margin: 1.5rem 0;">

            <div class="vote-area">
                <div class="vote-count">
                    <strong id="vote-count-display"><?php echo $total_votes; ?></strong> suara
                </div>

                <button
                        class="vote-button"
                        id="vote-button"
                        <?php if ($user_has_voted_today) echo 'disabled'; ?>
                >
                    <?php if ($user_has_voted_today) echo 'Vote Lagi Besok'; else echo 'Beri Suara!'; ?>
                </button>
            </div>
            <p id="vote-message"></p>

            <div class="comments-section">
                <h3>Ulasan & Komentar</h3>

                <div class="comment-form-wrapper">
                    <form id="comment-form">
                        <textarea id="comment-input" class="comment-textarea" placeholder="Tulis pengalaman makanmu di sini... (Maks 200 karakter)" maxlength="200"></textarea>
                        <div class="form-footer">
                            <span class="char-count" id="char-count">0/200</span>
                            <button type="submit" class="btn-submit-comment">Kirim</button>
                        </div>
                    </form>
                </div>

                <div id="comments-list" class="comments-list">
                    <p class="no-comments">Memuat komentar...</p>
                </div>
            </div>

        </div>

        <div class="menu-container">
            <h2>Daftar Menu</h2>
            <?php if ($result_menu->num_rows > 0): ?>
                <ul class="menu-list">
                    <?php while($menu = $result_menu->fetch_assoc()): ?>
                        <li class="menu-item">
                            <span class="item-name"><?php echo htmlspecialchars($menu['item_name']); ?></span>
                            <span class="item-price">Rp <?php echo number_format($menu['price'], 0, ',', '.'); ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Belum ada menu yang terdaftar untuk toko ini.</p>
            <?php endif; ?>
        </div>

    </div>

</div>

<?php
$stmt_store->close();
$stmt_menu->close();
$stmt_total_votes->close();
$stmt_user_vote->close();
$conn->close();

require 'includes/footer.php';
?>

<script src="assets/js/detail.js"></script>