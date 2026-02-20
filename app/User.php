<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'foto', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke Orderan
     * User bisa memeriksa/membuat banyak orderan
     */
    public function orderan()
    {
        return $this->hasMany(OrderModel::class, 'user_id');
    }

    /**
     * Relasi ke Stok
     * User bisa memeriksa/input banyak stok
     */
    public function stok()
    {
        return $this->hasMany(StokModel::class, 'user_id');
    }
}
