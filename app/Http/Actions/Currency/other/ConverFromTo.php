<?php

namespace App\Http\Actions\Currency\other;

use App\Models\Currency;

class ConverFromTo
{

    public function run($from, $to, $amount, $user = null)
    {
        if($user == null)
        {
            $user = auth()->user();
        }
        $main_currency = Currency::query()->where('symbol', $user->main_currency)->first();
        $from = Currency::query()->where('id', $from)->first();
        $to = Currency::query()->where('id', $to)->first();
        $amount = $amount * $from->course;
        $amount = $amount / $to->course;
        $to_amount_main_currency = $amount * $main_currency->course;
        return $to_amount_main_currency;
    }
}
