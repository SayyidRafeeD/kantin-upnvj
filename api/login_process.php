<?php

session_start();

require '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nim = trim($_POST['nim']);
    $password = $_POST['password'];
    
    if (empty($nim) || empty($password)) {
        header("Location: ../login.php?error=empty");
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
                
                $log_stmt = $conn->prepare("INSERT INTO login_logs (user_id) VALUES (?)");
                $log_stmt->bind_param("i", $user['user_id']);
                $log_stmt->execute();
                $log_stmt->close();
                
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['nim'] = $nim;
                
                header("Location: ../index.php");
                $stmt->close();
                $conn->close();
                exit();
                
            } else {
                header("Location: ../login.php?error=login_gagal");
                exit();
            }
        } else {
            header("Location: ../login.php?error=login_gagal");
            exit();
        }
        
    } catch (Exception $e) {
        header("Location: ../login.php?error=db_error");
        exit();
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>