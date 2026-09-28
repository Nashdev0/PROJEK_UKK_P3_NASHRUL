# 📖 Panduan Lengkap & Mudah Memahami Kode Aplikasi Pengaduan
*(Versi Terbaru - Final)*

Aplikasi ini menggunakan teknologi Laravel dan berpusat pada **dua jenis pengguna**: **Admin** dan **Siswa**. Karena keduanya memiliki hak akses yang sangat berbeda, alur kodenya dirancang agar mereka tidak saling tercampur.

Mari kita bedah alurnya langkah demi langkah seperti sedang bercerita!

---

## 🚪 Tahap 1: Pintu Masuk (Rute di `routes/web.php`)
File ini ibarat **Papan Petunjuk Jalan** di depan gedung sekolah. Semua orang yang membuka web akan diatur lewat sini.

* **Jalan Login:** Kita membuat dua pintu masuk yang terpisah agar lebih aman:
  * `Route::get('/login')` -> Pintu masuk khusus **Siswa**.
  * `Route::get('/login_admin')` -> Pintu masuk khusus **Admin**.
* **Jalan Register:** `Route::get('/register')` untuk siswa mendaftarkan akun baru (tanpa *confirm password* agar simpel).
* **Jalan Dashboard:** `Route::get('/dashboard')` -> Ruang tunggu utama setelah berhasil masuk.
* **Jalan Khusus (Middleware):**
  * `Route::middleware(['auth:siswa'])` -> Ini adalah **Satpam Penjaga Siswa**. Rute di dalamnya (seperti form lapor) hanya boleh dimasuki oleh Siswa yang bawa tiket (*sudah login*).
  * `Route::middleware(['auth:admin'])` -> Ini **Satpam Penjaga Admin**. Rute di dalamnya (mengatur kategori, dsb) hanya boleh dimasuki oleh Admin.

---

## 👨‍✈️ Tahap 2: Proses Login & Daftar (`AuthController.php`)
File ini berfungsi sebagai "Resepsionis" yang mengecek kecocokan data.

* **Fungsi `loginSiswa()`**: 
  Resepsionis mengecek data NIS dan Password ke "laci" bernama **Tabel Siswa** (menggunakan perintah `Auth::guard('siswa')->attempt(...)`). Kalau cocok, berikan kunci dan persilakan masuk ke dashboard.
* **Fungsi `loginAdmin()`**:
  Mengecek data ke laci bawaan Laravel bernama **Tabel Users** (menggunakan perintah `Auth::attempt(...)`).
* **Fungsi `registerSiswa()`**:
  Menyimpan data NIS, Kelas, dan Password (yang sudah dienkripsi dengan `Hash::make()`) ke tabel siswa. Spesialnya, begitu berhasil mendaftar, fungsi ini akan **otomatis meloginkan** siswa (`Auth::guard('siswa')->login($siswa)`) sehingga mereka tak perlu repot login ulang.

---

## 🎨 Tahap 3: Kerangka Tampilan Utama (`layouts/app.blade.php`)
Daripada membangun *Sidebar* (menu kiri) berulang-ulang di setiap halaman, kita membuat **satu kerangka utama** di sini.

Sistem kerjanya pintar (menggunakan IF):
1. Jika yang masuk adalah Admin (`Auth::guard('admin')->check()`), tampilkan menu *Data Pengaduan* dan *Data Kategori*.
2. Jika yang masuk adalah Siswa (`Auth::guard('siswa')->check()`), tampilkan menu *Kirim Pengaduan* dan *Riwayat Laporan*.
3. **`@yield('content')`**: Ini ibarat area kanvas kosong di sebelah kanan sidebar. Nanti isi halamannya akan digambar (dirender) di area ini secara bergantian.

---

## 🏠 Tahap 4: Halaman Dashboard & Riwayat
* **Dashboard (`dashboard.blade.php`)**:
  Hanya satu file, tapi isinya cerdas. Memakai logika `@if($role == 'admin')` cetak "Anda masuk sebagai admin", dan jika siswa maka cetak "Hai (NIS Siswa)". Sangat bersih dan simpel.
* **Riwayat Siswa (`AspirasiController@index`)**:
  Perintah `$aspirasis = Aspirasi::where('siswa_id', auth()->guard('siswa')->id())->get();` memastikan bahwa tabel riwayat yang muncul **HANYA** laporan milik siswa tersebut (menjaga privasi).

---

## 🗂️ Tahap 5: Fitur CRUD (Create, Read, Update, Delete)
Aplikasi ini sudah menerapkan sistem **CRUD** dengan pembagian hak akses yang ketat:

1. **Bagian Siswa (`AspirasiController.php`)**:
   * **[C] Create**: Siswa bisa membuat/menambah laporan (`create` & `store`).
   * **[R] Read**: Siswa bisa melihat riwayat laporan miliknya sendiri (`index`).
   * *(Siswa tidak boleh mengedit [Update] apalagi menghapus [Delete] laporan agar sekolah punya arsip bukti mutlak).*

2. **Bagian Admin Pengaduan (`AdminController.php`)**:
   * **[R] Read**: Admin bisa melihat **semua** pengaduan yang masuk.
   * **[U] Update**: Admin bertugas memproses pengaduan, mengubah statusnya (Menunggu ➔ Proses ➔ Selesai) serta memberi *feedback* balasan.

3. **Bagian Admin Kategori (`KategoriController.php`)**:
   * Admin memiliki hak **Full CRUD 100%**. Mulai dari menambah kategori baru (C), melihat semua kategori (R), mengubah nama kategori (U), hingga menghapus kategori yang tak terpakai (D).

---
### 💡 Kalimat Kesimpulan (Cocok Untuk Penutup Presentasi Ujian):
> *"Aplikasi ini dibangun menggunakan arsitektur Laravel yang menerapkan konsep **Multi-Authentication (Banyak Penjaga)**. Artinya, keamanan antara Admin dan Siswa dipisahkan secara total dari level database, level URL/Routing (Middleware), hingga level Layout Tampilan. Fitur **CRUD**-nya pun tidak dilepas begitu saja, melainkan dibatasi sesuai peruntukannya—misalnya larangan penghapusan laporan agar validitas data sekolah tetap terjaga. Kode yang dihasilkan dijamin bersih, dinamis, dan sangat aman."*
