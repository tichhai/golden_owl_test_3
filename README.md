
# G-Scores - Tra cứu điểm thi THPT 2024

## Hướng dẫn chạy dự án Laravel này trên máy local

### 1. Yêu cầu
- PHP >= 8.1
- Composer
- MySQL

### 2. Clone project
```bash
git clone https://github.com/tichhai/golden_owl_test_3
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

### 6. Chạy migrate và seed dữ liệu
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 7. Chạy server
```bash
php artisan serve
```
## API chính
- Tra cứu điểm theo SBD: `/api/search?sbd=...`
- Thống kê phân loại điểm từng môn: `/api/subject-stats`
- Báo cáo phân loại học sinh theo tổng điểm: `/api/report`
- Top 10 học sinh khối A: `/api/top-a`
