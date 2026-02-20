<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    protected $table = "tbl_stok";
    protected $fillable = 
    [
    'id_loker', 
    'nama_loker', 
    'nama_vendor', 
    'nama_barang', 
    'qty', 
    'warna', 
    'bahan', 
    'size', 
    'pemeriksa', 
    'tgl_pemeriksaan',
    'orderan_id',
    'loker_id',
    'user_id',
    'status',
    'size_details',
    'update_terakhir_stok',
    'catatan'
    ];

    protected $casts = [
        'size_details' => 'array',
    ];

    public $timestamps = true;

    /**
     * Relasi ke OrderModel
     * Stok barang bisa berasal dari satu orderan
     */
    public function orderan()
    {
        return $this->belongsTo(OrderModel::class, 'orderan_id');
    }

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'orderan_id');
    }

    /**
     * Relasi ke LokerModel
     * Stok barang tersimpan di satu loker
     */
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

}
