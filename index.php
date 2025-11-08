<?php
require 'includes/header.php';
require 'includes/db_connect.php';

$sql = "SELECT 
            s.store_id, 
            s.store_name, 
            s.image_url, 
            c.canteen_name 
        FROM 
            stores s
        JOIN 
            canteens c ON s.canteen_id = c.canteen_id";


$result = $conn->query($sql);
?>
    
<h1 class="page-title">Cari Toko Favoritmu</h1>

<section class="store-grid">
    
    <?php
    if ($result && $result->num_rows > 0) {
        while($store = $result->fetch_assoc()) {
    ?>
    
            <article class="store-card">
                
                <?php if (!empty($store['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($store['image_url']); ?>" alt="<?php echo htmlspecialchars($store['store_name']); ?>" class="card-image">
                <?php else: ?>
                    <div class="card-image">(Gambar Toko)</div>
                <?php endif; ?>
                
                <div class="card-content">
                    <h3 class="card-title"><?php echo htmlspecialchars($store['store_name']); ?></h3>
                    <p class="card-location"><?php echo htmlspecialchars($store['canteen_name']); ?></p>
                </div>
                
                <a href="store.php?id=<?php echo $store['store_id']; ?>" class="card-button">
                    Lihat Menu & Vote
                </a>
            </article>
            
    <?php
        } 
    } else {
        echo "<p>Belum ada toko yang terdaftar.</p>";
    }
    
    $conn->close();
    ?>
    
</section>
        
<?php
require 'includes/footer.php';
?>