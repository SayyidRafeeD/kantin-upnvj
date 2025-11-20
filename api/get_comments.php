<?php
require '../includes/db_connect.php';

header('Content-Type: application/json');

$store_id = isset($_GET['store_id']) ? (int)$_GET['store_id'] : 0;

if ($store_id <= 0) {
    echo json_encode(['success' => false, 'data' => []]);
    exit();
}

try {
    $query = "
        SELECT 
            c.comment_id, 
            c.comment_text, 
            c.created_at, 
            u.full_name 
        FROM comments c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.store_id = ?
        ORDER BY c.created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    echo json_encode(['success' => true, 'data' => $comments]);
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>