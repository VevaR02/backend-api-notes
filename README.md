# 📝 Fullstack Notes App (Laravel + React)

Aplikasi pencatatan sederhana namun *powerful* yang dibangun menggunakan **Laravel 11 (Backend)** dan **React + Vite (Frontend)**. Aplikasi ini menggunakan REST API dengan autentikasi Token (Sanctum) dan mendukung Custom ID (String) serta format data CamelCase.

## 🛠️ Tech Stack

**Backend:**
* Laravel 11
* MySQL Database
* Laravel Sanctum (Authentication)
* Custom String IDs (UUID-like)

**Frontend:**
* React JS
* Vite
* Fetch API (Custom Network Handler)

---

## 🚀 Panduan Instalasi (Untuk Pengguna Baru)

Pastikan di komputer Anda sudah terinstall:
1.  **PHP** & **Composer**
2.  **Node.js** & **NPM**
3.  **MySQL** (via XAMPP/Laragon/Docker)

### 1️⃣ Setup Backend (Laravel)

1.  Masuk ke folder backend (jika dipisah):
    ```bash
    cd backend-api-notes
    ```

2.  Install dependencies PHP:
    ```bash
    composer install
    ```

3.  Duplikat file environment dan generate key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi Database:**
    Buka file `.env`, lalu sesuaikan konfigurasi database Anda. Pastikan database `backend_api` (atau nama lain) sudah dibuat di phpMyAdmin.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=backend_api  <-- Sesuaikan nama DB
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Install API & Migrasi Database:**
    Penting: Laravel 11 membutuhkan instalasi API manual dan migrasi struktur tabel (termasuk tabel user dengan ID string).
    ```bash
    php artisan install:api
    php artisan migrate
    ```
    *(Jika muncul error tabel sudah ada, gunakan `php artisan migrate:fresh`)*

6.  Jalankan Server Backend:
    ```bash
    php artisan serve
    ```
    *Server akan berjalan di `http://127.0.0.1:8000`*

---

### 2️⃣ Setup Frontend (React)

1.  Buka terminal baru, masuk ke folder frontend:
    ```bash
    cd frontend-app
    ```

2.  Install dependencies JavaScript:
    ```bash
    npm install
    ```

3.  **Konfigurasi Base URL (PENTING):**
    Pastikan file konfigurasi API (misalnya di `utils/network-data.js` atau `config.js`) mengarah ke port Laravel yang benar:
    ```javascript
    const BASE_URL = "[http://127.0.0.1:8000/api/v1](http://127.0.0.1:8000/api/v1)";
    ```

4.  Jalankan Server Frontend:
    ```bash
    npm run dev
    ```
    *Aplikasi akan berjalan di `http://localhost:5173`*

---

## ⚠️ Troubleshooting Umum

Jika Anda mengalami masalah saat menjalankan aplikasi, cek solusi berikut:

**1. Layar Putih (Blank Screen) / Error 500**
* Biasanya karena database belum sinkron. Matikan server Laravel, lalu reset database:
    ```bash
    php artisan migrate:fresh
    ```
* Pastikan file `.env` sudah benar.

**2. Error "Invalid Date" pada Catatan**
* Backend mengirim `created_at` (snake_case) tapi Frontend minta `createdAt` (camelCase).
* **Solusi:** Pastikan Model `Note.php` di Laravel memiliki properti `$appends = ['createdAt']` dan getter `getCreatedAtAttribute`.

**3. Error 401 Unauthorized / Login Gagal Terus**
* Token mungkin kadaluarsa atau user terhapus setelah `migrate:fresh`.
* **Solusi:** Hapus `accessToken` di LocalStorage browser, lalu **Register** akun baru.

**4. Error CORS (Cross-Origin)**
* Jika Frontend tidak bisa akses Backend, pastikan `config/cors.php` di Laravel sudah mengizinkan API:
    ```php
    'paths' => ['api/*', ...],
    'allowed_origins' => ['*'], // Atau 'http://localhost:5173'
    ```

---

## 📂 Struktur Penting

* **`routes/api.php`**: Definisi endpoint API (Login, Register, Notes CRUD).
* **`app/Models/User.php`**: Model User dengan konfigurasi ID String (`user-xxxx`).
* **`app/Models/Note.php`**: Model Note dengan casting `archived` (boolean) dan mapper `createdAt`.
* **`database/migrations/`**: File struktur database.

---
*Happy Coding!* 🚀
