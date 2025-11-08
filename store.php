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

$stmt_user_vote = $conn->prepare("SELECT vote_id FROM votes WHERE store_id = ? AND user_id = ?");
$stmt_user_vote->bind_param("ii", $store_id, $user_id);
$stmt_user_vote->execute();
$user_has_voted = $stmt_user_vote->get_result()->num_rows > 0;

require 'includes/header.php';
?>

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
                    data-store-id="<?php echo $store_id; ?>"
                    <?php if ($user_has_voted) echo 'disabled'; ?>
                >
                    <?php if ($user_has_voted) echo 'Anda Sudah Vote'; else echo 'Beri Suara!'; ?>
                </button>
            </div>
            <p id="vote-message" style="text-align: right; color: var(--text-secondary); font-size: 0.9em; margin-top: 5px;"></p>

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