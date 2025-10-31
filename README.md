🧾 QR Code Generator with Logo (PHP)
Script sederhana untuk membuat QR Code secara massal dari file CSV menggunakan PHP dan library phpqrcode, dengan dukungan logo di tengah QR.
Cocok untuk kebutuhan seperti ID santri, kartu pelajar, sistem izin, dan lain-lain.

⚙️ Langkah 0 — Prasyarat
Sebelum menjalankan script, pastikan:
1.	PHP 7+ sudah terpasang di sistem kamu.
2.	Ekstensi GD aktif (dibutuhkan untuk manipulasi gambar).
o	Cek dengan:
o	php -m | grep gd
atau buat file phpinfo();
3.	Library PHP QR Code sudah diunduh
o	Contoh: phpqrcode di SourceForge
o	Simpan foldernya di dalam proyek kamu, misal: /phpqrcode/
4.	Siapkan logo.png (PNG transparan) dan letakkan di folder proyek.

🧩 Langkah 1 — Siapkan Data CSV
Buat file bernama data.csv (UTF-8) dengan isi seperti ini:
no_induk
785
786
787
Simpan di folder yang sama dengan script PHP.

🧠 Langkah 2 — Script PHP (generate_qr.php)
Script utama untuk membaca CSV dan membuat QR Code satu per satu, lengkap dengan logo di tengah.

💻 Langkah 3 — Jalankan Script
Cara 1 — Jalankan lewat Command Prompt (cara paling mudah)
Buka Command Prompt, lalu jalankan:
cd C:\laragon\www\generator_qrcode
php generate_qr.php
Jika berhasil, akan muncul pesan seperti:
3 QR Code selesai dibuat di folder: C:\laragon\www\generator_qrcode\preview\
Logo ditambahkan dari: C:\laragon\www\generator_qrcode\logo.png

Cara 2 — Jalankan lewat browser (opsi lain)
Kamu juga bisa buka lewat browser:
(http://localhost/generator_qrcode/generate_qr.php)
Output-nya akan muncul di halaman web:
3 QR Code selesai dibuat di folder: C:\laragon\www\generator_qrcode/preview/ Logo ditambahkan dari: C:\laragon\www\generator_qrcode/logo.png

🧰 Tips Tambahan
•	Gunakan QR_ECLEVEL_H untuk toleransi logo yang tinggi.
•	Jika QR sulit discan:
o	Perkecil ukuran logo (misal jadi 1/7 dari QR).
o	Perbesar ukuran QR ($matrixPointSize = 12).
•	Pastikan logo PNG transparan dan kontras tinggi (hindari warna redup).

📦 Fitur yang Akan Datang
•	Ambil data dari database MySQL langsung.
•	Kompres hasil jadi ZIP otomatis.
•	Ubah ukuran & posisi logo secara dinamis.