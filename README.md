# 💼 Luang.In — Backend API

**Luang.In** adalah platform pencarian lowongan kerja yang dikembangkan untuk menghubungkan pelamar dengan perusahaan. Repository ini berisi backend berbasis Laravel yang menangani pengelolaan data, autentikasi, dan komunikasi API dengan aplikasi mobile.

## ✨ Fitur Utama

- **Autentikasi API** — Registrasi dan login pengguna menggunakan Laravel Sanctum.
- **Manajemen Pengguna** — Pengelolaan data akun dan informasi pengguna.
- **Profil Keterampilan** — Penyimpanan informasi keterampilan, pengalaman, dan data pendukung pelamar.
- **API Lowongan Kerja** — Mendukung pengelolaan dan penyediaan data lowongan.
- **Pengelolaan Lamaran** — Mendukung proses pengajuan dan pemantauan lamaran pekerjaan.
- **Manajemen Perusahaan** — Mendukung pengelolaan akun dan proses verifikasi perusahaan.
- **Kontrol Akses** — Mendukung pembatasan akses berdasarkan peran pengguna.

*Catatan: Fitur yang tersedia bergantung pada implementasi endpoint dan integrasi yang telah diselesaikan.*

## 🛠️ Teknologi

| Teknologi | Kegunaan |
|---|---|
| Laravel | Framework backend |
| PHP | Bahasa pemrograman |
| MySQL | Database |
| Laravel Sanctum | Autentikasi API berbasis token |
| Composer | Manajemen dependensi PHP |
| Git & GitHub | Version control |

## 📋 Persyaratan

Pastikan perangkat pengembangan telah memiliki:

- PHP sesuai versi yang didukung proyek Laravel
- Composer
- MySQL atau MariaDB
- Git
- XAMPP atau lingkungan server lokal lainnya

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone <URL_REPOSITORY_LARAVEL>
```

Masuk ke direktori proyek:

```bash
cd <NAMA_FOLDER_LARAVEL>
```

### 2. Instal Dependensi

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file konfigurasi:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buat database bernama `luangin_db`, lalu sesuaikan konfigurasi pada file `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=luangin_db
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password dengan konfigurasi database lokal.

### 5. Jalankan Migrasi

```bash
php artisan migrate
```

Pastikan seluruh migrasi berjalan dengan sukses sebelum melanjutkan.

### 6. Jalankan Server API

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Server Laravel akan berjalan pada port `8000`.

## 🔌 Integrasi API

Backend ini dirancang untuk diintegrasikan dengan aplikasi mobile Luang.In melalui REST API.

Endpoint autentikasi mobile yang digunakan meliputi:

| Method | Endpoint | Kegunaan |
|---|---|---|
| POST | `/api/mobile/register` | Registrasi pengguna, jika menggunakan alur registrasi langsung |
| POST | `/api/mobile/login` | Login pengguna |
| GET | `/api/mobile/me` | Mengambil data pengguna yang sedang login |
| POST | `/api/mobile/logout` | Logout pengguna |
| GET | `/api/mobile/skill-profile` | Mengambil profil keterampilan |
| POST | `/api/mobile/skill-profile` | Menyimpan atau memperbarui profil keterampilan |

Endpoint yang memerlukan autentikasi menggunakan token Sanctum.

> **Penting:** Sesuaikan daftar endpoint dengan `routes/api.php` terbaru. Jika registrasi menggunakan alur pengisian profil terlebih dahulu, dokumentasikan endpoint `complete-registration` yang benar-benar sudah dibuat.

## 🔐 Keamanan

- Simpan kredensial database di file `.env`.
- Jangan unggah file `.env` ke repository publik.
- Gunakan validasi input pada setiap endpoint.
- Terapkan autentikasi dan otorisasi sesuai kebutuhan.
- Gunakan HTTPS saat deployment ke server produksi.

## 🎯 Tujuan

Backend Luang.In dikembangkan untuk menyediakan layanan API yang menghubungkan aplikasi mobile dengan database, sekaligus mendukung pengelolaan akun, profil pelamar, lowongan pekerjaan, dan proses perekrutan.

## 📌 Status Proyek

**Luang.In Backend API** — dikembangkan menggunakan Laravel dan diintegrasikan secara bertahap dengan aplikasi mobile.

---

**Luang.In — Temukan Peluang, Bangun Masa Depan.** 💜
