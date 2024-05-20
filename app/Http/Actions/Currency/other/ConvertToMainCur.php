<?php

namespace App\Http\Actions\Currency\other;

use App\Models\Currency;

class ConvertToMainCur
{
    public function run($user, $from, $amount)
    {
        $main_currency = Currency::query()->where('symbol', $user->main_currency)->first();
        $from = Currency::query()->where('id', $from)->first();
        $amount = $amount * $from->course;
        return $amount / $main_currency->course;
    }
}
