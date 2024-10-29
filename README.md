Sebelum menjalankan backend service untuk user manajemen, silahkan jalankan ikuti beberapa langkah dibawah:

sesuaikan .env untuk connect ke postgres. di bawah ini merupakan settingan .env saya
DB_CONNECTION=psql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=user-management-test
DB_USERNAME=postgres
DB_PASSWORD=120302

jalankan composer install, migrasi, dan seeding database

jika tidak ada masalah maka silahkan jalankan service backend dengan perintah php artisan serve

pastikan berjalan pada localhost:8000 karena menyesuaikan fetch API pada backend.

cors middleware juga sudah diterapkan untuk meningkat keamanan dengan hanya menerima request dari domain localhost:3000 (domain frontend)
