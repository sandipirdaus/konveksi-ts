<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BahanModel extends Model
{
    protected $table = 'tbl_bahan';

    protected $fillable = ['jenis_orderan_id', 'nama_bahan', 'harga_satuan', 'keterangan'];

    public function jenisOrderan()
    {
        return $this->belongsTo(JenisOrderanModel::class, 'jenis_orderan_id');
    }
}
