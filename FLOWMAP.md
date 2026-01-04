# FLOWMAP SISTEM YANG DIUSULKAN

## Sistem Inventori PT NBC Indonesia

Dokumen ini menjelaskan alur proses bisnis lengkap untuk sistem yang diusulkan dengan diagram flowmap menggunakan Mermaid.

---

## 📋 DAFTAR ISI

1. [Flowmap Procurement (Pengadaan Barang)](#1-flowmap-procurement)
2. [Flowmap Sales (Penjualan)](#2-flowmap-sales)
3. [Flowmap Production (Produksi PPIC)](#3-flowmap-production)
4. [Flowmap Inventory Management](#4-flowmap-inventory-management)
5. [Flowmap Finance Management](#5-flowmap-finance-management)
6. [Flowmap User Management](#6-flowmap-user-management)

---

## 1. FLOWMAP PROCUREMENT (Pengadaan Barang)

### 1.1 Proses Pembelian dari Supplier

```mermaid
flowchart TD
    Start([Mulai]) --> A[Finance: Login Sistem]
    A --> B[Buka Menu Pembelian]
    B --> C[Klik 'Pembelian Baru']
    C --> D[Pilih Supplier]
    D --> E[Input Tanggal & No. Invoice]
    E --> F[Tambah Item Produk]
    F --> G[Input Qty & Harga Beli]
    G --> H{Tambah<br/>Item Lain?}
    H -->|Ya| F
    H -->|Tidak| I[Sistem Hitung Total]
    I --> J[Input Jumlah Dibayar]
    J --> K{Dibayar<br/>Penuh?}
    K -->|Ya| L[Status: Lunas]
    K -->|Tidak| M[Input Jatuh Tempo]
    M --> N[Status: Hutang]
    L --> O[Klik 'Simpan']
    N --> O
    O --> P{Validasi<br/>Berhasil?}
    P -->|Tidak| Q[Tampilkan Error]
    Q --> J
    P -->|Ya| R[Sistem: Mulai Transaction]
    R --> S[Simpan Data Pembelian]
    S --> T[Update Stok Barang +]
    T --> U[Catat Stock Ledger]
    U --> V{Bayar<br/>Tunai?}
    V -->|Ya| W[Catat Cash Flow Out]
    V -->|Tidak| X[Catat Hutang]
    W --> Y[Commit Transaction]
    X --> Y
    Y --> Z[Tampilkan Pesan Sukses]
    Z --> End([Selesai])
```

### 1.2 Proses Pembayaran Hutang

```mermaid
flowchart TD
    Start([Mulai]) --> A[Finance: Buka Menu Hutang]
    A --> B[Sistem: Tampilkan Daftar Hutang]
    B --> C[Sort by Jatuh Tempo]
    C --> D[Highlight Overdue Merah]
    D --> E[Finance: Pilih Pembelian]
    E --> F[Klik 'Bayar Hutang']
    F --> G[Sistem: Tampilkan Detail]
    G --> H[Tampilkan Sisa Hutang]
    H --> I[Finance: Input Nominal]
    I --> J{Nominal <=<br/>Sisa Hutang?}
    J -->|Tidak| K[Error: Melebihi Sisa]
    K --> I
    J -->|Ya| L[Upload Bukti Transfer]
    L --> M[Klik 'Simpan']
    M --> N[Update Saldo Hutang]
    N --> O[Catat Cash Flow Out]
    O --> P{Sisa = 0?}
    P -->|Ya| Q[Update Status: Lunas]
    P -->|Tidak| R[Status: Partial]
    Q --> S[Tampilkan Sukses]
    R --> S
    S --> End([Selesai])
```

---

## 2. FLOWMAP SALES (Penjualan)

### 2.1 Proses Penjualan ke Customer

```mermaid
flowchart TD
    Start([Mulai]) --> A[Sales: Login Sistem]
    A --> B[Buka Menu Penjualan]
    B --> C[Klik 'Transaksi Baru']
    C --> D[Pilih Customer]
    D --> E{Customer<br/>Baru?}
    E -->|Ya| F[Input Data Customer]
    F --> G
    E -->|Tidak| G[Search/Scan Produk]
    G --> H[Klik Produk]
    H --> I[Produk Masuk Keranjang]
    I --> J[Atur Quantity]
    J --> K{Qty <= Stok?}
    K -->|Tidak| L[Error: Stok Kurang]
    L --> J
    K -->|Ya| M[Sistem Hitung Subtotal]
    M --> N{Tambah<br/>Produk?}
    N -->|Ya| G
    N -->|Tidak| O[Input Diskon]
    O --> P[Input Pajak]
    P --> Q[Sistem Hitung Grand Total]
    Q --> R[Input Jumlah Dibayar]
    R --> S{Bayar<br/>Penuh?}
    S -->|Ya| T[Sistem Hitung Kembalian]
    T --> U[Status: Lunas]
    S -->|Tidak| V[Input Jatuh Tempo]
    V --> W[Status: Piutang]
    U --> X[Klik 'Proses Penjualan']
    W --> X
    X --> Y{Validasi<br/>Stok?}
    Y -->|Gagal| Z[Error & Rollback]
    Z --> R
    Y -->|Berhasil| AA[Simpan Transaksi]
    AA --> AB[Update Stok Barang -]
    AB --> AC[Catat Stock Ledger]
    AC --> AD{Bayar<br/>Tunai?}
    AD -->|Ya| AE[Catat Cash Flow In]
    AD -->|Tidak| AF[Catat Piutang]
    AE --> AG[Generate Invoice PDF]
    AF --> AG
    AG --> AH[Tampilkan Modal Sukses]
    AH --> AI{Pilihan?}
    AI -->|Cetak| AJ[Print Invoice]
    AI -->|Transaksi Baru| B
    AI -->|Lihat Detail| AK[Buka Detail]
    AJ --> End([Selesai])
    AK --> End
```

### 2.2 Proses Retur Penjualan

```mermaid
flowchart TD
    Start([Customer Datang<br/>dengan Barang]) --> A[Sales: Cari Transaksi]
    A --> B[Input No. Invoice]
    B --> C[Sistem: Tampilkan Detail]
    C --> D[Sales: Klik 'Proses Retur']
    D --> E[Pilih Item yang Diretur]
    E --> F[Input Qty Retur]
    F --> G{Qty <=<br/>Qty Beli?}
    G -->|Tidak| H[Error: Melebihi Qty Beli]
    H --> F
    G -->|Ya| I[Sistem Hitung Nilai Retur]
    I --> J[Tampilkan Konfirmasi]
    J --> K[Sales: Klik 'Ya, Proses']
    K --> L[Simpan Data Retur]
    L --> M[Update Stok Barang +]
    M --> N[Catat Stock Ledger]
    N --> O{Transaksi<br/>Tunai?}
    O -->|Ya| P[Kas Berkurang - Refund]
    O -->|Tidak| Q[Piutang Berkurang]
    P --> R[Tampilkan Sukses]
    Q --> R
    R --> End([Selesai])
```

---

## 3. FLOWMAP PRODUCTION (PPIC)

### 3.1 Alur Material Request (End-to-End)

```mermaid
flowchart TD
    Start([Mulai]) --> A[PPIC: Login Sistem]
    A --> B[Buka Menu Material Request]
    B --> C[Klik 'Request Baru']
    C --> D[Pilih Produk Jadi]
    D --> E[Input Target Qty]
    E --> F[Tambah Bahan Baku]
    F --> G[Pilih Item & Warehouse]
    G --> H[Input Qty Bahan]
    H --> I{Tambah<br/>Bahan Lain?}
    I -->|Ya| F
    I -->|Tidak| J[Klik 'Submit Request']
    J --> K[Status: Pending]
    K --> L[Notifikasi ke Warehouse]

    L --> M[Warehouse: Buka Notifikasi]
    M --> N[Cek Ketersediaan Stok]
    N --> O{Stok<br/>Cukup?}
    O -->|Tidak| P[Klik 'Tolak']
    P --> Q[Input Alasan]
    Q --> R[Status: Rejected]
    R --> S[Notifikasi ke PPIC]
    S --> End1([Selesai - Ditolak])

    O -->|Ya| T[Siapkan Barang Fisik]
    T --> U[Klik 'Siapkan']
    U --> V[Status: Ready]
    V --> W[Notifikasi ke PPIC]

    W --> X[Produksi: Ambil Barang]
    X --> Y[PPIC: Klik 'Mulai Produksi']
    Y --> Z[Sistem: Update Status]
    Z --> AA[Status: In Production]
    AA --> AB[Update Stok Bahan -]
    AB --> AC[Catat Stock Ledger]

    AC --> AD[Proses Fisik Produksi...]
    AD --> AE[PPIC: Klik 'Selesaikan']
    AE --> AF[Input Qty Hasil Aktual]
    AF --> AG[Update Stok Jadi +]
    AG --> AH[Catat Stock Ledger]
    AH --> AI[Status: Finished]
    AI --> AJ[Hitung Efisiensi]
    AJ --> End2([Selesai - Sukses])
```

---

## 4. FLOWMAP INVENTORY MANAGEMENT

### 4.1 Transfer Stok Antar Gudang

```mermaid
flowchart TD
    Start([Mulai]) --> A[Warehouse: Login]
    A --> B[Buka Menu Transfer]
    B --> C[Klik 'Transfer Baru']
    C --> D[Pilih Gudang Asal]
    D --> E[Pilih Gudang Tujuan]
    E --> F[Tambah Item]
    F --> G[Sistem: Tampilkan Stok Asal]
    G --> H[Input Qty Transfer]
    H --> I{Qty <=<br/>Stok Asal?}
    I -->|Tidak| J[Error: Stok Tidak Cukup]
    J --> H
    I -->|Ya| K{Tambah<br/>Item Lain?}
    K -->|Ya| F
    K -->|Tidak| L[Klik 'Simpan']
    L --> M[Validasi Semua Item]
    M --> N[Mulai Transaction]
    N --> O[Simpan Data Transfer]
    O --> P[Update Stok Asal -]
    P --> Q[Update Stok Tujuan +]
    Q --> R[Catat Stock Ledger Asal]
    R --> S[Catat Stock Ledger Tujuan]
    S --> T[Commit Transaction]
    T --> U[Tampilkan Sukses]
    U --> End([Selesai])
```

### 4.2 Stock Adjustment (Koreksi Stok)

```mermaid
flowchart TD
    Start([Stock Opname<br/>Fisik]) --> A[Warehouse: Hitung Stok]
    A --> B[Bandingkan vs Sistem]
    B --> C{Ada<br/>Selisih?}
    C -->|Tidak| End1([Selesai - Sesuai])
    C -->|Ya| D[Buka Menu Adjustment]
    D --> E[Klik 'Adjustment Baru']
    E --> F[Pilih Gudang]
    F --> G[Pilih Produk]
    G --> H[Sistem: Tampilkan Stok Sistem]
    H --> I[Input Stok Fisik]
    I --> J[Sistem: Hitung Selisih]
    J --> K[Input Alasan Detail]
    K --> L[Klik 'Submit']
    L --> M[Status: Pending Approval]
    M --> N[Notifikasi ke Admin]

    N --> O[Admin: Buka Notifikasi]
    O --> P[Review Adjustment]
    P --> Q[Cek Alasan & Selisih]
    Q --> R{Approve?}
    R -->|Tidak| S[Klik 'Reject']
    S --> T[Input Alasan Penolakan]
    T --> U[Status: Rejected]
    U --> V[Notif ke Warehouse]
    V --> End2([Selesai - Ditolak])

    R -->|Ya| W[Klik 'Approve']
    W --> X[Update Stok = Fisik]
    X --> Y[Catat Stock Ledger]
    Y --> Z[Status: Approved]
    Z --> AA[Notif ke Warehouse]
    AA --> End3([Selesai - Approved])
```

---

## 5. FLOWMAP FINANCE MANAGEMENT

### 5.1 Monitoring Dashboard Keuangan

```mermaid
flowchart TD
    Start([Mulai]) --> A[Finance: Login]
    A --> B[Buka Dashboard Keuangan]
    B --> C[Sistem: Load Data Default]
    C --> D[Tampilkan KPI Cards]
    D --> E[Render Chart Arus Kas]
    E --> F[Render Chart Pengeluaran]
    F --> G[Tampilkan Tabel Piutang]
    G --> H[Tampilkan Tabel Hutang]
    H --> I{Ubah<br/>Filter?}
    I -->|Ya| J[Pilih Tanggal Start-End]
    J --> K[Klik 'Filter']
    K --> L[Sistem: Reload Data]
    L --> D
    I -->|Tidak| M{Aksi?}
    M -->|Bayar Hutang| N[Klik Link Hutang]
    N --> O[Proses Bayar Hutang]
    M -->|Terima Piutang| P[Klik Link Piutang]
    P --> Q[Proses Terima Piutang]
    M -->|Selesai| End([Selesai])
    O --> End
    Q --> End
```

### 5.2 Rekonsiliasi Cash Flow Bulanan

```mermaid
flowchart TD
    Start([Akhir Bulan]) --> A[Finance: Export Cash Flow]
    A --> B[Download Excel]
    B --> C[Buka Rekening Koran Bank]
    C --> D[Bandingkan Transaksi]
    D --> E{Data<br/>Match?}
    E -->|Ya| F[Saldo Cocok]
    F --> G[Archive Laporan]
    G --> End([Selesai])

    E -->|Tidak| H[Identifikasi Selisih]
    H --> I{Transaksi<br/>Terlewat?}
    I -->|Ya| J[Buka Menu Cash Flow]
    J --> K[Klik 'Tambah Manual']
    K --> L[Input Transaksi]
    L --> M[Simpan]
    M --> D

    I -->|Tidak| N{Error<br/>Input?}
    N -->|Ya| O[Koreksi Transaksi]
    O --> D
    N -->|Tidak| P[Eskalasi ke Manager]
    P --> End
```

---

## 6. FLOWMAP USER MANAGEMENT

### 6.1 Tambah User Baru & Assign Role

```mermaid
flowchart TD
    Start([Mulai]) --> A[Admin: Login]
    A --> B[Buka Menu User Management]
    B --> C[Klik 'Tambah User']
    C --> D[Input Nama Lengkap]
    D --> E[Input Email]
    E --> F[Input Password]
    F --> G[Pilih Role dari Dropdown]
    G --> H[Upload Foto Opsional]
    H --> I[Set Status Aktif]
    I --> J[Klik 'Simpan']
    J --> K{Validasi?}
    K -->|Email Duplikat| L[Error: Email Sudah Ada]
    L --> E
    K -->|Password Lemah| M[Error: Min 8 Karakter]
    M --> F
    K -->|Berhasil| N[Simpan User Baru]
    N --> O[Assign Role & Permissions]
    O --> P[Kirim Email Welcome]
    P --> Q[Tampilkan Sukses]
    Q --> End([Selesai])
```

### 6.2 Reset Password User

```mermaid
flowchart TD
    Start([User Lupa<br/>Password]) --> A[User: Klik 'Lupa Password']
    A --> B[Sistem: Form Input Email]
    B --> C[User: Input Email]
    C --> D[Klik 'Kirim Link']
    D --> E{Email<br/>Terdaftar?}
    E -->|Tidak| F[Error: Email Tidak Ada]
    F --> C
    E -->|Ya| G[Generate Token Reset]
    G --> H[Simpan Token ke DB]
    H --> I[Kirim Email + Link]
    I --> J[User: Buka Email]
    J --> K[Klik Link Reset]
    K --> L[Sistem: Validasi Token]
    L --> M{Token<br/>Valid?}
    M -->|Tidak/Expired| N[Error: Link Expired]
    N --> End1([Gagal])
    M -->|Ya| O[Form Password Baru]
    O --> P[Input Password Baru 2x]
    P --> Q{Password<br/>Match?}
    Q -->|Tidak| R[Error: Tidak Cocok]
    R --> P
    Q -->|Ya| S[Hash Password]
    S --> T[Update di Database]
    T --> U[Hapus Token]
    U --> V[Tampilkan Sukses]
    V --> W[Redirect ke Login]
    W --> End2([Selesai])
```

---

## 7. FLOWMAP LAPORAN

### 7.1 Generate Laporan Valuasi Stok

```mermaid
flowchart TD
    Start([Mulai]) --> A[User: Buka Laporan Valuasi]
    A --> B[Sistem: Load Filter Default]
    B --> C[Tampilkan Mode: Beli]
    C --> D[Tampilkan Gudang: Semua]
    D --> E[Hitung Valuasi Awal]
    E --> F[Render KPI Cards]
    F --> G[Render Chart Kategori]
    G --> H[Render Chart Kesehatan]
    H --> I[Tampilkan Tabel Detail]
    I --> J{Ubah<br/>Filter?}
    J -->|Ya| K[Pilih Mode Valuasi]
    K --> L[Pilih Gudang]
    L --> M[Pilih Kategori]
    M --> N[Klik 'Filter']
    N --> O[Re-calculate]
    O --> F
    J -->|Tidak| P{Export?}
    P -->|PDF| Q[Generate PDF Audit]
    P -->|Excel| R[Generate Excel Detail]
    P -->|Tidak| End([Selesai])
    Q --> S[Download File]
    R --> S
    S --> End
```

### 7.2 View Stock Ledger (Jurnal Stok)

```mermaid
flowchart TD
    Start([Mulai]) --> A[User: Buka Jurnal Stok]
    A --> B[Sistem: Filter Default Bulan Ini]
    B --> C[Load Data Mutasi]
    C --> D[Tampilkan Tabel]
    D --> E{Filter<br/>Spesifik?}
    E -->|Ya| F[Pilih Item]
    F --> G[Pilih Gudang]
    G --> H[Pilih Periode]
    H --> I[Klik 'Filter']
    I --> C
    E -->|Tidak| J{Lihat<br/>Detail?}
    J -->|Ya| K[Klik Link Referensi]
    K --> L[Buka Transaksi Sumber]
    L --> M[Tampilkan Detail di Tab Baru]
    J -->|Tidak| N{Export?}
    N -->|Ya| O[Generate PDF Summary]
    O --> P[Download]
    N -->|Tidak| End([Selesai])
    P --> End
    M --> End
```

---

## 8. LEGEND & NOTASI

### Simbol Flowchart

| Simbol    | Keterangan           |
| --------- | -------------------- |
| `([...])` | Terminal (Start/End) |
| `[...]`   | Proses/Aksi          |
| `{...}`   | Keputusan (Decision) |
| `[(...)`  | Database Operation   |
| `-->`     | Alur Normal          |
| `-.->`    | Alur Alternatif      |

### Aktor dalam Flowmap

-   **Admin:** Pengguna dengan akses penuh
-   **Finance:** Departemen keuangan
-   **Warehouse:** Staff gudang
-   **Sales:** Kasir/penjual
-   **PPIC:** Production planning
-   **Sistem:** Aksi otomatis oleh aplikasi

---

## 9. PERBANDINGAN SISTEM LAMA vs BARU

### 9.1 Proses Pembelian

| Aspek        | Sistem Lama     | Sistem Baru (Usulan)          |
| ------------ | --------------- | ----------------------------- |
| Input Data   | Manual di Excel | Form digital di sistem        |
| Update Stok  | Manual hitung   | Otomatis real-time            |
| Hutang       | Catat terpisah  | Terintegrasi & auto-calculate |
| Laporan      | Export manual   | Generate otomatis             |
| Waktu Proses | 15-30 menit     | 3-5 menit                     |

### 9.2 Proses Stock Opname

| Aspek         | Sistem Lama        | Sistem Baru (Usulan)            |
| ------------- | ------------------ | ------------------------------- |
| Cetak Laporan | Excel manual       | 1 klik PDF                      |
| Adjustment    | Input ulang manual | Form digital dengan approval    |
| Audit Trail   | Tidak ada          | Lengkap dengan timestamp & user |
| Waktu Opname  | 1 hari             | 4-6 jam                         |

---

## 10. INTEGRASI ANTAR MODUL

```mermaid
graph LR
    A[Pembelian] -->|Update Stok| B[Inventory]
    C[Penjualan] -->|Kurangi Stok| B
    D[Material Request] -->|Dari Bahan| B
    D -->|Ke Jadi| B
    A -->|Hutang| E[Finance]
    C -->|Piutang| E
    E -->|Cash Flow| F[Dashboard]
    B -->|Valuasi| F
    C -->|Sales Report| F
    A -->|Purchase Report| F
```

---

## 11. KEUNGGULAN SISTEM USULAN

### Otomatisasi

-   ✅ Stok update otomatis setiap transaksi
-   ✅ Hutang/Piutang tercatat otomatis
-   ✅ Cash Flow terupdate real-time
-   ✅ Invoice auto-generate

### Akurasi

-   ✅ Minim human error
-   ✅ Validasi di setiap input
-   ✅ Foreign key constraint
-   ✅ Transaction rollback on error

### Kecepatan

-   ✅ Proses 5x lebih cepat
-   ✅ Laporan instan
-   ✅ Search & filter cepat
-   ✅ Responsive UI

### Kontrol

-   ✅ RBAC (hak akses per role)
-   ✅ Approval workflow
-   ✅ Audit trail lengkap
-   ✅ Multi-user concurrent access

---

**Versi Dokumen:** 1.0  
**Terakhir Diperbarui:** 30 Desember 2025  
**Penyusun:** PT NBC Indonesia IT Department

---

_"Flowmap yang jelas adalah kunci implementasi yang sukses"_
