<?php

require '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $full_name = trim($_POST['full_name']);
    $nim = trim($_POST['nim']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    if (empty($full_name) || empty($nim) || empty($password) || empty($password_confirm)) {
        header("Location: ../register.php?error=empty");
        exit();
    }
    
    if ($password !== $password_confirm) {
        header("Location: ../register.php?error=passwords_no_match");
        exit();
    }
    
    try {
        $stmt = $conn->prepare("SELECT nim FROM users WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            header("Location: ../register.php?error=nim_terdaftar");
            $stmt->close();
            $conn->close();
            exit();
        }
        $stmt->close();
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt_insert = $conn->prepare("INSERT INTO users (full_name, nim, password) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $full_name, $nim, $hashed_password);
        
        if ($stmt_insert->execute()) {
            header("Location: ../login.php?status=register_sukses");
            $stmt_insert->close();
            $conn->close();
            exit();
        } else {
            throw new Exception("Gagal mengeksekusi statement insert.");
        }
        
    } catch (Exception $e) {
        header("Location: ../register.php?error=db_error&msg=" . urlencode($e->getMessage()));
        exit();
    }

} else {
    header("Location: ../register.php");
    exit();
}
?>