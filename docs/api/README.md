# API KDO

Base URL: `http://127.0.0.1:8000/api/v1`

Spesifikasi lengkap ada di [openapi.yaml](openapi.yaml). Koleksi Postman ada di folder [postman](postman/).

## Persiapan

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan serve
```

Seeder membuat akun uji dan data contoh. Seeder aman dijalankan ulang.

## Login

```bash
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

Respons berisi `data.token`. Kirim token itu di header `Authorization` pada setiap request yang butuh login:

```bash
curl http://127.0.0.1:8000/api/v1/kendaraan-dinas \
  -H "Accept: application/json" -H "Authorization: Bearer {token}"
```

Token berlaku 24 jam. Gunakan `POST /auth/logout` untuk mencabut token yang sedang dipakai.

## Endpoint

| Method | Path | Keterangan |
|---|---|---|
| POST | /auth/login | Login, mengembalikan token |
| GET | /auth/me | Data user yang sedang login |
| POST | /auth/logout | Mencabut token saat ini |
| GET | /perangkat-daerah | Daftar, dengan `search` dan `per_page` |
| POST | /perangkat-daerah | Tambah |
| GET | /perangkat-daerah/{id} | Detail |
| PUT | /perangkat-daerah/{id} | Ubah |
| DELETE | /perangkat-daerah/{id} | Hapus (soft delete) |
| GET | /pegawai | Daftar, dengan `search` dan `per_page` |
| POST | /pegawai | Tambah |
| GET | /pegawai/{id} | Detail |
| PUT | /pegawai/{id} | Ubah |
| DELETE | /pegawai/{id} | Hapus (soft delete), sekaligus mencabut token dan menghapus akun login pegawai |
| POST | /pegawai/{id}/akun | Buat akun login untuk pegawai. Khusus admin. Satu pegawai hanya punya satu akun |
| GET | /kendaraan-dinas | Daftar, dengan `search`, `kondisi`, dan `per_page` |
| POST | /kendaraan-dinas | Tambah |
| GET | /kendaraan-dinas/{id} | Detail, termasuk perangkat daerah dan penanggung jawab |
| PUT | /kendaraan-dinas/{id} | Ubah |
| DELETE | /kendaraan-dinas/{id} | Hapus (soft delete) |
| GET | /users | Daftar pengguna. Khusus admin. Filter `search`, `role`, `is_active`, `per_page` |
| POST | /users | Tambah pengguna. Khusus admin |
| GET | /users/{id} | Detail pengguna. Khusus admin |
| PUT | /users/{id} | Ubah nama, email, atau peran. Khusus admin |
| PUT | /users/{id}/status | Aktifkan atau nonaktifkan pengguna. Khusus admin. Token pengguna dicabut saat dinonaktifkan |
| POST | /users/{id}/reset-password | Reset password pengguna. Khusus admin. Token lama dicabut |

## Format respons

Respons sukses berisi `data`:

```json
{ "data": { "id": 1, "nama": "Dinas Pendidikan" } }
```

Daftar memakai pagination Laravel:

```json
{
  "data": [ { "id": 1 } ],
  "links": { "first": "...", "last": "...", "prev": null, "next": null },
  "meta": { "current_page": 1, "last_page": 1, "per_page": 10, "total": 1 }
}
```

Respons error selalu memakai bentuk yang sama:

```json
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Data yang dikirim tidak valid.",
    "details": { "nomor_polisi": ["The nomor polisi has already been taken."] }
  }
}
```

Untuk error validasi, `details` berisi pesan per field. Untuk error lain, `details` biasanya `null`.

## Kode error

| Code | HTTP | Arti |
|---|---|---|
| VALIDATION_ERROR | 422 | Input tidak valid. Detail per field ada di `details` |
| UNAUTHENTICATED | 401 | Token tidak ada atau tidak valid |
| INVALID_CREDENTIALS | 401 | Email atau password salah |
| FORBIDDEN | 403 | Peran tidak punya izin untuk aksi ini |
| RESOURCE_NOT_FOUND | 404 | Data dengan ID tersebut tidak ada |
| ENDPOINT_NOT_FOUND | 404 | URL tidak ada |
| METHOD_NOT_ALLOWED | 405 | Method HTTP tidak diizinkan untuk URL ini |
| TOO_MANY_REQUESTS | 429 | Batas request terlampaui. Login: 5 per menit per email, 20 per menit per IP. API: 60 per menit per user |
| CONFLICT | 409 | Data bentrok dengan data yang sudah ada |
| INTERNAL_ERROR | 500 | Error di server. Detail teknis hanya muncul jika `APP_DEBUG=true` |

## Contoh: tambah kendaraan dinas

```bash
curl -X POST http://127.0.0.1:8000/api/v1/kendaraan-dinas \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "nomor_polisi": "B 1234 ABC",
    "merk_kendaraan": "Toyota",
    "tipe_kendaraan": "Avanza G",
    "tahun_produksi": 2020,
    "warna_kendaraan": "Hitam",
    "kondisi": "baik",
    "perangkat_daerah_id": 1,
    "pegawai_id": null
  }'
```

Nomor polisi otomatis diubah ke huruf besar dengan spasi tunggal sebelum divalidasi.

## Peran

| Peran | Akses |
|---|---|
| admin | Semua endpoint, termasuk membuat akun login pegawai |
| operator | Mengelola kendaraan, pegawai, dan perangkat daerah. Tidak bisa membuat akun login atau mengelola pengguna (403) |

Admin tidak bisa menurunkan perannya sendiri atau menonaktifkan akunnya sendiri. Minimal harus ada satu admin yang aktif. Pelanggaran aturan ini dibalas 409.

Akun seeder: `test@example.com` (admin) dan `operator@example.com` (operator). Keduanya memakai password `password`.

## Keamanan

- Semua endpoint kecuali login membutuhkan Bearer token dari Laravel Sanctum.
- Login dibatasi 5 percobaan per menit per email dan IP, serta 20 percobaan per menit per IP.
- Endpoint yang butuh login dibatasi 60 request per menit per user.
- Email tidak ditemukan dan password salah dibalas dengan pesan yang sama.
- Password akun harus 8 sampai 255 karakter.
- Menghapus pegawai juga mencabut semua token dan menghapus akun login pegawai tersebut.
- Setiap respons menyertakan header `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, dan `Cache-Control: no-store`.
- Data yang masuk ke database hanya field yang lolos validasi dan terdaftar di `$fillable` model.
- Di production, set `APP_DEBUG=false` agar detail error internal tidak ikut terkirim.
