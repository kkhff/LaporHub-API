# LaporHub API 

LaporHub adalah backend RESTful API untuk sistem pelaporan masyarakat. Project ini dibangun menggunakan arsitektur pemisahan *backend* dan *frontend*, dengan fokus pada keamanan, manajemen peran (Role-based Access), dan kecepatan respon data.

**Catatan:** Repository ini murni berisi **Backend (REST API)**. Didesain secara *headless* agar siap dikonsumsi oleh berbagai platform Frontend (React, Vue, Mobile App, dll).

## Tech Stack & Fitur
* **Framework:** Laravel 13 (PHP 8.3+)
* **Database:** MySQL
* **Authentication:** Laravel Sanctum (Bearer Token)
* **Environment:** Laravel Sail (Docker)
* **Fitur Utama:** Multi-Role (Admin, Petugas, Masyarakat), Upload Gambar, Middleware Gatekeeping.

**[Klik di sini untuk melihat Dokumentasi Postman LaporHub API]**  
https://crimson-satellite-1456435.postman.co/workspace/kkh's-Workspace~513eca4e-75f6-45a2-8afd-b1b7c048edb9/collection/51063118-56413ec8-9545-4578-acdf-e0a2f58624b9?action=share&source=copy-link&creator=51063118


## Cara Menjalankan Project (Lokal)

**1. Clone Repository:**
```bash
git clone https://github.com/kkhff/LaporHub-API.git
cd LaporHub-API
```

**2. Setup Environment**
```bash
cp .env.example .env
```

**3. Install Dependencies:** Jika kamu memiliki PHP dan Composer lokal:
```bash
composer install
```
Jika kamu **hanya ingin menggunakan** Docker (Tanpa install PHP di lokal):
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

**4. Jalankan Docker Sail**
```bash
./vendor/bin/sail up -d
```

**5. Generate Key & Migrate**
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan storage:link
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=UserSeeder
./vendor/bin/sail artisan db:seed --class=CategorySeeder
```

## Akun Testing (Hasil Seeder)
| Role | Email | Password |
| :--- | :--- | :--- |
| Admin | `admin@laporhub.com` | password123 |
| Petugas | `petugas@laporhub.com` | password123 |
