# MyBlog 📝

Sebuah aplikasi blog sederhana berbasis Laravel, menggunakan arsitektur MVC.

## Fitur
- Manajemen User
- CRUD Postingan Blog
- Relasi antara User dan Post (One-to-Many)

## Struktur Database
- **users**  
  Kolom penting: `id`, `name`, `email`, `password`

- **posts**  
  Kolom penting: `id`, `user_id`, `title`, `content`, `created_at`, `updated_at`

## Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/myblog.git
   cd myblog
