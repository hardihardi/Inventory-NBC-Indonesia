# USE CASE DOCUMENTATION

## Sistem Inventori PT NBC Indonesia

Dokumen ini berisi deskripsi lengkap use case untuk semua aktor dan interaksi mereka dengan sistem inventori.

---

## 📋 DAFTAR AKTOR

### Primary Actors (Pengguna Utama)

1. **Administrator** - Mengelola sistem dan konfigurasi
2. **Manager** - Memantau performa bisnis
3. **Finance** - Mengelola transaksi keuangan
4. **Warehouse Staff** - Mengelola stok dan gudang
5. **Sales** - Melakukan penjualan
6. **PPIC** - Mengelola produksi

### Secondary Actors (Sistem Eksternal)

7. **Email System** - Mengirim notifikasi email
8. **Printer** - Mencetak dokumen

---

## 🎯 USE CASE DIAGRAM (Overview)

```
┌─────────────────────────────────────────────────────────┐
│                  INVENTORY SYSTEM                       │
│                                                         │
│  ┌──────────────┐                                      │
│  │   Admin      │──── Manage Users                     │
│  │              │──── Manage Roles & Permissions       │
│  └──────────────┘                                      │
│                                                         │
│  ┌──────────────┐                                      │
│  │   Manager    │──── View Dashboard                   │
│  │              │──── View Reports                     │
│  └──────────────┘                                      │
│                                                         │
│  ┌──────────────┐                                      │
│  │   Finance    │──── Create Purchase                  │
│  │              │──── Manage Hutang                    │
│  │              │──── Manage Piutang                   │
│  │              │──── View Financial Dashboard         │
│  └──────────────┘                                      │
│                                                         │
│  ┌──────────────┐                                      │
│  │  Warehouse   │──── Manage Products                  │
│  │              │──── Transfer Stock                   │
│  │              │──── Stock Adjustment                 │
│  │              │──── Fulfill Material Request         │
│  └──────────────┘                                      │
│                                                         │
│  ┌──────────────┐                                      │
│  │    Sales     │──── Create Sales Transaction         │
│  │              │──── Process Return                   │
│  │              │──── Print Invoice                    │
│  └──────────────┘                                      │
│                                                         │
│  ┌──────────────┐                                      │
│  │    PPIC      │──── Create Material Request          │
│  │              │──── Start Production                 │
│  │              │──── Finish Production                │
│  └──────────────┘                                      │
└─────────────────────────────────────────────────────────┘
```

---

## 📖 USE CASE DETAIL

### UC-001: Login ke Sistem

**Aktor:** Semua pengguna  
**Deskripsi:** Pengguna masuk ke sistem menggunakan email dan password  
**Precondition:** Pengguna memiliki akun aktif  
**Postcondition:** Pengguna berhasil login dan diarahkan ke dashboard

**Main Success Scenario:**

1. Pengguna membuka halaman login
2. Sistem menampilkan form login
3. Pengguna memasukkan email dan password
4. Pengguna klik tombol "Login"
5. Sistem memvalidasi kredensial
6. Sistem membuat session
7. Sistem mengarahkan ke dashboard sesuai role

**Alternative Flows:**

-   5a. Kredensial tidak valid
    -   5a1. Sistem menampilkan pesan error
    -   5a2. Kembali ke step 3
-   3a. Pengguna lupa password
    -   3a1. Pengguna klik "Lupa Password"
    -   3a2. Sistem arahkan ke halaman reset password
    -   3a3. Use case UC-002 dimulai

---

### UC-002: Reset Password

**Aktor:** Semua pengguna  
**Deskripsi:** Pengguna yang lupa password dapat mereset password  
**Precondition:** Email pengguna terdaftar di sistem

**Main Success Scenario:**

1. Pengguna klik "Lupa Password" di halaman login
2. Sistem tampilkan form input email
3. Pengguna masukkan email
4. Pengguna klik "Kirim Link Reset"
5. Sistem validasi email terdaftar
6. Sistem generate token reset
7. Sistem kirim email berisi link reset
8. Pengguna buka email dan klik link
9. Sistem tampilkan form password baru
10. Pengguna masukkan password baru (2x)
11. Sistem validasi password match
12. Sistem update password
13. Sistem tampilkan pesan sukses
14. Pengguna diarahkan ke halaman login

