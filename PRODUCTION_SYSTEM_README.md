# Sistem Manajemen Status Orderan (6 Tahap)

## Status Flow (Urutan Wajib)

Sistem ini menggunakan 6 tahap status yang **HARUS diikuti secara berurutan**:

```
0. ORDER_MASUK          → Order baru masuk, belum dikonfirmasi
   ↓ (Konfirmasi Order)
1. BELUM_DIPROSES       → Order sudah dikonfirmasi, belum mulai produksi
   ↓ (Mulai Produksi)
2. PROSES_PRODUKSI      → Sedang dalam proses produksi
   ↓ (Selesai Produksi)
3. PRODUKSI_SELESAI     → Produksi selesai, barang masuk loker (stok bertambah)
   ↓ (Klik "Siap Kirim" di Dashboard Stok)
4. SIAP_KIRIM           → Semua barang sudah siap untuk dikirim
   ↓ (Otomatis saat semua stok dikirim)
5. SELESAI_DIKIRIM      → Order selesai dan telah dikirim
```

## Alur Kerja Lengkap

### 1. Input Order Baru
- **Aksi**: Owner/Karyawan membuat order baru via "Input Orderan"
- **Status Awal**: `ORDER_MASUK` (0)
- **Dashboard**: Muncul di card "Order Masuk"
- **Detail Ukuran**: 
  - Pilih ukuran dari dropdown (S, M, L, XL)
  - Input qty per ukuran
  - Sistem validasi: Total qty ukuran ≤ Total QTY (PCS)

### 2. Konfirmasi Order
- **Aksi**: Klik "Konfirmasi Order" di halaman Order Masuk
- **Status Berubah**: `ORDER_MASUK` → `BELUM_DIPROSES` (1)
- **Dashboard**: Pindah ke card "Belum Diproses"

### 3. Mulai Produksi
- **Aksi**: Klik "Mulai Produksi" di halaman Belum Diproses
- **Status Berubah**: `BELUM_DIPROSES` → `PROSES_PRODUKSI` (2)
- **Dashboard**: Pindah ke card "Proses Produksi"

### 4. Selesai Produksi
- **Aksi**: Klik "Selesai Produksi" di halaman Proses Produksi
- **Status Berubah**: `PROSES_PRODUKSI` → `PRODUKSI_SELESAI` (3)
- **Stok Otomatis**: 
  - Sistem membaca data ukuran dari `tbl_order_item_sizes`
  - Membuat entry di `tbl_stok` untuk setiap ukuran
  - Status stok: "Di Loker"
  - Data yang disimpan: order_id, size, qty, vendor, barang, warna, bahan
- **Dashboard**: 
  - Order pindah ke card "Produksi Selesai"
  - Barang muncul di tabel "Stok Barang (Di Loker)"

### 5. Siap Kirim
- **Aksi**: Karyawan klik tombol "Siap Kirim" di tabel Stok Loker (Dashboard)
- **Proses**:
  - Status stok berubah: "Di Loker" → "Selesai Dikirim"
  - Sistem cek: Apakah semua stok dari order ini sudah dikirim?
  - Jika **YA**: Status order berubah `PRODUKSI_SELESAI` → `SIAP_KIRIM` (4)
- **Dashboard**: 
  - Barang pindah ke tabel "Selesai Dikirim"
  - Order pindah ke card "Siap Dikirim"

### 6. Selesai Dikirim
- **Aksi**: Otomatis saat semua item stok dari order telah dikirim
- **Status Berubah**: `SIAP_KIRIM` → `SELESAI_DIKIRIM` (5)
- **Dashboard**: Order pindah ke card "Selesai Dikirim" (Arsip)

## Fitur Khusus: Detail Ukuran

### Database Normalisasi
- **Tabel**: `tbl_order_item_sizes`
- **Struktur**:
  ```
  - id
  - order_id
  - item_index (index item dalam order)
  - size (S, M, L, XL)
  - qty
  - timestamps
  ```

