<?php

namespace App\Http\Actions\User\Balance;

use App\Models\Balance;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;

class GetFullBalance
{
    public function run($user)
    {
        $mainCurrency = Currency::query()->where("symbol", $user->main_currency)->first();
        $balances = Balance::query()->where('user_id', $user->id)->get();
        $full_balance = 0;
        foreach ($balances as $balance) {
            $currency = Currency::query()->where('id', $balance->currency)->first();
            if ($mainCurrency->symbol == $currency->symbol) {

                continue;
            }
            $full_balance += $balance->amount * $currency->course;

        }
        $full_balance = $full_balance * $mainCurrency->course;

        $mainCurrencyBalance = Balance::query()->where('user_id', $user->id)->where('currency', $mainCurrency->id)->first();
        if ($mainCurrencyBalance) {
            $full_balance += $mainCurrencyBalance->amount;
        }

        return number_format($full_balance, 1, '.', '');
    }
}
