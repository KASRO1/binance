<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'symbol',
        'name',
        'course',
        'spending_limit',
        'type',
    ];


}
