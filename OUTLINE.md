# OUTLINE SISTEM INVENTORI PT NBC INDONESIA

## Dokumentasi Lengkap & Terstruktur

---

## 📚 BAGIAN I: PENGENALAN SISTEM

### 1.1 Tentang Sistem

-   **Nama Sistem:** Inventory Management System PT NBC Indonesia
-   **Platform:** Web-based (Laravel 12 + MySQL)
-   **Tujuan:** Mengotomatisasi pengelolaan inventori, produksi, dan transaksi
-   **Target Pengguna:** Staff Gudang, Finance, Sales, PPIC, Management

### 1.2 Fitur Utama Sistem

-   ✅ Manajemen Master Data (Produk, Kategori, Satuan, Gudang, Relasi Bisnis)
-   ✅ Transaksi Pembelian & Penjualan
-   ✅ Manajemen Stok Multi-Gudang
-   ✅ Material Request & Production Tracking
-   ✅ Hutang & Piutang Management
-   ✅ Cash Flow & Financial Dashboard
-   ✅ Reporting & Analytics (Valuasi, Stock Ledger, Profit Analysis)
-   ✅ Role-Based Access Control (RBAC)
-   ✅ Import/Export CSV untuk Data Massal
-   ✅ Barcode Printing & Scanning

### 1.3 Teknologi yang Digunakan

-   **Backend:** Laravel 12, PHP 8.2+
-   **Frontend:** Blade Templates, Bootstrap 5, jQuery, Chart.js
-   **Database:** MySQL 8.0+
-   **Server:** Apache/Nginx (Laragon untuk development)
-   **Tools:** DataTables, Select2, SweetAlert2, NProgress

---

## 📋 BAGIAN II: STRUKTUR ORGANISASI & PERAN

### 2.1 Hierarki Pengguna

```
┌─────────────────────────────────────┐
│         Administrator               │  ← Full System Access
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│      Manager / Direktur             │  ← Read-Only All Modules
└─────────────────────────────────────┘
           ↓
┌──────────┬──────────┬──────────┬────────────┐
│ Finance  │Warehouse │  Sales   │    PPIC    │
└──────────┴──────────┴──────────┴────────────┘
```

### 2.2 Detail Peran & Tanggung Jawab

#### A. Administrator

-   **Kewenangan:** Full CRUD semua modul
-   **Tugas Utama:**
    -   Setup sistem (Profil Perusahaan, Logo, User Management)
    -   Assign roles & permissions
    -   Approve Stock Adjustment
    -   Audit Log & Security Monitoring

#### B. Manager / Direktur

-   **Kewenangan:** Read-Only semua modul
-   **Tugas Utama:**
    -   Review dashboard utama
    -   Analisis laporan keuangan
    -   Monitor kesehatan stok (Dead Stock, Low Stock)
    -   Decision making berdasarkan data

#### C. Finance (Keuangan)

-   **Kewenangan:**
    -   Create/Edit: Pembelian, Cash Flow, Pengeluaran
    -   View: Penjualan, Dashboard Keuangan
    -   Manage: Hutang & Piutang
-   **Tugas Utama:**
    -   Input pembelian dari supplier
    -   Bayar hutang & terima piutang
    -   Rekonsiliasi cash flow bulanan
    -   Generate laporan keuangan

#### D. Warehouse Staff

-   **Kewenangan:**
    -   CRUD: Produk, Kategori, Satuan, Gudang
    -   Create: Transfer Stok, Stock Adjustment (butuh approval)
    -   View: Pembelian, Material Request
-   **Tugas Utama:**
    -   Maintain akurasi stok fisik vs sistem
    -   Transfer barang antar gudang
    -   Stock opname berkala
    -   Fulfill material request dari PPIC

#### E. Sales / Kasir

-   **Kewenangan:**
    -   Create/Edit: Penjualan, Customer
    -   Create: Retur Penjualan
    -   View: Produk (harga & stok)
-   **Tugas Utama:**
    -   Buat transaksi penjualan
    -   Cetak invoice
    -   Proses retur customer
    -   Follow-up piutang (koordinasi dengan Finance)

#### F. PPIC / Production

-   **Kewenangan:**
    -   Create/Edit: Material Request
    -   Update: Status Produksi (Start, Finish)
    -   View: Laporan Produksi
