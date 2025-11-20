<?php
session_start();
require '../includes/db_connect.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $query = "
        SELECT 
            c.comment_id, 
            c.comment_text, 
            c.created_at, 
            c.updated_at,
            s.store_name,
            s.store_id,
            s.image_url
        FROM comments c
        JOIN stores s ON c.store_id = s.store_id
        WHERE c.user_id = ?
        ORDER BY c.created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        if (empty($row['image_url'])) {
            $row['image_url'] = 'https://placehold.co/100x100/ddd/777?text=Store';
        }
        $reviews[] = $row;
    }

    echo json_encode(['success' => true, 'data' => $reviews]);
    $stmt->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>