<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrderanModel extends Model
{
    protected $table = "tbl_detail_orderan";

    protected $fillable = [
        'orderan_id',
        'jenis_orderan',
        'bahan',
        'warna',
        'harga_satuan',
        'qty',
        'detail_size_besar',
        'catatan',
    ];

    /**
     * Relasi ke OrderModel
     * Setiap detail orderan belongs to satu orderan
     */
    public function orderan()
    {
        return $this->belongsTo(OrderModel::class, 'orderan_id');
    }

    /**
     * Accessor untuk mendapatkan detail size besar sebagai array
     */
    public function getDetailSizeBesarAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    /**
     * Mutator untuk menyimpan detail size besar sebagai JSON
     */
    public function setDetailSizeBesarAttribute($value)
    {
        $this->attributes['detail_size_besar'] = $value ? json_encode($value) : null;
    }
}
