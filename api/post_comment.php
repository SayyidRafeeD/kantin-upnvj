<?php
session_start();
require '../includes/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Anda harus login untuk berkomentar.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $store_id = isset($data['store_id']) ? (int)$data['store_id'] : 0;
    $comment_text = isset($data['comment']) ? trim($data['comment']) : '';

    if ($store_id <= 0 || empty($comment_text)) {
        echo json_encode(['success' => false, 'message' => 'Komentar tidak boleh kosong.']);
        exit();
    }

    if (strlen($comment_text) > 200) {
        echo json_encode(['success' => false, 'message' => 'Komentar terlalu panjang (maks 200 karakter).']);
        exit();
    }

    try {
        $stmt = $conn->prepare("INSERT INTO comments (user_id, store_id, comment_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $store_id, $comment_text);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Komentar berhasil dikirim!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan komentar.']);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>