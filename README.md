```markdown
# MyBlog - Laravel Blog App

Aplikasi blog sederhana berbasis Laravel yang menggunakan arsitektur **MVC (Model-View-Controller)**. Pengguna dapat melakukan login, membuat postingan, mengunggah gambar, serta melihat, mengedit, dan menghapus postingan milik mereka. Pengunjung yang belum login hanya dapat melihat postingan.

---

## 🚀 Fitur

- Autentikasi (Login & Register)
- CRUD Postingan Blog
- Upload Gambar ke `storage/app/public/posts`
- Hanya pengguna login yang bisa mengelola postingan
- Pengunjung tetap bisa melihat daftar dan detail postingan
- Menggunakan Bootstrap 5 untuk tampilan antarmuka
- Routing RESTful dengan `Route::resource`

---

## 🏗️ Struktur Proyek

### 📁 Controller (`app/Http/Controllers`)
```text
📂Controllers
 ┣ 📜AuthController.php      // Mengatur login, register, logout
 ┣ 📜Controller.php          // Base controller
 ┣ 📜PostController.php      // Mengelola semua operasi postingan (CRUD)
 ┗ 📜UserController.php      // Opsional, jika ada manajemen user
```

### 📁 View (`resources/views`)
```text
📂views
 ┣ 📂auth
 ┃ ┣ 📜login.blade.php
 ┃ ┗ 📜register.blade.php
 ┣ 📂layouts
 ┃ ┗ 📜app.blade.php         // Layout dasar dengan navbar
 ┣ 📂posts
 ┃ ┣ 📜create.blade.php      // Form tambah post
 ┃ ┣ 📜edit.blade.php        // Form edit post
 ┃ ┣ 📜index.blade.php       // Daftar semua post
 ┃ ┗ 📜show.blade.php        // Detail post
 ┣ 📂users
 ┃ ┣ 📜create.blade.php
 ┃ ┗ 📜index.blade.php
 ┗ 📜welcome.blade.php
```

### 📁 Middleware (`app/Http/Middleware`)
Laravel default middleware untuk autentikasi, CSRF, dll.

### 📦 Upload Gambar
Semua gambar akan disimpan di:

```text
storage/app/public/posts/
```

Agar bisa diakses secara publik, jalankan:

```bash
php artisan storage:link
```

Contoh path file setelah upload:

```bash
/storage/posts/nama-gambar.jpg
```

### 🌐 Routing (`routes/web.php`)
```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/', fn() => redirect()->route('posts.index'))->name('home');

// Autentikasi
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Resource Route untuk Postingan
Route::resource('posts', PostController::class);
```

---

## 🧪 Instalasi

1.  **Clone & Masuk ke Direktori**
    ```bash
    git clone [https://github.com/Ahmadnurahsan/PBO.git](https://github.com/Ahmadnurahsan/PBO.git)
    cd myblog
    ```

2.  **Install Dependensi**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Copy .env & Generate Key**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi .env**
    Edit .env:

    ```makefile
    DB_DATABASE=myblog
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Import SQL**
    Import file berikut ke MySQL:

    ```lua
    dump-pbo-202506041727.sql
    ```

6.  **Link Storage**
    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Server**
    ```bash
    php artisan serve
    ```

---

## 🧱 Struktur File Upload (Contoh)

```text
📦storage/app/public/posts/
 ┣ 📜gambar1.jpg
 ┣ 📜gambar2.jpg
 ┣ 📜cover-post-3.png
 ┗ 📜foto-artikel-4.jpeg
```

---

## 📄 File SQL

Gunakan `dump-pbo-202506041727.sql` untuk import data awal:

```bash
mysql -u root -p myblog < dump-pbo-202506041727.sql
```

---

## 📋 Catatan

Aplikasi ini menggunakan **Laravel 10** (atau versi terbaru yang kompatibel)

Bootstrap sudah di-include di `resources/views/layouts/app.blade.php`

Pastikan direktori `storage/` dan `bootstrap/cache/` memiliki permission write (`chmod -R 775`)
```