-   **Tugas Utama:**
    -   Ajukan kebutuhan bahan baku
    -   Monitor progress produksi
    -   Analisis efisiensi pemakaian material

---

## 🔄 BAGIAN III: ALUR KERJA OPERASIONAL (WORKFLOWS)

### 3.1 Procurement Workflow (Pengadaan)

**Alur 1: Pembelian Tunai**

```
Finance Input Pembelian → Pilih Supplier → Tambah Item →
Bayar Penuh (Status: Lunas) → Stok +, Kas - → Cetak PO
```

**Alur 2: Pembelian Kredit (Hutang)**

```
Finance Input Pembelian → Pilih Supplier → Tambah Item →
Bayar Partial/0 → Set Jatuh Tempo → Stok +, Hutang + →
Finance Monitor Jatuh Tempo → Bayar Hutang → Hutang -, Kas -
```

**Alur 3: Retur Pembelian**

```
Barang Rusak/Salah → Finance: Proses Retur → Pilih Item →
Stok -, Hutang - (atau Kas +)
```

### 3.2 Sales Workflow (Penjualan)

**Alur 1: Penjualan Tunai**

```
Sales Buat Transaksi → Pilih Customer → Tambah Produk →
Diskon & Pajak → Bayar Penuh → Stok -, Kas + → Cetak Invoice
```

**Alur 2: Penjualan Kredit (Piutang)**

```
Sales Buat Transaksi → Tambah Produk → Bayar Partial →
Set Jatuh Tempo → Stok -, Piutang + →
Finance: Terima Pelunasan → Piutang -, Kas +
```

**Alur 3: Retur Penjualan**

```
Customer Return → Sales: Proses Retur → Pilih Item →
Stok +, Piutang - (atau Kas -)
```

### 3.3 Production Workflow (Material Request)

```
PPIC: Buat Request (+ Produk Jadi, + Bahan Baku) → Status: Pending →
Warehouse: Cek Stok → Tersedia? → Warehouse: Siapkan → Status: Ready →
Produksi: Ambil Barang → PPIC: Mulai Produksi → Stok Bahan - → Status: In Production →
Proses Fisik Produksi... →
PPIC: Selesaikan → Input Hasil → Stok Jadi + → Status: Finished
```

### 3.4 Inventory Management Workflow

**Stock Adjustment:**

```
Warehouse: Stock Opname → Ada Selisih? →
Buat Adjustment → Tulis Alasan → Submit →
Admin: Review & Approve → Stok Terkoreksi
```

**Transfer Stok:**

```
Warehouse: Pilih Gudang Asal & Tujuan → Pilih Item & Qty →
Submit → Stok Asal -, Stok Tujuan + → Tercatat di Jurnal
```

### 3.5 Finance Workflow

**Monitoring Harian:**

```
Finance Login → Buka Dashboard Keuangan →
Cek Piutang Overdue → Follow-up Customer →
Cek Hutang Jatuh Tempo → Siapkan Pembayaran
```

**Rekonsiliasi Bulanan:**

```
Export Cash Flow → Bandingkan dengan Bank Statement →
Ada Selisih? → Lacak Transaksi → Input Manual (jika perlu) →
Saldo Match → Archive Laporan
```

---

## 📊 BAGIAN IV: MODUL & FITUR DETAIL

### 4.1 Modul Master Data

#### A. Kategori Produk

-   **Fungsi:** Grouping produk untuk analisis
-   **Field:** Nama Kategori, Deskripsi
-   **Contoh:** Benang, Kain, Kimia, Aksesoris

#### B. Satuan (Units)

-   **Fungsi:** Standarisasi ukuran barang
-   **Field:** Nama Satuan, Singkatan
-   **Fitur Tambahan:** Unit Conversion (1 Roll = 50 Meter)
-   **Contoh:** Kg, Pcs, Meter, Roll, Lusin

#### C. Gudang (Warehouses)

-   **Fungsi:** Lokasi penyimpanan fisik
-   **Field:** Nama Gudang, Lokasi, PIC
-   **Contoh:** Gudang Utama, Gudang Bahan Baku, Gudang Jadi

#### D. Produk (Items)

