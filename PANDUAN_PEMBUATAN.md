# Panduan Pembuatan & Implementasi Sistem Inventori PT NBC

## "Membangun Ekosistem Inventori yang Cerdas dan Terintegrasi"

Selamat datang di Panduan Pembuatan! Dokumen ini dirancang untuk membantu Anda memahami bagaimana sistem ini dibangun dan bagaimana cara mengimplementasikannya secara bertahap agar mudah dipelajari.

---

## 🚀 Fase 1: Fondasi Sistem (Pondasi Data)

Sebelum melakukan transaksi, kita harus membangun "Rumah" untuk data kita.

### 1. Menentukan Kamar (Gudang)

Sistem tidak bisa menyimpan barang jika tidak ada tempatnya.

-   **Tugas:** Buat minimal satu gudang utama.
-   **Tips:** Pisahkan gudang berdasarkan fungsinya (misal: Gudang Bahan Baku vs Gudang Barang Jadi).

### 2. Menentukan Ukuran (Satuan/Units)

Penting agar timbangan dan hitungan selalu akurat.

-   **Tugas:** Daftarkan satuan seperti `Kg`, `Pcs`, `Meter`.
-   **Tips:** Gunakan fitur konversi jika Anda sering membeli dalam unit besar (Roll) tapi menjual dalam unit kecil (Meter).

### 3. Mengelompokkan Barang (Kategori)

Agar pencariannya mudah dan laporan lebih rapi.

-   **Tugas:** Buat kategori seperti `Benang`, `Kain`, `Zat Kimia`.

---

## 📦 Fase 2: Manajemen Produk (Isi Rumah)

Setelah pondasi siap, saatnya memasukkan barang-barang.

### 1. Identitas Produk (SKU)

Setiap barang wajib punya "KTP" unik yang disebut SKU.

-   **Tugas:** Input produk dengan nama yang jelas dan SKU yang konsisten.
-   **Logic:** Harga Beli (untuk modal) dan Harga Jual (untuk profit) harus diisi dengan benar.

### 2. Stok Minimum (Alert System)

Sistem akan memberi tahu jika barang hampir habis.

-   **Tugas:** Isi kolom `Stok Minimum`. Jika stok fisik di bawah angka ini, sistem akan memberi tanda peringatan (warna merah/kuning).

---

## 💸 Fase 3: Alur Transaksi (Mesin Bisnis)

Di sinilah uang dan barang mulai bergerak.

### 1. Alur Masuk (Pembelian/Purchase)

-   **Konsep:** Membeli barang dari **Supplier**.
-   **Efek:** Stok barang bertambah ⬆️, Saldo Kas berkurang atau Hutang bertambah ⬇️.

### 2. Alur Keluar (Penjualan/Sales)

-   **Konsep:** Menjual barang ke **Customer**.
-   **Efek:** Stok barang berkurang ⬇️, Saldo Kas bertambah atau Piutang bertambah ⬆️.

### 3. Alur Koreksi (Adjustment)

Jika terjadi selisih antara catatan komputer dan kenyataan di gudang.

-   **Tugas:** Gunakan menu _Stock Adjustment_ untuk menyesuaikan angka.

---

## 📊 Fase 4: Monitoring & Analitik (Mata Bisnis)

Melihat hasil kerja keras Anda melalui angka.

### 1. Memahami Valuasi

-   **Pertanyaan:** "Berapa total uang saya yang berbentuk barang di gudang saat ini?"
-   **Solusi:** Lihat _Laporan Valuasi_. Ini adalah aset Anda.

### 2. Memahami Arus Kas (Cash Flow)

-   **Pertanyaan:** "Ke mana perginya uang saya bulan ini?"
-   **Solusi:** Dashboard Keuangan akan memecah pengeluaran Anda (misal: 70% untuk beli benang, 30% operasional).

---

## 🔐 Fase 5: Keamanan & Hak Akses (Penjaga Rumah)

Memastikan setiap orang bekerja sesuai porsinya.

### 1. Pembagian Peran (Roles)

-   **Admin:** Pemilik kunci semua pintu.
-   **Staff Gudang:** Hanya bisa mengelola barang dan stok.
-   **Finance:** Hanya bisa melihat laporan uang dan hutang/piutang.

---

## 💡 Tips Belajar Cepat

1. **Gunakan Data Sampel:** Jangan takut mencoba dengan memasukkan 1-2 data dummy terlebih dahulu.
2. **Cek Jurnal Stok:** Jika Anda bingung kenapa stok barang berubah, buka _Stock Ledger_. Di sana ada histori "Siapa, Kapan, dan Kenapa" stok itu berubah.
3. **Gunakan Search:** Gunakan kolom pencarian di setiap tabel untuk mempercepat kerja.

---

**PT NBC Indonesia - Efisiensi Tanpa Batas**
_Dokumen ini bersifat dinamis dan akan terus diperbarui seiring perkembangan sistem._
