<?php
session_start();
require '../includes/db_connect.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

$comment_id = isset($data['comment_id']) ? (int)$data['comment_id'] : 0;
$new_text = isset($data['comment_text']) ? trim($data['comment_text']) : '';

if ($comment_id <= 0 || empty($new_text)) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    exit();
}

if (strlen($new_text) > 200) {
    echo json_encode(['success' => false, 'message' => 'Komentar maksimal 200 karakter']);
    exit();
}

try {
    $stmt = $conn->prepare("UPDATE comments SET comment_text = ?, updated_at = NOW() WHERE comment_id = ? AND user_id = ?");
    $stmt->bind_param("sii", $new_text, $comment_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Ulasan berhasil diperbarui']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal update. Komentar tidak ditemukan atau tidak ada perubahan.']);
    }
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
$conn->close();
?>