-   **Field Utama:**
    -   Nama, SKU (unique), Barcode
    -   Kategori, Satuan
    -   Harga Beli (Purchase Price)
    -   Harga Jual (Sale Price)
    -   Stok Minimum (Alert Threshold)
    -   Foto Produk
-   **Fitur:**
    -   Cetak Barcode
    -   Import/Export CSV
    -   Multi-Warehouse Stock View

#### E. Supplier

-   **Field:** Nama, Alamat, PIC, Telepon, Email, Termin Bayar
-   **Relasi:** One-to-Many dengan Pembelian

#### F. Customer

-   **Field:** Nama, Alamat, Telepon, Email, Kategori Bisnis
-   **Fitur:** Dropdown "Other" untuk kategori custom
-   **Relasi:** One-to-Many dengan Penjualan

### 4.2 Modul Transaksi

#### A. Pembelian (Purchases)

-   **Input:**
    -   Supplier, Tanggal, No. Invoice Supplier
    -   Item: Produk + Qty + Harga Beli
    -   Subtotal, Pajak (PPN), Total
    -   Pembayaran: Jumlah Dibayar, Jatuh Tempo (jika kredit)
-   **Output:**
    -   Stok bertambah
    -   Hutang bertambah (jika kredit)
    -   Cash Flow tercatat
-   **Fitur:** Retur Pembelian, Bayar Hutang

#### B. Penjualan (Sales)

-   **Input:**
    -   Customer, Tanggal
    -   Item: Produk + Qty (harga auto-fill)
    -   Diskon (% atau Nominal)
    -   Pajak (% atau Nominal)
    -   Grand Total
    -   Pembayaran: Jumlah Dibayar, Kembalian, Jatuh Tempo
-   **Output:**
    -   Stok berkurang
    -   Piutang bertambah (jika kredit)
    -   Cash Flow tercatat
-   **Fitur:** Cetak Invoice, Retur Penjualan, Terima Piutang

#### C. Transfer Stok

-   **Fungsi:** Perpindahan barang antar gudang
-   **Input:** Gudang Asal, Gudang Tujuan, Item + Qty
-   **Output:** Stok di gudang asal -, gudang tujuan +

#### D. Stock Adjustment

-   **Fungsi:** Koreksi selisih stok
-   **Input:** Item, Gudang, Stok Fisik, Alasan
-   **Output:** Stok terkoreksi (butuh approval Admin)

#### E. Material Request (PPIC)

-   **Fungsi:** Permintaan bahan baku untuk produksi
-   **Input:**
    -   Produk Output (barang jadi)
    -   Target Qty
    -   Bahan Baku: Item + Qty
-   **Status Flow:** Pending → Ready → In Production → Finished
-   **Output:** Stok bahan -, stok jadi +

### 4.3 Modul Keuangan

#### A. Dashboard Keuangan

-   **KPI Cards:**
    -   Saldo Kas (All-time)
    -   Net Movement (Periode)
    -   Total Piutang & Overdue
    -   Total Hutang & Overdue
-   **Charts:**
    -   Arus Kas 6 Bulan (Bar Chart)
    -   Distribusi Pengeluaran (Doughnut)
-   **Tables:**
    -   Top 5 Piutang Jatuh Tempo
    -   Top 5 Hutang Jatuh Tempo

#### B. Hutang (Accounts Payable)

-   **View:** Daftar pembelian yang belum lunas
-   **Filter:** Supplier, Status, Jatuh Tempo
-   **Aksi:** Bayar Hutang (Partial/Full)

#### C. Piutang (Accounts Receivable)

-   **View:** Daftar penjualan yang belum lunas
-   **Filter:** Customer, Status, Jatuh Tempo
-   **Aksi:** Terima Pembayaran (Partial/Full)

#### D. Cash Flow

-   **Tipe:**
    -   In: Penjualan, Terima Piutang
    -   Out: Pembelian, Bayar Hutang, Pengeluaran
-   **Kategori:** Operasional, Investasi, Lain-lain

#### E. Pengeluaran (Expenses)

-   **Fungsi:** Catat biaya di luar pembelian
-   **Field:** Tanggal, Kategori, Deskripsi, Jumlah
-   **Contoh:** Listrik, Gaji, Maintenance

### 4.4 Modul Laporan (Reports)

#### A. Stock Ledger (Jurnal Stok)

