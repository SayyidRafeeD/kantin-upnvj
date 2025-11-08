Kantin UPNVJ - Direktori Kantin Kampus

<p align="center">
<img src="assets/images/logo.png" alt="Logo UPNVJ" width="150">
</p>

Proyek ini adalah aplikasi web sederhana yang berfungsi sebagai direktori kantin di UPN "Veteran" Jakarta. Dibuat sebagai pemenuhan Tugas Akhir Ujian Akhir Semester (UAS) mata kuliah Pemrograman Web.

Aplikasi ini memungkinkan mahasiswa untuk:

Melihat daftar kantin dan toko di dalamnya.

Melihat menu dan harga dari setiap toko.

Memberikan vote (satu kali per toko) ke toko favorit mereka.

Mencari toko atau menu secara real-time.

🚀 Tech Stack

Frontend: HTML, CSS, JavaScript (Vanilla JS)

Backend: PHP

Database: MySQL

🔧 Prasyarat

Web Server (XAMPP, MAMP, atau sejenisnya)

Browser Web (Chrome, Firefox, dll.)

Database Management Tool (phpMyAdmin, DataGrip, dll.)

📦 Instalasi & Konfigurasi

Berikut adalah langkah-langkah untuk menjalankan proyek ini di localhost:

Clone Repository

git clone [https://github.com/sayyidrafeed/kantin-upnvj.git](https://github.com/sayyidrafeed/kantin-upnvj.git)


Atau unduh ZIP dan ekstrak folder proyek.

Pindahkan Folder Proyek
Pindahkan seluruh folder kantin-upnvj ke dalam direktori htdocs di folder instalasi XAMPP/MAMP Anda.

Contoh Path (Windows): C:\xampp\htdocs\kantin-upnvj

Contoh Path (macOS): /Applications/XAMPP/htdocs/kantin-upnvj

Nyalakan Server
Buka XAMPP/MAMP Control Panel dan nyalakan (Start) modul Apache dan MySQL.

Buat Database

Buka http://localhost/phpmyadmin di browser Anda.

Buat database baru dengan nama db_kantin_upnvj.

Import Skema & Data

Klik database db_kantin_upnvj yang baru saja Anda buat.

Buka tab "SQL".

Buka file database.sql dari folder proyek ini, salin (copy) seluruh isinya.

Tempel (paste) ke dalam kotak teks di tab "SQL" phpMyAdmin, lalu klik "Go".

Selanjutnya, lakukan hal yang sama untuk file dummy_data.sql untuk mengisi data awal.

Selesai!
Buka aplikasi di browser Anda melalui URL:

http://localhost/kantin-upnvj


Anda bisa mendaftar akun baru atau menggunakan data dummy untuk login.

Tugas UAS Pemrograman Web - Muhammad Sayyid Rafee' Djamil