### Input Form
- Ukuran: **Dropdown tetap** (S, M, L, XL) - tidak bisa input manual
- Qty: Input angka per ukuran
- **Validasi Real-time**:
  - Total PCS: Jumlah maksimal dari field QTY (PCS)
  - Total PCS Terpakai: Sum dari qty semua ukuran (normal + size besar)
  - Sisa PCS: Total - Terpakai
  - **Error**: Submit ditolak jika Terpakai > Total

### Relasi Stok
- Setiap ukuran disimpan sebagai **entry terpisah** di `tbl_stok`
- Contoh: Order 10 pcs (S:3, M:4, L:3) → 3 entry stok terpisah
- Dashboard menampilkan badge per ukuran: `S: 3`, `M: 4`, `L: 3`

## Role-Based Access

### Owner
- ✅ Akses penuh semua menu
- ✅ Master Data (Orderan, Akun, Stok, Penggajian)
- ✅ Input dan Edit Order
- ✅ Ubah status order
- ✅ Lihat semua laporan

### Karyawan
- ✅ Dashboard
- ✅ Input Orderan
- ✅ Lihat Orderan (Read-only)
- ✅ Ubah status order (Konfirmasi, Mulai, Selesai Produksi)
- ✅ Klik "Siap Kirim" di Stok Loker
- ✅ Penggajian (Lihat saja)
- ❌ Master Data
- ❌ Edit/Hapus Order
- ❌ Input Stok Manual
- ❌ Omset

## Validasi & Keamanan

### Validasi Status
- **Sequence Lock**: Sistem hanya mengizinkan perpindahan status ke tahap berikutnya
- **Contoh**: Order dengan status `BELUM_DIPROSES` hanya bisa ke `PROSES_PRODUKSI`, tidak bisa langsung ke `SIAP_KIRIM`
- **Error Handling**: Jika ada upaya melompati tahap, sistem menampilkan error

### Validasi Qty
- **Client-side**: Real-time validation dengan JavaScript
- **Server-side**: Double-check di OrderController sebelum save
- **Pesan Error**: "Total Qty Ukuran (Normal + Besar) pada item X melebihi Total QTY (PCS)"

### Validasi Stock
- Tidak ada input stok manual
- Semua stok **HARUS** berasal dari "Selesai Produksi"
- Relasi `orderan_id` wajib untuk tracking

## Dashboard Cards

1. **Orderan** (Total semua order)
2. **Order Masuk** (Status 0) - Abu-abu
3. **Belum Diproses** (Status 1) - Merah
4. **Proses Produksi** (Status 2) - Kuning
5. **Produksi Selesai** (Status 3) - Biru
6. **Siap Dikirim** (Status 4) - Biru Tua
7. **Selesai Dikirim** (Status 5) - Hijau
8. **Stok Barang** (Di Loker) - Abu-abu

## Routes

```php
// Order Status Views
GET /orderan/order_masuk           → Lihat order masuk
GET /orderan/belum_proses          → Lihat belum diproses
GET /on_proses                     → Lihat proses produksi
GET /siap_kirim                    → Lihat siap kirim
GET /orderan_selesai               → Lihat selesai dikirim

// Status Actions
GET /orderan/konfirmasi/{id}       → Konfirmasi order (0→1)
GET /orderan/mulai_produksi/{id}   → Mulai produksi (1→2)
GET /orderan/selesai_produksi/{id} → Selesai produksi (2→3, auto-create stock)
GET /siap_kirim_stok/{id}          → Mark stock as shipped (update order status)
```

## Constants (OrderModel)

```php
const STATUS_ORDER_MASUK = 0;
const STATUS_BELUM_DIPROSES = 1;
const STATUS_PROSES_PRODUKSI = 2;
const STATUS_PRODUKSI_SELESAI = 3;
const STATUS_SIAP_KIRIM = 4;
const STATUS_SELESAI_DIKIRIM = 5;
```

## Changelog

### 2026-01-30
- ✅ Implemented 6-stage order status flow
- ✅ Added status constants to OrderModel
- ✅ Created normalized size storage (`tbl_order_item_sizes`)
- ✅ Automated stock creation on production completion
- ✅ Automated order status updates based on stock shipment
- ✅ Added real-time QTY validation in order form
- ✅ Created "Order Masuk" status and view
- ✅ Updated dashboard with all status cards
- ✅ Implemented role-based access for Karyawan vs Owner
