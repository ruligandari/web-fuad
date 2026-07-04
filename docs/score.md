# Analisis Fitur Skor & API
Dokumen ini berisi analisis struktur database, alur (flow), dan endpoint API untuk fitur skor pada aplikasi ini. Dokumen ini dapat digunakan sebagai referensi bagi AI Agent lain untuk mengimplementasikan fungsionalitas yang persis sama pada proyek yang berbeda.

## 1. Struktur Database
Fitur skor menggunakan tabel bernama `siswa` untuk menyimpan nama, level (tingkat kesulitan atau level soal), dan hasil nilai (skor).

- **Nama Tabel**: `siswa`
- **Primary Key**: `id` (Auto Increment, INT)
- **Kolom Tabel**:
  1. `id` (INT, Primary Key, Auto Increment)
  2. `nama` (VARCHAR/String) - Menyimpan nama user/siswa.
  3. `level` (VARCHAR/INT) - Menyimpan level/tingkatan soal yang dikerjakan.
  4. `score` (INT/VARCHAR) - Menyimpan nilai/skor akhir yang didapat.
- **Catatan Tambahan**: Tabel ini *tidak* menggunakan field timestamps bawaan (seperti `created_at` atau `updated_at`) atau soft deletes.

## 2. Alur Kerja (Flow)

### Flow API Submit Skor (Sisi Klien/Frontend)
1. Klien mengirimkan *HTTP POST Request* ke endpoint API untuk mengirimkan data skor akhir.
2. Request dapat berbentuk payload **JSON** maupun **Form-Data** (POST variables).
3. API akan memeriksa apakah field `nama`, `level`, dan `score` sudah diisi semua.
4. Jika ada field yang kosong atau bernilai null, API langsung merespon dengan JSON gagal dan tidak memproses insert.
5. Jika validasi lolos, data di-insert ke dalam tabel `siswa`.
6. API mengembalikan respon sukses dalam bentuk JSON.

### Flow Manajemen (Sisi Admin)
1. Admin memiliki halaman khusus untuk melihat daftar nilai (endpoint: `admin/siswa`).
2. Controller Admin akan mengambil semua data dari tabel `siswa` dengan urutan descending berdasarkan `id` (`ORDER BY id DESC`), lalu menampilkannya ke View.
3. Admin dapat menghapus data nilai spesifik menggunakan parameter `id` (endpoint: `admin/siswa/delete/(:num)`). Setelah menghapus, muncul flash data "Data siswa berhasil dihapus".

## 3. Spesifikasi Endpoint API
Endpoint ini wajib dibuat **sama persis** secara struktur respons dan request agar fungsi klien tetap berjalan dengan baik.

### Submit Score
- **URL Endpoint**: `api/submit-score`
- **Method**: `POST`
- **Request Payload** (Mendukung `application/json` atau `application/x-www-form-urlencoded`):
  ```json
  {
      "nama": "Budi",
      "level": "1",
      "score": 100
  }
  ```
- **Response Sukses (HTTP 200 OK)**:
  Jika data berhasil di-insert ke database.
  ```json
  {
      "success": true,
      "message": "Data berhasil disimpan"
  }
  ```
- **Response Gagal - Validasi (HTTP 200 OK)**:
  Jika payload `nama`, `level`, atau `score` ada yang kosong.
  ```json
  {
      "success": false,
      "message": "Mohon lengkapi data: nama, level, score"
  }
  ```
- **Response Gagal - Sistem/Error Catch (HTTP 200 OK)**:
  Jika terjadi exception saat proses insert ke database.
  ```json
  {
      "success": false,
      "message": "Pesan error dari sistem"
  }
  ```

---
*Catatan untuk Agen AI: Saat membuat ulang fitur ini, pastikan routing pada `Routes.php` atau setara menunjuk ke fungsi yang mengimplementasikan spesifikasi di atas dengan presisi, karena integrasi klien ke backend sangat bergantung pada bentuk payload (nama, level, score) dan response JSON ini.*
