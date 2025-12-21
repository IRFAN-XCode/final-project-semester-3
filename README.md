# Aplikasi Manajemen Keuangan Mahasiswa (Kurs Otomatis)

Proyek ini adalah aplikasi berbasis web untuk membantu mahasiswa mengelola keuangan pribadi dengan fitur konversi mata uang otomatis menggunakan API eksternal.

## Prasyarat
- PHP 7.4 ke atas
- MySQL/MariaDB
- Laragon atau XAMPP

## Cara Instalasi & Menjalankan
1. **Clone atau Unduh Proyek:**
   Simpan di folder `www` (Laragon) atau `htdocs` (XAMPP).
   
2. **Setup Database:**
   - Buka phpMyAdmin atau HeidiSQL.
   - Buat database baru dengan nama `app_manajemen_keuangan`.
   - Impor file `app_manajemen_keuangan.sql` yang ada di root folder ini ke dalam database tersebut.

3. **Konfigurasi Environment:**
   - Salin file `.env.example` dan ubah namanya menjadi `.env`.
   - Buka file `.env` dan sesuaikan `DB_PASSWORD` atau `API_KURS_KEY` jika diperlukan.

4. **Akses Aplikasi:**
   Buka browser dan akses `http://localhost/app-fp/`.

## Struktur Folder Utama
- `assets/`: File CSS, JS, dan Gambar.
- `public/`: Halaman dashboard untuk Admin dan User.
- `vendor/`: Library pihak ketiga (PHPMailer).
- `env.php`: Script untuk memuat variabel dari file .env.
- `db.php`: Koneksi database utama.

## Fitur Email
Aplikasi ini menggunakan PHPMailer untuk fitur notifikasi/registrasi. Pastikan koneksi internet tersedia untuk fitur ini dan fitur Kurs Otomatis.