**Alternative Flows:**

-   5a. Email tidak terdaftar
    -   5a1. Sistem tampilkan pesan error
    -   5a2. Kembali ke step 3

---

### UC-003: Manage Master Data Produk

**Aktor:** Admin, Warehouse  
**Deskripsi:** Mengelola data produk (Create, Read, Update, Delete)  
**Precondition:** User memiliki permission `inventory.create/edit/delete`

#### UC-003a: Create Product

**Main Success Scenario:**

1. User buka menu Master Data → Produk
2. User klik "+ Tambah Produk Baru"
3. Sistem tampilkan form create
4. User pilih Kategori
5. Sistem tampilkan field sesuai kategori
6. User input:
    - Nama Produk
    - SKU (auto-generate atau manual)
    - Harga Beli
    - Harga Jual
    - Satuan
    - Stok Minimum
    - Gudang Default
    - Foto (opsional)
7. User klik "Simpan"
8. Sistem validasi:
    - Nama tidak kosong
    - SKU unique
    - Harga > 0
9. Sistem simpan data
10. Sistem tampilkan pesan sukses
11. Sistem redirect ke halaman list produk

**Alternative Flows:**

-   8a. Validasi gagal
    -   8a1. Sistem tampilkan pesan error spesifik
    -   8a2. Kembali ke step 6

#### UC-003b: Edit Product

**Main Success Scenario:**

1. User buka list produk
2. User klik ikon "Edit" pada produk
3. Sistem tampilkan form edit dengan data terisi
4. User ubah data yang diperlukan
5. User klik "Update"
6. Sistem validasi
7. Sistem update data
8. Sistem tampilkan pesan sukses

#### UC-003c: Delete Product

**Precondition:** Produk belum pernah digunakan dalam transaksi

**Main Success Scenario:**

1. User klik ikon "Delete" pada produk
2. Sistem tampilkan konfirmasi SweetAlert
3. User klik "Ya, Hapus"
4. Sistem cek apakah ada transaksi terkait
5. Sistem soft delete produk
6. Sistem tampilkan pesan sukses
7. Produk hilang dari list (tapi masih ada di database)

**Alternative Flows:**

-   4a. Produk sudah pernah digunakan
    -   4a1. Sistem tampilkan pesan "Tidak bisa hapus, sudah ada transaksi"
    -   4a2. Use case selesai

---

### UC-004: Cetak Barcode

**Aktor:** Warehouse  
**Deskripsi:** Mencetak label barcode untuk produk  
**Precondition:** Ada minimal 1 produk

**Main Success Scenario:**

1. User buka list produk
2. User centang checkbox produk yang ingin dicetak
3. User klik tombol "Cetak Label Terpilih"
4. Sistem generate PDF barcode (per item 1 sticker)
5. Sistem buka PDF di tab baru
6. User print PDF menggunakan printer sticker
7. User tempel sticker di produk fisik

---

### UC-005: Import/Export CSV Produk

**Aktor:** Admin, Warehouse

#### UC-005a: Export CSV

**Main Success Scenario:**

1. User buka list produk
2. User klik "Export CSV"
3. Sistem generate CSV dari semua produk
4. Browser download file "products_YYYYMMDD.csv"
5. User buka file di Excel untuk backup/analisis

#### UC-005b: Import CSV

**Main Success Scenario:**

1. User klik "Import CSV"
2. Sistem tampilkan modal upload
3. User klik "Download Template" (opsional)
4. User isi data di template
5. User pilih file CSV
6. User klik "Upload"
7. Sistem validasi format dan data
8. Sistem tampilkan preview hasil import
9. User klik "Konfirmasi Import"
10. Sistem proses import (bulk insert)
11. Sistem tampilkan ringkasan:
    - Total baris: 100
    - Berhasil: 95
    - Gagal: 5 (dengan alasan error)