-   **Fungsi:** Histori mutasi stok super detail
-   **Field:** Tanggal, Item, Tipe Mutasi, Qty, Saldo Akhir, Referensi
-   **Filter:** Periode, Gudang, Kategori, Item
-   **Export:** PDF, Excel

#### B. Valuasi Stok

-   **Mode Valuasi:**
    -   Harga Beli (Modal)
    -   Harga Jual (Potensi Revenue)
    -   Rata-rata Pembelian (Average Cost)
-   **Analisis:**
    -   Total Nilai Aset
    -   Dead Stock (>90 hari tidak terjual)
    -   Grafik Komposisi Kategori
-   **Export:** PDF (Audit Report), Excel

#### C. Laporan Penjualan

-   **Metrics:**
    -   Total Penjualan per Periode
    -   Top 10 Produk Terlaris
    -   Top Customer by Revenue
-   **Charts:** Tren Penjualan Bulanan
-   **Export:** PDF, Excel

#### D. Laporan Pembelian

-   **Metrics:**
    -   Total Pembelian per Periode
    -   Top Supplier by Value
    -   Hutang Jatuh Tempo
-   **Export:** PDF, Excel

### 4.5 Modul Pengaturan (Settings)

#### A. Profil Perusahaan

-   **Field:** Nama, Alamat, Telepon, Email, Logo, Favicon
-   **Fungsi:** Data muncul di invoice & laporan

#### B. User Management

-   **Aksi:** Create, Edit, Delete, Reset Password
-   **Field:** Nama, Email, Password, Role, Status

#### C. Roles & Permissions (RBAC)

-   **Preset Roles:** Admin, Manager, Finance, Warehouse, Sales, PPIC
-   **Custom Permissions:** View, Create, Edit, Delete per modul
-   **UI:** Checkbox matrix untuk assign permission

---

## 🎯 BAGIAN V: KONSEP & LOGIKA BISNIS

### 5.1 Konsep Stok Multi-Gudang

-   Setiap produk bisa disimpan di multiple gudang
-   Stok dihitung per gudang (tidak global)
-   Transfer stok = kurangi di asal, tambah di tujuan
-   Penjualan/Material Request harus pilih gudang spesifik

### 5.2 Konsep Harga

-   **Purchase Price (Harga Beli):** Modal per unit
-   **Sale Price (Harga Jual):** Harga jual standar
-   **Average Cost:** (Total Nilai Beli) / (Total Qty Beli)
-   **Profit Margin:** (Sale Price - Purchase Price) / Purchase Price × 100%

### 5.3 Konsep Hutang & Piutang

-   **Hutang:** Kewajiban bayar ke supplier (dari Pembelian)
-   **Piutang:** Hak terima uang dari customer (dari Penjualan)
-   **Jatuh Tempo:** Tanggal deadline pembayaran
-   **Overdue:** Melewati jatuh tempo (warna merah)
-   **Partial Payment:** Cicilan/angsuran

### 5.4 Konsep Dead Stock

-   Barang yang tidak terjual dalam **90 hari** terakhir
-   Indikator: Tidak ada transaksi penjualan dalam periode tersebut
-   Aksi: Diskon, promosi, atau write-off

### 5.5 Konsep Stock Opname

-   **Tujuan:** Sinkronisasi stok fisik dengan sistem
-   **Frekuensi:** Bulanan/Quarterly
-   **Proses:**
    1. Hitung fisik
    2. Bandingkan dengan sistem
    3. Buat Adjustment jika selisih
    4. Admin approve

---

## 🔐 BAGIAN VI: KEAMANAN & BEST PRACTICES

### 6.1 Security Measures

-   **Password:** Min 8 karakter, kombinasi huruf/angka/simbol
-   **Session Timeout:** Auto logout setelah 2 jam idle
-   **CSRF Protection:** Laravel built-in untuk semua form
-   **SQL Injection Prevention:** Eloquent ORM with parameter binding
-   **XSS Prevention:** Blade escaping `{{ }}` untuk output

### 6.2 Access Control

-   **RBAC:** Role-Based Access Control via `hasPermission()` method
-   **Middleware:** `auth`, `permission:module.action`
-   **Audit Log:** Tracking who did what, when (untuk fitur kritis)

### 6.3 Data Integrity

