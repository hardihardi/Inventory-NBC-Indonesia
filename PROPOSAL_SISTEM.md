# Proposal Sistem: Sistem Informasi Inventory Material Produk Tekstil Berbasis Web

## PT NBC Indonesia

Sistem ini dirancang untuk mengotomatisasi seluruh siklus manajemen inventori, produksi, dan keuangan PT NBC Indonesia dengan pendekatan modern, aman, dan efisien.

---

## 👥 1. STRUKTUR PERAN & TANGGUNG JAWAB

### 🔐 1.1 Administrator (Super Admin)

**Peran:** Pengelola Teknis & Keamanan Sistem.  
**Kode Akses:** `admin@gmail.com`  
**Tanggung Jawab Utama:** Menjaga stabilitas aplikasi, keamanan data, dan manajemen hak akses pengguna.

-   **Manajemen Pengguna:** Registrasi karyawan baru dan penonaktifan karyawan lama.
-   **Hak Akses (RBAC):** Pengetatan menu berdasarkan peran kerja (Role & Permissions).
-   **Audit & Keamanan:** Memantau `Activity Logs`, memastikan perlindungan CSRF & Middleware.
-   **Data Recovery:** Pemulihan data terhapus via fitur _Soft Deletes_.
-   **Konfigurasi:** Pengaturan profil perusahaan, logo, dan standarisasi dokumen.

### 📈 1.2 Manajer Operasional (Manager)

**Peran:** Pengambil Keputusan Strategis.  
**Kode Akses:** `manajer@gudang.com`  
**Tanggung Jawab Utama:** Memantau kinerja operasional melalui data real-time.

-   **Dashboard:** Analisis pergerakan stok, tren penjualan, dan performa produksi.
-   **Evaluasi:** Analisis Laba Rugi serta identifikasi barang _Slow Moving_ vs _Fast Moving_.
-   **Approval:** Persetujuan akhir untuk transaksi bernilai tinggi atau penyesuaian stok kritis.

### 💰 1.3 Finance (Keuangan)

**Peran:** Pengawas Aset & Arus Kas.  
**Kode Akses:** `finance@gudang.com`  
**Tanggung Jawab Utama:** Mengelola aspek finansial inventory dan transaksi.

-   **Valuasi Aset:** Monitoring nilai Rupiah aset yang mengendap di gudang (Neraca).
-   **Arus Kas:** Pencatatan Piutang (Sales) dan Hutang (Purchase).
-   **Biaya Operasional:** Manajemen biaya di luar transaksi utama (_Expenses_).
-   **Audit:** Sinkronisasi data sistem dengan bukti fisik faktur/tagihan.

### 🛡️ 1.4 Kepala Gudang (Warehouse Supervisor)

**Peran:** Pengendali Mutu & Stok Fisik.  
**Kode Akses:** `supervisor@gudang.com`  
**Tanggung Jawab Utama:** Menjamin akurasi fisik vs sistem dan validasi kerja staff.

-   **Stock Opname:** Validasi selisih stok secara berkala di sistem.
-   **Transfer Stok:** Approval perpindahan barang antar gudang/rak.
-   **Manajemen Retur:** Validasi barang kembali dari customer atau ke supplier.
-   **Supervisi:** Memantau SOP kerja staff melalui Jurnal Stok (Scan QR).

### 📦 1.5 Staff Gudang (Warehouse Staff)

**Peran:** Operator Lapangan (Eksekutor).  
**Kode Akses:** `staff@gudang.com`  
**Tanggung Jawab Utama:** Pencatatan mutasi barang fisik secara real-time.

-   **Penerimaan:** Input Pembelian Baru dan pemeriksaan fisik barang masuk.
-   **Labeling:** Penempelan QR Code pada setiap item baru.
-   **Pengeluaran:** Picking barang via Scan QR (Mobile) untuk sales/produksi.
-   **Data Master:** Pemeliharaan data produk, kategori, dan satuan.

### 🧵 1.6 Bagian Produksi / PPIC (Production Planning)

**Peran:** Perencana Material & Produksi.  
**Kode Akses:** `produksi@gudang.com`  
**Tanggung Jawab Utama:** Perencanaan kebutuhan bahan dan pencatatan hasil produksi.

-   **Planning:** Pembuatan rencana produksi berdasarkan order penjualan.
-   **Material Request:** Pengajuan bahan baku (Kain/Benang) ke gudang via sistem.
-   **Output Tracking:** Input barang jadi (_Finished Goods_). Sistem otomatis memotong stok bahan dan menambah stok produk jadi.

---

## 🔄 2. ALUR KERJA TERINTEGRASI (Workflows)

**Kasus: Siklus Produksi & Penjualan**

1. **Manager** memantau stok tipis di Dashboard.
2. **PPIC** membuat _Material Request_ untuk mulai produksi.
3. **Staff Gudang** menerima notifikasi, ambil kain via **Scan QR** (Stok Bahan Berkurang).
4. **PPIC** selesai produksi, input "Produk Selesai" (Stok Jadi Bertambah).
5. **Staff Gudang** proses pengiriman via menu Penjualan (Stok Jadi Berkurang).
6. **Finance** terbitkan invoice dan catat pembayaran masuk (Kas Bertambah).
7. **Kepala Gudang** validasi akurasi akhir via Stock Opname.
8. **Admin** audit seluruh aktivitas via _Security Logs_.

---

## 🛠️ 3. SPESIFIKASI TEKNIS & KEAMANAN

| Fitur              | Deskripsi                                                                      |
| ------------------ | ------------------------------------------------------------------------------ |
| **Mobile-First**   | Optimasi penggunaan Scanner QR Code melalui HP/Tablet di area gudang.          |
| **Integrasi Data** | _Soft Deletes_ memastikan riwayat audit tetap terjaga meskipun data "dihapus". |
| **Keamanan Akun**  | Enkripsi Bcrypt militer dan proteksi akses ketat per role.                     |
| **Audit Trail**    | Pencatatan otomatis "Siapa, Melakukan Apa, Kapan" untuk setiap perubahan.      |

---

**PT NBC Indonesia**  
_Membangun Efisiensi, Menjaga Akurasi._
