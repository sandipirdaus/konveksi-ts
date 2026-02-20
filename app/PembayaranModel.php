<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranModel extends Model
{
    protected $table = "tbl_pembayaran";

    protected $fillable = [
        'orderan_id',
        'jenis_pembayaran',
        'jumlah',
        'tanggal_bayar',
        'metode_pembayaran',
        'keterangan',
    ];

    protected $dates = [
        'tanggal_bayar',
    ];

    /**
     * Relasi ke OrderModel
     * Setiap pembayaran belongs to satu orderan
     */
    public function orderan()
    {
        return $this->belongsTo(OrderModel::class, 'orderan_id');
    }
}
