# API Documentation — The Lost Word Adventure

Base URL: `https://fuad.cognidev.my.id/api`

## Endpoints

### 1. GET /api/readsoal

Mengambil semua data soal.

**Response:**

```json
[
  {
    "id": 1,
    "soal": "Bird",
    "level": 1
  },
  {
    "id": 11,
    "soal": "Apple",
    "level": 2
  }
]
```

---

### 2. GET /api/readsoal-by-id/{level}

Mengambil **1 soal acak** berdasarkan level. Parameter `{level}` diisi dengan angka 1, 2, atau 3.

**Parameter:**

| Nama | Tipe | Wajib | Keterangan |
|------|------|-------|------------|
| level | integer | Ya | Level soal (1, 2, atau 3) |

**Response — Berhasil (200):**

```json
{
  "id": 5,
  "soal": "Tree",
  "level": 1
}
```

**Response — Tidak ditemukan:**

```json
{
  "message": "Data tidak ditemukan"
}
```

---

## Struktur Database

### Tabel `soal`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | INT (11) | Primary key, auto increment |
| soal | TEXT | Kata soal |
| level | INT (11) | Level soal (1, 2, atau 3) |

---

## Level Soal

| Level | Jumlah Huruf per Kata | Jumlah Soal |
|-------|----------------------|-------------|
| 1 | 4 huruf | 10 |
| 2 | 5 huruf | 10 |
| 3 | 6 huruf | 10 |

---

## Contoh Penggunaan

### JavaScript (Fetch)

```javascript
// Ambil soal acak level 1
fetch('https://fuad.cognidev.my.id/api/readsoal-by-id/1')
  .then(res => res.json())
  .then(data => console.log(data));
```

### cURL

```bash
# Ambil semua soal
curl https://fuad.cognidev.my.id/api/readsoal

# Ambil 1 soal acak level 2
curl https://fuad.cognidev.my.id/api/readsoal-by-id/2
```
