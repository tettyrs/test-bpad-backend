# Panduan untuk Agen AI

aplikasi dibuat menggunakan claude code dengan model haiku 5.5

## Konvensi kerja

- Baca dokumentasi di `docs/` sebelum mengubah kode. Aturan lengkapnya ada di `../.agent/rules/documentation-first.md`.
- Skill yang tersedia ada di `../.agent/skills/`.
- Endpoint dan format respons: `docs/api/README.md` dan `docs/api/openapi.yaml`.
- Jangan commit `.env`, kredensial, atau data pribadi. File tersebut sudah ada di `.gitignore`.
