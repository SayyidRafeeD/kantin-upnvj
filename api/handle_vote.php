<?php
session_start();
require '../includes/db_connect.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'Terjadi kesalahan.',
    'new_vote_count' => 0
];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Gagal vote: Anda harus login.';
    echo json_encode($response);
    exit();
}
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['store_id'])) {
    
    $store_id = (int)$_POST['store_id'];
    
    try {
        $stmt_insert = $conn->prepare("INSERT INTO votes (user_id, store_id) VALUES (?, ?)");
        $stmt_insert->bind_param("ii", $user_id, $store_id);
        
        if ($stmt_insert->execute()) {
            $response['success'] = true;
            $response['message'] = 'Terima kasih! Vote Anda telah dicatat.';
        } else {
            $response['message'] = 'Gagal vote: Anda sudah pernah vote toko ini.';
        }
        $stmt_insert->close();
        
        $stmt_count = $conn->prepare("SELECT COUNT(vote_id) as total_votes FROM votes WHERE store_id = ?");
        $stmt_count->bind_param("i", $store_id);
        $stmt_count->execute();
        $response['new_vote_count'] = $stmt_count->get_result()->fetch_assoc()['total_votes'];
        $stmt_count->close();
        
    } catch (Exception $e) {
        $response['message'] = 'Error DB: ' . $e->getMessage();
    }
    
} else {
    $response['message'] = 'Request tidak valid.';
}

$conn->close();
echo json_encode($response);
exit();
?>