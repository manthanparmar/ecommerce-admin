<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $connection = 'mysql';
    protected $table = "cart";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];
}
