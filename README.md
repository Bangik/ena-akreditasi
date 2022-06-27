
# Project Akreditasi sekolah

Dikembangkan dengan bahasa pemograman PHP 7.4 dan Framework Laravel

Terdapat 2 versi, versi 1.0.0 dan versi 1.1.0

Perbedaan dari kedua versi tersebut yaitu pada simulasi dokumen.
Versi 1.0.0, satu simulasi nilai memiliki satu simulasi dokumen.
Versi 1.1.0, semua simulasi nilai hanya memiliki satu simulasi dokumen.


## Cara install project Akreditasi

Download Zip

Install dependencies

```bash
  composer install
```

Copy file .env.example dan rename menjadi .env

```bash
  cp .env.example .env
```

Edit .env file dan sesuaikan kredensial database postgres

Generate key

```bash
  php artisan key:generate
```

Migrasi database

```bash
  php artisan migrate
```

Jalankan project

```bash
  php artisan serve
```

Import data untuk simulasi

- Kunjungi url http://localhost:8080/import
- import data dari excel sesuai form yang tersedia secara berurutan

Jika database diimport secara langsung ke postgres, maka tidak perlu menjalankan perintah migrasi database dan import data simulasi
## 🚀 About Me
Jika terdapat kendala, dapat menghubungi Dino +62 812 5236 7128

