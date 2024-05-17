<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'orders',
        'completion',
        'available',
        'feedback',
        'qr_code',
        'сredentials',
        'currency_from',
        'currency_to',
        'limit',
        'time',
        'commission',
        'bestPrice',
        'AutoMode'
    ];
}
