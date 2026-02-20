<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = "tbl_orderan";

    const STATUS_DRAFT = 0;
    const STATUS_ORDER_MASUK = 99; // Deprecated
    const STATUS_BELUM_DIPROSES = 1;
    const STATUS_PROSES_PRODUKSI = 2;
    const STATUS_PRODUKSI_SELESAI = 3;
    const STATUS_SIAP_KIRIM = 4;
    const STATUS_SELESAI_DIKIRIM = 5;
    const STATUS_STOK_BARANG = 6;

    protected $fillable = [
        'tgl_order',
        'no_po',
        'nama_vendor',
        'no_hp',
        'alamat',
        'pesanan_untuk',
        'sistem_dp',
        'dp',
        'deadline',
        'jenis_orderan',
        'bahan',
        'warna',
        'harga_satuan',
        'qty',
        'size_details',
        'detail_size_besar',
        'catatan',
        'pembelanjaan_bahan',
        'harga',
        'hpp_bahan',
        'hpp_cmt',
        'hpp_bordir',
        'hpp_sablon',
        'hpp_benang',
        'profit_value',
        'omset_total',
        'hpp_packaging',
        'pemeriksa',
        'status',
        'vendor_id',
        'user_id',
        'status_pembayaran',
        'loker_id',
        'catatan_stok',
    ];

    protected $casts = [
        'jenis_orderan' => 'array',
        'bahan' => 'array',
        'warna' => 'array',
        'harga_satuan' => 'array',
        'qty' => 'array',
        'size_details' => 'array',
        'detail_size_besar' => 'array',
        'catatan' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(VendorModel::class, 'vendor_id');
    }

    public function loker()
    {
        return $this->belongsTo(LokerModel::class, 'loker_id');
    }

    /**
     * Relasi ke User (Pemeriksa)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke DetailOrderanModel
     * Satu orderan memiliki banyak detail orderan
     */
    public function detailOrderan()
    {
        return $this->hasMany(DetailOrderanModel::class, 'orderan_id');
    }

    /**
     * Relasi ke PembayaranModel
     * Satu orderan memiliki banyak pembayaran (DP, pelunasan, dll)
     */
    public function pembayaran()
    {
        return $this->hasMany(PembayaranModel::class, 'orderan_id');
    }

    /**
     * Relasi ke StokModel
     * Satu orderan bisa menghasilkan banyak stok barang
     */
    public function stokBarang()
    {
        return $this->hasMany(StokModel::class, 'orderan_id');
    }

    public function itemSizes()
    {
        return $this->hasMany(OrderItemSizeModel::class, 'order_id');
    }

    public $timestamps = false;
}
