<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemSizeModel extends Model
{
    protected $table = 'tbl_order_item_sizes';

    protected $fillable = [
        'order_id',
        'item_index',
        'size',
        'qty',
    ];

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }
}
