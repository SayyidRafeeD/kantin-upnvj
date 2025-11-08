<?php
// File: api/register_process.php

// 1. Panggil koneksi database
require '../includes/db_connect.php';

// 2. Cek jika request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form (dan sanitasi dasar)
    $full_name = trim($_POST['full_name']);
    $nim = trim($_POST['nim']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // 3. Validasi Sisi Server
    // Cek jika ada field kosong
    if (empty($full_name) || empty($nim) || empty($password) || empty($password_confirm)) {
        header("Location: ../register.php?error=empty");
        exit();
    }
    
    // Cek jika password dan konfirmasi password sama
    if ($password !== $password_confirm) {
        header("Location: ../register.php?error=passwords_no_match");
        exit();
    }
    
    // 4. Cek apakah NIM sudah terdaftar (pakai Prepared Statements)
    try {
        $stmt = $conn->prepare("SELECT nim FROM users WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $stmt->store_result(); // Simpan hasil ke memori
        
        if ($stmt->num_rows > 0) {
            // Jika num_rows > 0, berarti NIM sudah ada
            header("Location: ../register.php?error=nim_terdaftar");
            $stmt->close();
            $conn->close();
            exit();
        }
        $stmt->close();
        
        // 5. Jika NIM aman, hash password
        // Ini SANGAT PENTING untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // 6. Masukkan user baru ke database
        $stmt_insert = $conn->prepare("INSERT INTO users (full_name, nim, password) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $full_name, $nim, $hashed_password);
        
        if ($stmt_insert->execute()) {
            // Jika registrasi sukses
            header("Location: ../login.php?status=register_sukses");
            $stmt_insert->close();
            $conn->close();
            exit();
        } else {
            // Jika query insert gagal
            throw new Exception("Gagal mengeksekusi statement insert.");
        }
        
    } catch (Exception $e) {
        // Tangani error database
        // (Pada production, ini harus dicatat, bukan ditampilkan)
        header("Location: ../register.php?error=db_error&msg=" . urlencode($e->getMessage()));
        exit();
    }

} else {
    // Jika bukan POST, tendang balik
    header("Location: ../register.php");
    exit();
}
?>