-   **Foreign Key Constraints:** Mencegah delete data yang berelasi
-   **Soft Delete:** Data tidak benar-benar dihapus (untuk audit trail)
-   **Validation Rules:** Required fields, unique constraints, numeric range

### 6.4 Backup & Recovery

-   **Backup Database:** Weekly automatic backup
-   **Storage Location:** Cloud (Google Drive/Dropbox) + Local
-   **Retention:** 3 bulan terakhir
-   **Test Restore:** Monthly untuk ensure backup valid

### 6.5 Best Practices

-   **SKU Naming:** Konsisten, readable (BNG-CTN-001)
-   **Data Entry:** Double-check qty & price sebelum submit
-   **Stock Opname:** Lakukan berkala untuk akurasi
-   **Password:** Jangan share, ganti berkala
-   **Logout:** Selalu logout di shared PC

---

## 📖 BAGIAN VII: PANDUAN TEKNIS

### 7.1 Installation & Setup

```bash
# Clone repository
git clone [repo-url]

# Install dependencies
composer install
npm install

# Setup database
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Run development server
php artisan serve
```

### 7.2 Database Schema Key Tables

-   **users:** id, name, email, password, role_id
-   **roles:** id, name, permissions (JSON)
-   **items:** id, name, sku, category_id, unit_id, purchase_price, sale_price
-   **warehouses:** id, name, location
-   **warehouse_stocks:** id, item_id, warehouse_id, quantity
-   **pembelians:** id, supplier_id, date, total, payment_status
-   **sales:** id, customer_id, date, total, payment_status
-   **cash_flows:** id, type (in/out), amount, transaction_date, reference

### 7.3 Matriks Permission

```
[module].[action]
inventory.view
inventory.create
inventory.edit
inventory.delete
finance.view
finance.create
...
```

---

## 🚀 BAGIAN VIII: ROADMAP & FUTURE ENHANCEMENTS

### 8.1 Completed Features ✅

-   Multi-warehouse inventory
-   Purchase & Sales with Hutang/Piutang
-   Material Request (PPIC)
-   Financial Dashboard
-   Stock Valuation with Dead Stock detection
-   RBAC (Role-Based Access Control)
-   CSV Import/Export
-   Barcode Printing
-   Responsive UI
-   Help Center & Learning

### 8.2 Planned Features 🔜

-   [ ] Mobile App (Flutter/React Native)
-   [ ] WhatsApp Notifications (via API)
-   [ ] Auto Reorder Point (PO Suggestions)
-   [ ] Production Costing Analysis
-   [ ] Multi-Currency Support
-   [ ] E-Commerce Integration
-   [ ] API for 3rd Party Integration

---

## 📞 BAGIAN IX: SUPPORT & KONTAK

### 9.1 Internal Support

-   **Level 1 (Self-Help):** Help Center di sistem, FAQ
-   **Level 2 (IT Admin):** admin@ptNBC.co.id
-   **Level 3 (Developer):** support@vendor.com

### 9.2 Troubleshooting Guide

| Issue                   | Solution                               |
| ----------------------- | -------------------------------------- |
| Tidak bisa login        | Reset password via "Lupa Password"     |
| Stok tidak mencukupi    | Cek gudang, refresh halaman            |
| Dashboard grafik kosong | Pastikan ada data transaksi di periode |
| Invoice tidak ada logo  | Upload logo di Pengaturan → Profil     |

---

## 📝 BAGIAN X: GLOSSARY

-   **SKU:** Stock Keeping Unit (kode unik produk)
-   **HPP:** Harga Pokok Penjualan
-   **PPIC:** Production Planning & Inventory Control
-   **RBAC:** Role-Based Access Control
-   **Dead Stock:** Barang tidak terjual >90 hari
-   **Stock Opname:** Audit fisik stok
-   **Piutang:** Accounts Receivable (tagihan)
-   **Hutang:** Accounts Payable (kewajiban)
-   **Cash Flow:** Arus kas (in/out)
-   **Adjustment:** Koreksi stok

---

**Versi Dokumen:** 3.0  
**Terakhir Diperbarui:** 30 Desember 2025  
**Penyusun:** PT NBC Indonesia IT Department

---

_"Dokumentasi yang baik adalah investasi untuk efisiensi jangka panjang"_