12. Sistem simpan log import

**Alternative Flows:**

-   7a. Format CSV salah
    -   7a1. Sistem tampilkan error spesifik
    -   7a2. Kembali ke step 5

---

### UC-006: Create Purchase (Pembelian)

**Aktor:** Finance  
**Deskripsi:** Membuat transaksi pembelian dari supplier  
**Precondition:** Ada minimal 1 supplier dan 1 produk

**Main Success Scenario:**

1. Finance buka menu Pembelian
2. Finance klik "+ Pembelian Baru"
3. Sistem tampilkan form pembelian
4. Finance pilih Supplier (Select2 dropdown)
5. Finance input Tanggal Pembelian
6. Finance input No. Invoice Supplier (opsional)
7. Finance tambah item:
    - Pilih Produk (Select2 dengan search)
    - Input Qty
    - Input Harga Beli per Unit
    - Sistem hitung Subtotal = Qty × Harga
8. Finance klik "+ Tambah Item" untuk item berikutnya
9. Ulangi step 7-8 untuk semua item
10. Sistem hitung Total otomatis
11. Finance input "Jumlah Dibayar"
12. Sistem tentukan status:
    - Jika Dibayar = Total → Status "Lunas"
    - Jika Dibayar < Total → Status "Hutang", tampilkan field "Jatuh Tempo"
13. Jika hutang: Finance input Jatuh Tempo
14. Finance klik "Simpan Pembelian"
15. Sistem validasi semua field
16. Sistem mulai database transaction
17. Sistem simpan data pembelian
18. Untuk setiap item:
    - Sistem update stok: `stock += qty`
    - Sistem catat di Stock Ledger (tipe: "Pembelian")
19. Jika bayar: Sistem catat Cash Flow (type: "out")
20. Jika hutang: Sistem catat di tabel hutang
21. Sistem commit transaction
22. Sistem tampilkan pesan sukses
23. Sistem redirect ke detail pembelian

**Alternative Flows:**

-   15a. Validasi gagal
    -   15a1. Sistem rollback transaction
    -   15a2. Tampilkan error
    -   15a3. Kembali ke form
-   16-21a. Error saat save (DB down, dll)
    -   Sistem rollback transaction
    -   Tampilkan error message
    -   Data tidak tersimpan

**Postcondition:**

-   Stok produk bertambah
-   Saldo kas berkurang (jika bayar)
-   Hutang bertambah (jika kredit)
-   Cash Flow tercatat

---

### UC-007: Bayar Hutang Supplier

**Aktor:** Finance  
**Precondition:** Ada pembelian dengan status "Hutang"

**Main Success Scenario:**

1. Finance buka menu Keuangan → Hutang
2. Sistem tampilkan list pembelian belum lunas, sort by jatuh tempo
3. Sistem highlight merah untuk yang overdue
4. Finance klik ikon "Detail" pada pembelian
5. Sistem tampilkan detail pembelian & riwayat pembayaran
6. Finance klik "Bayar Hutang"
7. Sistem tampilkan modal input pembayaran
8. Sistem tampilkan:
    - Total Hutang: Rp 10.000.000
    - Sudah Dibayar: Rp 3.000.000
    - Sisa Hutang: Rp 7.000.000
9. Finance input "Nominal Pembayaran" (misal: Rp 5.000.000)
10. Finance upload bukti transfer (opsional)
11. Finance klik "Simpan"
12. Sistem validasi nominal <= sisa hutang
13. Sistem update:
    - Total dibayar += 5.000.000
    - Sisa hutang = 2.000.000
14. Sistem catat Cash Flow (type: "out", category: "Bayar Hutang")
15. Sistem cek: jika sisa = 0 → update status pembelian = "Lunas"
16. Sistem tampilkan pesan sukses
17. Modal tertutup, page refresh

**Alternative Flows:**

-   12a. Nominal > sisa hutang
    -   12a1. Tampilkan error "Nominal melebihi sisa hutang"
    -   12a2. Kembali ke step 9

**Postcondition:**

