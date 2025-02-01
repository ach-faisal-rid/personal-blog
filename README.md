website ini masih dalam penbangunan build🏗️.

ini baru masuk tahap membuat tampilan yang bagus.
saya pakai laravel 10 📜, jetstream inertia 📦, dan terakhir adalah filament 🧵.

ini masih di tahap. memperbaiki tampilan awal. dan juga masuk ke tahap menambahkan change dark theme.

untuk menjalankan project ini.

setting .env
`cp .env.example .env`
untuk membuat env yang nanti akan di pakai untuk database localhost.

jalankan 
`php artisan key:generate --ansi`
untuk mengenerasi key.

jalankan
`php arisan migrate` 
untuk migrasi database yang sudah dibuat.

jalankan 
`php artisan serve` 
untuk menjalaknakn server php.

jalankan 
`npm run dev` 
alasannya karena saya pakai vue dan diperlukan npm kalau ingin menjalankan halamannya.

buka lewat
`localhost:8000`

buka admin lewat 
`localhost:8000/admin`