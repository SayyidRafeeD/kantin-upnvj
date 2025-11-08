<?php
// File: api/login_process.php

// 1. Mulai Session
// Ini WAJIB ada di paling atas untuk file yang akan memanipulasi session
session_start();

// 2. Panggil koneksi database
require '../includes/db_connect.php';

// 3. Cek jika request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form
    $nim = trim($_POST['nim']);
    $password = $_POST['password'];
    
    // Validasi Sisi Server
    if (empty($nim) || empty($password)) {
        header("Location: ../login.php?error=empty");
        exit();
    }
    
    try {
        // 4. Cari user berdasarkan NIM
        $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // 5. Cek apakah user ditemukan
        if ($result->num_rows == 1) {
            // User ditemukan, ambil datanya
            $user = $result->fetch_assoc();
            
            // 6. Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Password benar!
                
                // 7. (Requirement UAS) Catat ke login_logs
                $log_stmt = $conn->prepare("INSERT INTO login_logs (user_id) VALUES (?)");
                $log_stmt->bind_param("i", $user['user_id']);
                $log_stmt->execute();
                $log_stmt->close();
                
                // 8. Simpan data user ke Session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['nim'] = $nim;
                
                // 9. Arahkan ke halaman dashboard (index.php)
                header("Location: ../index.php");
                $stmt->close();
                $conn->close();
                exit();
                
            } else {
                // Password salah
                header("Location: ../login.php?error=login_gagal");
                exit();
            }
        } else {
            // User (NIM) tidak ditemukan
            header("Location: ../login.php?error=login_gagal");
            exit();
        }
        
    } catch (Exception $e) {
        // Tangani error database
        header("Location: ../login.php?error=db_error");
        exit();
    }

} else {
    // Jika bukan POST, tendang balik
    header("Location: ../login.php");
    exit();
}
?>