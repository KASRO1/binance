<?php

namespace App\Http\Actions\User\Balance;

use App\Models\Balance;

class Get
{
    public function run($currency)
    {
        $balance = Balance::query()->where('user_id', auth()->id())->where('currency', $currency)->first();
        return $balance->amount ?? 0;
    }
}