-   Saldo hutang berkurang
-   Saldo kas berkurang
-   Status pembelian bisa berubah jadi "Lunas"

---

### UC-008: Create Sales Transaction (Penjualan)

**Aktor:** Sales  
**Precondition:** Ada minimal 1 customer dan produk dengan stok > 0

**Main Success Scenario:**

1. Sales buka menu Penjualan → Transaksi
2. Sales klik "+ Transaksi Baru"
3. Sistem tampilkan form penjualan (layout seperti POS)
4. Sales pilih Customer (atau "Walk-in Customer")
5. Sales cari produk:
    - Ketik nama produk di search box
    - ATAU scan barcode
6. Sistem tampilkan produk matching
7. Sales klik produk
8. Sistem tambahkan ke keranjang dengan:
    - Nama Produk
    - Harga Jual (auto-fill)
    - Qty: 1 (default)
    - Subtotal: Harga × Qty
9. Sales ubah Qty jika perlu
10. Sistem validasi Qty <= Stok Tersedia
11. Ulangi step 5-10 untuk produk lain
12. Sistem hitung Total Keranjang otomatis
13. Sales input Diskon:
    - Pilih tipe: Persen atau Nominal
    - Input nilai
14. Sistem hitung Grand Total:
    - Grand Total = Total - Diskon + Pajak
15. Sales input "Jumlah Dibayar"
16. Sistem tentukan:
    - Jika Dibayar >= Grand Total:
        - Kembalian = Dibayar - Grand Total
        - Status: "Lunas"
    - Jika Dibayar < Grand Total:
        - Tampilkan field "Jatuh Tempo"
        - Piutang = Grand Total - Dibayar
        - Status: "Piutang"
17. Jika piutang: Sales input Jatuh Tempo
18. Sales klik "Proses Penjualan"
19. Sistem validasi stok semua item
20. Sistem mulai transaction
21. Sistem simpan data penjualan
22. Untuk setiap item:
    - Update stok: `stock -= qty`
    - Catat Stock Ledger (tipe: "Penjualan")
23. Jika bayar: Catat Cash Flow (type: "in")
24. Jika piutang: Catat di tabel piutang
25. Sistem commit transaction
26. Sistem generate PDF invoice
27. Sistem tampilkan modal sukses dengan opsi:
    - "Cetak Invoice"
    - "Transaksi Baru"
    - "Lihat Detail"

**Alternative Flows:**

-   10a. Qty > Stok
    -   10a1. Sistem disable tombol "Tambah"
    -   10a2. Tampilkan pesan "Stok tidak cukup"
-   19a. Stok berubah saat proses (race condition)
    -   19a1. Rollback transaction
    -   19a2. Tampilkan error
    -   19a3. Refresh halaman

**Postcondition:**

-   Stok produk berkurang
-   Saldo kas bertambah (jika bayar)
-   Piutang bertambah (jika kredit)

---

### UC-009: Cetak Invoice Penjualan

**Aktor:** Sales  
**Precondition:** Transaksi penjualan sudah ada

**Main Success Scenario:**

1. Sales buka detail penjualan
2. Sales klik tombol "Cetak Invoice"
3. Sistem generate PDF invoice dengan:
    - Logo perusahaan
    - Nama & alamat perusahaan
    - Nomor invoice (auto-generate)
    - Tanggal transaksi
    - Data customer
    - Tabel item (Nama, Qty, Harga, Subtotal)
    - Total, Diskon, Pajak, Grand Total
    - Cara pembayaran (Tunai/Kredit)
4. Sistem buka PDF di tab baru
5. Sales print invoice
6. Sales berikan invoice ke customer

---

### UC-010: Proses Retur Penjualan

**Aktor:** Sales  
**Precondition:** Ada transaksi penjualan yang akan diretur

**Main Success Scenario:**

