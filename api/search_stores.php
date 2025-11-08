<?php
session_start();
require '../includes/db_connect.php';
header('Content-Type: application/json'); 

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Anda harus login']);
    exit();
}

$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';
$searchLike = '%' . $searchTerm . '%';

$results = [];
$success = false;

$query = 
    "SELECT 
        s.store_id, 
        s.store_name, 
        s.image_url, 
        c.canteen_name, 
        COUNT(DISTINCT v.vote_id) as total_votes
     FROM stores s
     JOIN canteens c ON s.canteen_id = c.canteen_id
     LEFT JOIN votes v ON s.store_id = v.store_id
     LEFT JOIN menu_items mi ON s.store_id = mi.store_id
     WHERE 
        s.store_name LIKE ? OR mi.item_name LIKE ?
     GROUP BY s.store_id
     ORDER BY s.store_name ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $searchLike, $searchLike);

if ($stmt->execute()) {
    $result_stores = $stmt->get_result();
    $success = true;
    
    if ($result_stores->num_rows > 0) {
        while ($store = $result_stores->fetch_assoc()) {
            $store['detail_url'] = 'store.php?id=' . $store['store_id'];
            
            if (empty($store['image_url'])) {
                $store['image_url'] = 'https://placehold.co/400x250/ddd/777?text=Gambar+Toko';
            }
            $results[] = $store;
        }
    }
}

$stmt->close();
$conn->close();

echo json_encode([
    'success' => $success,
    'data' => $results
]);