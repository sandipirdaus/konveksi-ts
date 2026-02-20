<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LokerModel extends Model
{
    protected $table = "tbl_loker";

    protected $fillable = [
        'id_loker',
        'nama_loker'
    ];

    public $timestamps = false;

    /**
     * Relasi ke Stok
     * Satu loker bisa menyimpan banyak stok barang
     */
    public function stok()
    {
        return $this->hasMany(StokModel::class, 'loker_id');
    }
}