1. Customer datang dengan barang rusak/salah + invoice
2. Sales buka menu Penjualan → Daftar Transaksi
3. Sales cari transaksi berdasarkan No. Invoice atau nama customer
4. Sales klik "Detail" pada transaksi
5. Sales klik tombol "Proses Retur"
6. Sistem tampilkan modal daftar item yang dibeli
7. Sales pilih item yang diretur
8. Sales input qty retur (max = qty beli)
9. Sales klik "Proses Retur"
10. Sistem hitung nilai retur = qty × harga
11. Sistem tampilkan konfirmasi
12. Sales klik "Ya, Proses"
13. Sistem mulai transaction
14. Sistem simpan data retur
15. Sistem update stok: `stock += qty_retur`
16. Sistem catat Stock Ledger (tipe: "Retur Penjualan")
17. Sistem kurangi:
    - Jika transaksi tunai: Kas berkurang (refund)
    - Jika transaksi kredit: Piutang berkurang
18. Sistem commit transaction
19. Sistem tampilkan pesan sukses

---

### UC-011: Transfer Stok Antar Gudang

**Aktor:** Warehouse  
**Precondition:** Ada minimal 2 gudang dan stok > 0 di gudang asal

**Main Success Scenario:**

1. Warehouse buka menu Gudang & Stok → Transfer
2. Warehouse klik "+ Transfer Baru"
3. Sistem tampilkan form transfer
4. Warehouse pilih Gudang Asal (dropdown)
5. Warehouse pilih Gudang Tujuan (dropdown, exclude gudang asal)
6. Warehouse tambah item:
    - Pilih Produk
    - Sistem tampilkan stok di gudang asal
    - Input Qty transfer
    - Sistem validasi Qty <= Stok Asal
7. Warehouse klik "+ Tambah Item" untuk item lain
8. Warehouse klik "Simpan Transfer"
9. Sistem validasi semua field
10. Sistem mulai transaction
11. Sistem simpan data transfer
12. Untuk setiap item:
    - Update stok gudang asal: `stock -= qty`
    - Update stok gudang tujuan: `stock += qty`
    - Catat Stock Ledger untuk kedua gudang
13. Sistem commit transaction
14. Sistem tampilkan pesan sukses

**Alternative Flows:**

-   6a. Qty > Stok Asal
    -   6a1. Tampilkan error
    -   6a2. Kembali ke input

---

### UC-012: Stock Adjustment

**Aktor:** Warehouse (create), Admin (approve)  
**Deskripsi:** Koreksi stok saat ada selisih fisik vs sistem  
**Precondition:** Ada hasil stock opname

**Main Success Scenario (Warehouse):**

1. Warehouse lakukan stock opname fisik
2. Warehouse bandingkan dengan laporan sistem
3. Warehouse temukan selisih
4. Warehouse buka menu Stock Adjustment
5. Warehouse klik "+ Adjustment Baru"
6. Sistem tampilkan form
7. Warehouse pilih Gudang
8. Warehouse pilih Produk
9. Sistem tampilkan:
    - Stok Sistem: 100 Kg
    - Stok Fisik (input): **\_**
10. Warehouse input Stok Fisik: 98 Kg
11. Sistem hitung Selisih: -2 Kg
12. Warehouse input Alasan: "Barang rusak di gudang"
13. Warehouse klik "Submit"
14. Sistem simpan dengan status "Pending Approval"
15. Sistem kirim notifikasi ke Admin

**Main Success Scenario (Admin - Approve):** 16. Admin menerima notifikasi 17. Admin buka menu Stock Adjustment 18. Admin lihat list adjustment pending 19. Admin klik "Detail" pada adjustment 20. Admin review: - Produk yang disesuaikan - Selisih - Alasan - User yang buat 21. Admin klik "Approve" 22. Sistem update stok: `stock = 98` 23. Sistem catat Stock Ledger (tipe: "Adjustment") 24. Sistem update status adjustment = "Approved" 25. Sistem kirim notifikasi ke Warehouse

**Alternative Flows:**

-   21a. Admin tolak adjustment
    -   21a1. Admin klik "Reject"
    -   21a2. Admin input alasan penolakan
    -   21a3. Sistem update status = "Rejected"
    -   21a4. Stok tidak berubah
    -   21a5. Notifikasi ke Warehouse

---

### UC-013: Create Material Request (PPIC)

