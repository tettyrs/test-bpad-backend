# Backend Aplikasi KDO

REST API Laravel 13 untuk pengelolaan Kendaraan Dinas Operasional (KDO), pegawai, perangkat daerah, dan akun login pegawai. Database MySQL.

Dokumentasi lengkap:
- [docs/api/README.md](docs/api/README.md): endpoint, format respons, kode error, peran, dan keamanan
- [docs/api/openapi.yaml](docs/api/openapi.yaml): spesifikasi OpenAPI 3.0
- [docs/api/postman/](docs/api/postman/): koleksi dan environment Postman
- [docs/tech/database-schema.md](docs/tech/database-schema.md): skema database, ERD, dan daftar migrasi

## Prasyarat

- PHP 8.3 atau lebih baru, dengan extension `pdo_mysql` dan `pdo_sqlite`
- Composer
- MySQL 8 berjalan di `127.0.0.1:3306`
- Database `db_kdo` dengan utf8mb4 (lihat `database/dump/db_kdo_schema_only.sql` jika ingin membuat ulang struktur)

## Pengaturan awal

1. Salin `.env.example` menjadi `.env` jika belum ada, lalu isi nilai database:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_kdo
   DB_USERNAME=developer
   DB_PASSWORD=developer123
   ```

   Di `.env.example`, `DB_HOST`, `DB_PORT`, `DB_USERNAME`, dan `DB_PASSWORD` masih kosong. Isi sesuai mesin Anda.

2. Pasang dependency dan buat application key:

   ```bash
   composer install
   php artisan key:generate
   ```

3. Jalankan migrasi dan seeder:

   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

   Seeder aman dijalankan ulang. Ia membuat akun uji, perangkat daerah, pegawai, dan kendaraan contoh.

## Menjalankan

```bash
php artisan serve
```

API berjalan di `http://127.0.0.1:8000/api/v1`. Frontend di `frontend/` memanggil alamat ini lewat proxy Vite, jadi backend harus berjalan di port 8000.

## Akun uji

| Email | Password | Peran |
|---|---|---|
| test@example.com | password | admin |
| operator@example.com | password | operator |

Admin dapat membuat akun login pegawai. Operator tidak (403).

## Test

```bash
php artisan test
```

Test memakai SQLite in-memory, jadi extension `pdo_sqlite` harus aktif di PHP.

Untuk menguji endpoint secara manual, gunakan koleksi Postman di `docs/api/postman/`. Lihat [docs/api/README.md](docs/api/README.md) untuk cara import dan menjalankannya.

## Struktur singkat

- `app/Http/Controllers/Api/V1/`: controller
- `app/Http/Requests/Api/V1/`: validasi request
- `app/Http/Resources/V1/`: bentuk respons JSON
- `app/Services/`: logika bisnis
- `app/Http/Middleware/EnsureAdmin.php`: pembatasan khusus admin
- `app/Exceptions/ApiExceptionHandler.php`: format error terpusat
- `routes/api.php`: daftar endpoint
- `database/migrations/`, `database/seeders/`: skema dan data awal

## Catatan pembuatan

aplikasi dibuat menggunakan claude code dengan model haiku 5.5

## Batasan aplikasi

| Aspek | Batasan |
|---|---|
| Rate limit umum (`throttle:api`) | 60 request per menit, per pengguna yang login (atau per IP jika belum login). Melebihi batas menghasilkan HTTP 429 `TOO_MANY_REQUESTS`. |
| Login per email dan IP (`throttle:login`) | 5 percobaan per menit untuk pasangan email dan IP. |
| Login per IP (`throttle:login-ip`) | 20 percobaan per menit untuk satu IP. |
| Masa berlaku token | 24 jam sejak login. |
| Pagination (`per_page`) | Default 10, maksimal 100 per halaman. |
| Panjang password | Minimal 8 karakter saat membuat atau mereset akun, maksimal 255 karakter. |
| Peran admin | Hanya admin yang boleh membuat, mengubah, atau menonaktifkan pengguna dan membuat akun pegawai. Operator yang mencoba melakukannya menerima HTTP 403 `FORBIDDEN`. |

Saat menjalankan koleksi Postman dengan Newman, tambahkan jeda antar request (misalnya `--delay-request 1500`) agar tidak mencapai batas 60 request per menit.
