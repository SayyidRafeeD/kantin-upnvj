<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$pageTitle = "Dashboard"; 

require 'includes/db_connect.php';

$query_stores = 
    "SELECT 
        s.store_id, 
        s.store_name, 
        s.image_url, 
        c.canteen_name, 
        COUNT(DISTINCT v.vote_id) as total_votes
     FROM stores s
     JOIN canteens c ON s.canteen_id = c.canteen_id
     LEFT JOIN votes v ON s.store_id = v.store_id
     GROUP BY s.store_id
     ORDER BY s.store_name ASC"; 

$result_stores = $conn->query($query_stores);

require 'includes/header.php';
?>

<h1 class="page-title">Cari Toko Favoritmu</h1>

<div class="search-container">
    <form class="search-bar" id="search-form">
        <button type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </button>
        <input type="text" id="search-input" placeholder="Ketik nama toko atau menu...">
    </form>

    <div class="sort-wrapper">
        <select id="sort-select">
            <option value="alphabet_asc">Nama (A-Z)</option>
            <option value="alphabet_desc">Nama (Z-A)</option>
            <option value="vote_desc">Vote Terbanyak</option>
            <option value="vote_asc">Vote Terendah</option>
        </select>
    </div>
</div>

<section class="store-grid" id="store-grid-container">
    <?php if ($result_stores && $result_stores->num_rows > 0): ?>
        <?php while($store = $result_stores->fetch_assoc()): ?>
            <article class="store-card">
                <div class="card-image-wrapper">
                    <img src="<?php echo htmlspecialchars($store['image_url'] ?? 'https://placehold.co/400x250/ddd/777?text=Gambar+Toko'); ?>" 
                         alt="<?php echo htmlspecialchars($store['store_name']); ?>" 
                         class="card-image"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/400x250/ddd/777?text=Error+Load';">
                </div>
                <div class="card-content">
                    <h3 class="card-title"><?php echo htmlspecialchars($store['store_name']); ?></h3>
                    <p class="card-location"><?php echo htmlspecialchars($store['canteen_name']); ?></p>
                    <div class="card-footer">
                        <span class="card-votes"><?php echo $store['total_votes']; ?> suara</span>
                        <a href="store.php?id=<?php echo $store['store_id']; ?>" class="card-button">Lihat Menu</a>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Belum ada toko yang terdaftar.</p>
    <?php endif; ?>
</section>

<div id="no-results-message" style="display: none; text-align: center; padding: 2rem; font-size: 1.2rem; color: var(--text-secondary);">
    <p>Maaf, tidak ada toko yang ditemukan.</p>
</div>

<?php
$conn->close();
require 'includes/footer.php';
?>