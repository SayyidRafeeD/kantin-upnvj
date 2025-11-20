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
    $today = date('Y-m-d');

    try {
        $stmt_check = $conn->prepare("SELECT vote_id FROM votes WHERE user_id = ? AND store_id = ? AND vote_date = ?");
        $stmt_check->bind_param("iis", $user_id, $store_id, $today);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $response['message'] = 'Anda sudah memberikan suara untuk toko ini hari ini. Coba lagi besok!';
            $stmt_check->close();
        } else {
            $stmt_check->close();

            $stmt_insert = $conn->prepare("INSERT INTO votes (user_id, store_id, vote_date) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("iis", $user_id, $store_id, $today);

            if ($stmt_insert->execute()) {
                $response['success'] = true;
                $response['message'] = 'Terima kasih! Vote Anda hari ini telah dicatat.';
            } else {
                $response['message'] = 'Gagal vote: Anda sudah vote hari ini.';
            }
            $stmt_insert->close();
        }

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