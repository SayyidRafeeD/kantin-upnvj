# Kantin UPNVJ | Direktori Kantin Kampus

<p align="center">
  <img src="assets/images/logo.png" alt="Logo UPNVJ" width="150">
</p>

Aplikasi web sederhana yang berfungsi sebagai direktori kantin di UPN "Veteran" Jakarta. Dibuat untuk memenuhi Tugas Akhir Ujian Akhir Semester (UAS) mata kuliah **Pemrograman Web**.

Aplikasi ini memungkinkan pengguna untuk:

* Melihat daftar kantin dan toko di dalamnya.
* Menjelajahi menu serta harga di setiap toko.
* Memberikan vote satu kali per toko.
* Melakukan pencarian toko atau menu secara real time.

---

## 🚀 Tech Stack

**Frontend**: HTML, CSS, JavaScript (Vanilla JS)

**Backend**: PHP

**Database**: MySQL

---

## 🔧 Prasyarat

Sebelum menjalankan proyek, pastikan Anda memiliki:

* Web Server seperti **XAMPP**, **MAMP**, atau setara.
* Browser web: Chrome, Firefox, dan lainnya.
* Database management tool seperti **phpMyAdmin** atau **DataGrip**.

---

## 📦 Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek secara lokal.

### 1. Clone Repository

```bash
git clone https://github.com/sayyidrafeed/kantin-upnvj.git
```

Atau unduh file ZIP dan ekstrak folder proyek.

---

### 2. Pindahkan Folder Proyek

Pindahkan folder `kantin-upnvj` ke dalam direktori **htdocs** milik instalasi XAMPP/MAMP.

Contoh path:

* **Windows**: `C:\xampp\htdocs\kantin-upnvj`
* **macOS**: `/Applications/XAMPP/htdocs/kantin-upnvj`

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
5. Ulangi langkah yang sama untuk file `dummy_data.sql`.

---

## ✅ Menjalankan Aplikasi

Setelah semua langkah selesai, buka aplikasi melalui URL:

```
http://localhost/kantin-upnvj
```

Anda dapat membuat akun baru atau menggunakan data dummy untuk login.

---

## 📚 Informasi Tambahan

Tugas UAS Pemrograman Web

**Oleh: Muhammad Sayyid Rafee' Djamil**
