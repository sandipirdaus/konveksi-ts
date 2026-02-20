<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisOrderanModel extends Model
{
    protected $table = 'tbl_jenis_orderan';

    protected $fillable = ['nama_jenis'];

    public function bahan()
    {
        return $this->hasMany(BahanModel::class, 'jenis_orderan_id');
    }
}
