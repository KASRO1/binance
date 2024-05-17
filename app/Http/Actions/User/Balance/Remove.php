<?php

namespace App\Http\Actions\User\Balance;

use App\Models\Balance;
use App\Models\Currency;

class Remove
{
    /**
     * @param $currency - id
     * @param $amount - float
     */
    public function run($currency, $amount)
    {
        $balance = Balance::query()->where('user_id', auth()->id())->where('currency', $currency)->first();
        if ($balance) {
            $balance->amount -= $amount;
            $balance->save();
        } else {
            $balance = new Balance();
            $balance->user_id = auth()->id();
            $balance->currency = $currency;
            $balance->amount = 0;
            $balance->save();
        }
    }
}