**Aktor:** PPIC (create), Warehouse (fulfill)  
**Precondition:** Ada produk jadi dan bahan baku

**Main Success Scenario (PPIC):**

1. PPIC buka menu PPIC → Material Request
2. PPIC klik "+ Request Baru"
3. Sistem tampilkan form
4. PPIC pilih Produk Output (barang jadi yang akan diproduksi)
5. PPIC input Target Qty (misal: 100 pcs Kain)
6. PPIC tambah bahan baku:
    - Pilih Benang Cotton
    - Input Qty: 50 Kg
7. PPIC klik "+ Tambah Bahan"
8. PPIC pilih Zat Pewarna, Qty: 5 Liter
9. PPIC klik "Submit Request"
10. Sistem simpan dengan status "Pending"
11. Sistem kirim notifikasi ke Warehouse

**Main Success Scenario (Warehouse - Fulfill):** 12. Warehouse terima notifikasi 13. Warehouse buka detail request 14. Warehouse cek stok fisik di gudang 15. Warehouse verifikasi ketersediaan 16. Jika semua tersedia: - Warehouse klik "Siapkan" - Sistem update status = "Ready" - Notifikasi ke PPIC: "Barang siap diambil" 17. Jika tidak tersedia: - Warehouse klik "Tolak" - Input alasan: "Stok Benang tidak cukup" - Status = "Rejected"

**Main Success Scenario (PPIC - Start Production):** 18. PPIC terima notifikasi "Ready" 19. Produksi ambil barang dari gudang 20. PPIC buka detail request 21. PPIC klik "Mulai Produksi" 22. Sistem mulai transaction 23. Sistem update status = "In Production" 24. Untuk setiap bahan baku: - Update stok: `stock -= qty` - Catat Stock Ledger (tipe: "Material Request") 25. Sistem commit transaction

**Main Success Scenario (PPIC - Finish Production):** 26. Proses produksi fisik selesai 27. PPIC buka detail request 28. PPIC klik "Selesaikan" 29. Sistem tampilkan form input hasil 30. PPIC input Qty Hasil Aktual: 98 pcs (2 reject) 31. PPIC klik "Finish" 32. Sistem update stok barang jadi: `stock += 98` 33. Sistem catat Stock Ledger 34. Sistem update status = "Finished" 35. Sistem hitung efisiensi produksi: 98/100 = 98%

---

### UC-014: View Financial Dashboard

**Aktor:** Finance, Manager  
**Precondition:** Ada data transaksi

**Main Success Scenario:**

1. User buka menu Keuangan → Dashboard
2. Sistem load data dengan filter default (30 hari terakhir)
3. Sistem tampilkan KPI Cards:
    - Saldo Kas
    - Net Movement
    - Total Piutang (dengan overdue count)
    - Total Hutang (dengan overdue count)
4. Sistem render Chart:
    - Arus Kas 6 Bulan (Bar Chart)
    - Distribusi Pengeluaran (Doughnut)
5. Sistem tampilkan tabel:
    - Top 5 Piutang Jatuh Tempo
    - Top 5 Hutang Jatuh Tempo
6. User ubah filter tanggal (Start Date - End Date)
7. User klik "Filter"
8. Sistem reload data dengan filter baru
9. Semua card dan chart di-update

---

### UC-015: Generate Stock Valuation Report

**Aktor:** Manager, Finance, Warehouse  
**Precondition:** Ada data produk dengan stok

**Main Success Scenario:**

1. User buka menu Laporan → Valuasi Stok
2. Sistem tampilkan filter:
    - Mode Valuasi: Beli / Rata-rata / Jual
    - Gudang: Semua / Spesifik
    - Kategori: Semua / Spesifik
3. Sistem hitung valuasi default (mode: Beli, gudang: Semua)
4. Sistem tampilkan:
    - Total Valuasi Aset: Rp 500.000.000
    - Aset Stok Mati: Rp 50.000.000
    - Potensi Laba: Rp 200.000.000
5. Sistem render Chart:
    - Komposisi Nilai Kategori (Doughnut)
    - Kesehatan Inventaris (Polar)
