<?php

$servername = "localhost";
$username = "root";       
$password = "root";
$dbname = "db_kantin_upnvj"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Koneksi Gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>