<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorModel extends Model
{
    protected $table = 'tbl_vendor';

    protected $fillable = [
        'nama_vendor',
        'no_hp',
        'alamat'
    ];

    public function orderan()
    {
        return $this->hasMany(OrderModel::class, 'vendor_id');
    }

    public function gaji_karyawan()
    {
        return $this->hasMany(GajiKaryawanModel::class, 'vendor_id');
    }

    public $timestamps = false;
}