6. Sistem tampilkan tabel detail per produk
7. User ubah mode valuasi ke "Jual"
8. Sistem recalculate dengan harga jual
9. Nilai berubah sesuai perhitungan
10. User klik "Export PDF"
11. Sistem generate PDF Audit Report
12. Browser download file

**Alternative Export:**

-   10a. User klik "Export Excel"
    -   Sistem generate Excel dengan styling
    -   Browser download file

---

### UC-016: View Stock Ledger (Jurnal Stok)

**Aktor:** Warehouse, PPIC, Manager  
**Deskripsi:** Melihat histori lengkap mutasi stok

**Main Success Scenario:**

1. User buka menu Laporan → Jurnal Stok
2. Sistem tampilkan filter:
    - Periode (Start - End Date)
    - Gudang
    - Kategori
    - Item
3. Sistem load data dengan filter default (bulan ini)
4. Sistem tampilkan tabel:
    - Tanggal
    - Item (Nama + SKU)
    - Tipe Mutasi (Masuk/Keluar/Transfer/Adjustment)
    - Qty
    - Saldo Akhir
    - Referensi (link ke transaksi sumber)
5. User filter by Item spesifik
6. User klik "Filter"
7. Sistem tampilkan histori mutasi item tersebut saja
8. User klik link Referensi
9. Sistem buka detail transaksi di tab baru
10. User klik "Export PDF"
11. Sistem generate PDF dengan filter info
12. Browser download file

---

## 🔄 USE CASE RELATIONSHIPS

### Include Relationships

-   UC-001 (Login) **includes** UC-080 (Validate Credentials)
-   UC-006 (Create Purchase) **includes** UC-081 (Update Stock)
-   UC-008 (Create Sales) **includes** UC-081 (Update Stock)

### Extend Relationships

-   UC-002 (Reset Password) **extends** UC-001 (Login)
-   UC-009 (Print Invoice) **extends** UC-008 (Create Sales)
-   UC-010 (Process Return) **extends** UC-008 (Create Sales)

### Generalization

-   UC-003a, UC-003b, UC-003c **generalizes from** UC-003 (Manage Products)

---

## 📊 BUSINESS RULES

### BR-001: Stock Validation

-   Qty penjualan tidak boleh melebihi stok tersedia
-   Qty transfer tidak boleh melebihi stok gudang asal
-   Stock Adjustment harus diapprove Admin

### BR-002: Pricing Rules

-   Harga Jual harus >= Harga Beli (warning jika tidak)
-   Diskon maksimal 100%
-   Diskon tidak boleh negatif

### BR-003: Payment Rules

-   Jumlah Dibayar tidak boleh negatif
-   Jika kredit, Jatuh Tempo wajib diisi
-   Pembayaran hutang/piutang tidak boleh > sisa

### BR-004: Inventory Rules

-   SKU harus unique per produk
-   Produk yang pernah digunakan tidak bisa dihapus (soft delete only)
-   Dead Stock = tidak terjual > 90 hari

### BR-005: Production Rules

-   Material Request harus diapprove Warehouse sebelum produksi
-   Stok bahan baku otomatis berkurang saat "Start Production"
-   Qty hasil bisa < target (karena reject)

---

## 🎯 NON-FUNCTIONAL REQUIREMENTS

### Performance

-   Page load time < 3 detik
-   Report generation < 10 detik
-   Support 50 concurrent users

### Security

-   Password min 8 karakter
-   Session timeout 2 jam
-   RBAC untuk semua modul kritis
-   Audit log untuk transaksi finansial

### Usability

-   Responsive design (mobile-friendly)
-   Konsisten UI (Bootstrap 5)
-   Search autocomplete < 500ms
-   Clear error messages

### Reliability

-   Database backup harian
-   Transaction rollback on error
-   Data integrity via foreign keys

---

**Versi Dokumen:** 1.0  
**Terakhir Diperbarui:** 30 Desember 2025  
**Penyusun:** PT NBC Indonesia IT Department

---

_"Use case yang detail adalah fondasi sistem yang solid"_
