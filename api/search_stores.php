<?php
session_start();
require '../includes/db_connect.php';
header('Content-Type: application/json');

$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';
$searchLike = '%' . $searchTerm . '%';
$sortParam = isset($_GET['sort']) ? $_GET['sort'] : 'alphabet_asc';

$orderBy = "s.store_name ASC";
switch ($sortParam) {
    case 'alphabet_desc': $orderBy = "s.store_name DESC"; break;
    case 'vote_asc': $orderBy = "total_votes ASC"; break;
    case 'vote_desc': $orderBy = "total_votes DESC"; break;
    default: $orderBy = "s.store_name ASC"; break;
}

$countQuery = "
    SELECT COUNT(DISTINCT s.store_id) as total
    FROM stores s
    LEFT JOIN menu_items mi ON s.store_id = mi.store_id
    WHERE s.store_name LIKE ? OR mi.item_name LIKE ?
";
$stmtCount = $conn->prepare($countQuery);
$stmtCount->bind_param("ss", $searchLike, $searchLike);
$stmtCount->execute();
$totalRecords = $stmtCount->get_result()->fetch_assoc()['total'];
$stmtCount->close();

$totalPages = ceil($totalRecords / $limit);

$query = "
    SELECT 
        s.store_id, 
        s.store_name, 
        s.image_url, 
        c.canteen_name, 
        COUNT(DISTINCT v.vote_id) as total_votes,
        COUNT(DISTINCT com.comment_id) as total_comments
    FROM stores s
    JOIN canteens c ON s.canteen_id = c.canteen_id
    LEFT JOIN votes v ON s.store_id = v.store_id
    LEFT JOIN comments com ON s.store_id = com.store_id
    LEFT JOIN menu_items mi ON s.store_id = mi.store_id
    WHERE 
        s.store_name LIKE ? OR mi.item_name LIKE ?
    GROUP BY s.store_id
    ORDER BY $orderBy
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssii", $searchLike, $searchLike, $limit, $offset);

$results = [];
if ($stmt->execute()) {
    $result_stores = $stmt->get_result();

    while ($store = $result_stores->fetch_assoc()) {
        $store['detail_url'] = 'store.php?id=' . $store['store_id'];

        // Fallback image
        if (empty($store['image_url'])) {
            $store['image_url'] = 'https://placehold.co/400x250/ddd/777?text=Gambar+Toko';
        }
        $results[] = $store;
    }
}

$stmt->close();
$conn->close();

echo json_encode([
    'success' => true,
    'data' => $results,
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $totalPages,
        'total_records' => $totalRecords
    ]
]);
?>