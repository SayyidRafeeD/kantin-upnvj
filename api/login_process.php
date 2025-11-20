<?php
session_start();
require '../includes/db_connect.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nim = trim($_POST['nim']);
    $password = $_POST['password'];

    if (empty($nim) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'NIM dan Password wajib diisi.']);
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                // Catat Log Login
                $log_stmt = $conn->prepare("INSERT INTO login_logs (user_id) VALUES (?)");
                $log_stmt->bind_param("i", $user['user_id']);
                $log_stmt->execute();
                $log_stmt->close();

                // Set Session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['nim'] = $nim;

                echo json_encode(['success' => true, 'message' => 'Login berhasil!']);

            } else {
                echo json_encode(['success' => false, 'message' => 'Password salah. Silakan coba lagi.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'NIM tidak ditemukan.']);
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
}
?>