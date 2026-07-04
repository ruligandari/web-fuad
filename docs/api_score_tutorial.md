# Tutorial & Dokumentasi API Submit Score

Dokumen ini berisi panduan lengkap untuk menggunakan endpoint API `submit-score`. Panduan ini dirancang untuk memudahkan developer game (misalnya menggunakan Unity, Construct, atau web murni) dalam mengirimkan data skor pemain ke database server.

---

## 1. Struktur Data

Data yang dibutuhkan oleh server untuk menyimpan skor sangat sederhana dan terdiri dari 3 parameter utama:

| Parameter | Tipe Data | Wajib | Keterangan |
| :--- | :--- | :---: | :--- |
| `nama` | String | Ya | Nama dari pemain/siswa. |
| `level` | String / Integer | Ya | Level permainan atau soal yang diselesaikan (contoh: 1, 2, 3). |
| `score` | Integer | Ya | Nilai akhir atau skor yang didapatkan pemain. |

> **PENTING:**
> Ketiga parameter di atas **wajib** dikirim. Jika salah satu kosong, API akan menolak permintaan dan mengembalikan pesan error.

---

## 2. Spesifikasi Endpoint API

- **URL API**: `https://fuad.cognidev.my.id/api/submit-score`
- **HTTP Method**: `POST`
- **Content-Type yang didukung**: 
  - `application/json` (Disarankan)
  - `application/x-www-form-urlencoded` (Form-Data)

### Format Response (JSON)

**Jika Berhasil (HTTP Status 200)**
```json
{
    "success": true,
    "message": "Data berhasil disimpan"
}
```

**Jika Gagal Validasi (HTTP Status 200)**
```json
{
    "success": false,
    "message": "Mohon lengkapi data: nama, level, score"
}
```

---

## 3. Contoh Implementasi (Tutorial)

Berikut adalah beberapa cara untuk melakukan HTTP POST Request ke endpoint ini dari berbagai platform.

### A. Menggunakan JavaScript (Fetch API - Web / HTML5 Games)
Metode ini sangat cocok jika game dibuat menggunakan engine berbasis web (Phaser, Construct 3, Javascript Native).

```javascript
// Data pemain yang akan dikirim
const playerData = {
    nama: "Budi Santoso",
    level: "1",
    score: 100
};

// Fungsi untuk mengirim skor
async function submitScore(data) {
    try {
        const response = await fetch('https://fuad.cognidev.my.id/api/submit-score', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        
        if (result.success) {
            console.log("Skor berhasil dikirim:", result.message);
        } else {
            console.error("Gagal mengirim skor:", result.message);
        }
    } catch (error) {
        console.error("Terjadi kesalahan jaringan:", error);
    }
}

// Panggil fungsi
submitScore(playerData);
```

### B. Menggunakan C# (Unity WebRequest)
Jika game dikembangkan menggunakan Unity Engine, gunakan `UnityWebRequest`.

```csharp
using UnityEngine;
using UnityEngine.Networking;
using System.Collections;
using System.Text;

public class ScoreManager : MonoBehaviour
{
    private string apiUrl = "https://fuad.cognidev.my.id/api/submit-score";

    public void SendPlayerScore(string playerName, string level, int score)
    {
        StartCoroutine(PostScore(playerName, level, score));
    }

    private IEnumerator PostScore(string playerName, string level, int score)
    {
        // Format data menjadi JSON
        string jsonData = $"{{\"nama\":\"{playerName}\", \"level\":\"{level}\", \"score\":{score}}}";

        using (UnityWebRequest request = new UnityWebRequest(apiUrl, "POST"))
        {
            byte[] bodyRaw = Encoding.UTF8.GetBytes(jsonData);
            request.uploadHandler = new UploadHandlerRaw(bodyRaw);
            request.downloadHandler = new DownloadHandlerBuffer();
            request.SetRequestHeader("Content-Type", "application/json");

            yield return request.SendWebRequest();

            if (request.result == UnityWebRequest.Result.ConnectionError || request.result == UnityWebRequest.Result.ProtocolError)
            {
                Debug.LogError("Error: " + request.error);
            }
            else
            {
                Debug.Log("Response: " + request.downloadHandler.text);
            }
        }
    }
}
```

### C. Pengujian Manual (Menggunakan Postman / cURL)
Untuk menguji apakah API berjalan, Anda bisa menggunakan `cURL` melalui Terminal/CMD:

```bash
curl -X POST https://fuad.cognidev.my.id/api/submit-score \
-H "Content-Type: application/json" \
-d "{\"nama\":\"Test Player\",\"level\":\"2\",\"score\":95}"
```

> **Catatan:**
> URL di atas menggunakan domain server aktif saat ini (`https://fuad.cognidev.my.id/`). Jika server dipindahkan, pastikan untuk menggantinya dengan URL domain yang baru.
