
# G-Scores - Tra cứu điểm thi THPT 2024

## Demo
- Link demo online (Render): [Cập nhật sau khi deploy]

---

## Hướng dẫn chạy dự án Laravel này trên máy local

### 1. Yêu cầu
- PHP >= 8.1
- Composer
- SQLite (hoặc MySQL/Postgres nếu muốn)
- Node.js (nếu muốn build lại frontend)

### 2. Clone project
```bash
git clone <repo-url>
cd golden_owl_test_3
```

### 3. Cài đặt package PHP
```bash
composer install
```

### 4. Tạo file môi trường
```bash
cp .env.example .env
```

### 5. Tạo application key
```bash
php artisan key:generate
```

### 6. Cấu hình database
- **MySQL:**
  - Cập nhật các biến DB trong `.env` cho phù hợp (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

### 7. Chạy migrate và seed dữ liệu
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 8. Chạy server
```bash
php artisan serve
```
## API chính
- Tra cứu điểm theo SBD: `/api/search?sbd=...`
- Thống kê phân loại điểm từng môn: `/api/subject-stats`
- Báo cáo phân loại học sinh theo tổng điểm: `/api/report`
- Top 10 học sinh khối A: `/api/top-a`

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
### Premium Partners
