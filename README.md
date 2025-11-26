# Kantin UPNVJ | Direktori Kantin Kampus

<p align="center">
  <img src="assets/images/logo.png" alt="Logo UPNVJ" width="150">
</p>

DIRKA (Direktori Kantin) adalah aplikasi web fullstack yang dirancang untuk membantu civitas akademika UPNVJ dalam mencari referensi kuliner di lingkungan kampus (Pondok Labu & Limo).

## ✨ Fitur Unggulan
* **Direktori Lengkap**: Menampilkan daftar kantin beserta foto dan lokasinya.Web Server seperti **XAMPP**, **MAMP**, atau setara.
* **Smart Voting**: Sistem vote harian (1 vote per toko/hari) untuk menentukan kantin terpopuler.
* **Ulasan & Komentar**: User dapat memberikan ulasan, mengedit, dan menghapus komentar mereka sendiri.
* **Pencarian & Sorting**: Cari toko/menu secara real-time dan urutkan berdasarkan nama atau popularitas.
* **Responsif**: Tampilan optimal di Desktop maupun Mobile.
* **Keamanan**: Validasi input ketat, password hashing, dan login system yang aman.

---

## 🚀 Tech Stack

**Frontend**: HTML5, CSS3 (Custom Variables), JavaScript (Vanilla ES6+)

**Backend**: PHP 8 (Native)

**Database**: MySQL (Relational DB

**Server**: XAMPP/MAMP (Local Development)

---

## 🔧 Prasyarat

Sebelum menjalankan, pastikan komputer Anda memiliki:

* Web Server seperti **XAMPP**, **MAMP**, atau setara.
* Browser web: Chrome, Firefox, dan lainnya.
* Database management tool seperti **phpMyAdmin** atau **DataGrip**.

---

## 📦 Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda.

### 1. Clone Repository

```bash
git clone https://github.com/sayyidrafeed/kantin-upnvj.git
```

---

### 2. Pindahkan Folder Proyek

Pindahkan folder kantin-upnvj ke dalam direktori root server lokal Anda:

Contoh path:

* **Windows**: `C:\xampp\htdocs\kantin-upnvj`
* **macOS**: `/Applications/XAMPP/htdocs/kantin-upnvj`
* **Linux**: `/var/www/html/kantin-upnvj`

---

### 3. Nyalakan Server

Buka XAMPP/MAMP Control Panel dan jalankan modul berikut:

* **Apache**
* **MySQL**

---

### 4. Buat Database

1. Buka `http://localhost/phpmyadmin`.
2. Buat database baru bernama **db_kantin_upnvj**.

---

### 5. Import Skema & Data

1. Klik database `db_kantin_upnvj`.
2. Buka tab **SQL**.
3. Buka file `database.sql` dari folder proyek dan salin seluruh isinya.
4. Tempelkan ke editor SQL phpMyAdmin dan klik **Go**.
5. Ulangi langkah yang sama untuk file `data.sql`.

---

## ✅ Menjalankan Aplikasi

Setelah semua langkah selesai, buka aplikasi melalui URL:

```
http://localhost/kantin-upnvj
```

Anda dapat membuat akun baru atau menggunakan data dummy untuk login.

---

## Konfirugasi Koneksi

Jika Anda menggunakan password database selain default (kosong), edit file:
`includes/db_connect.php`
```php
$username = "root";       
$password = ""; // Isi sesuai password MySQL Anda
```

## Tugas UAS Pemrograman Web

**Oleh:**
* Muhammad Sayyid Rafee' Djamil
* Rafael Ananta Razid
* Damar Kusumawardhani
* Fani Dwi Ariyanti

<p align="center">
© 2025 DIRKA UPNVJ. All rights reserved.
</p>
