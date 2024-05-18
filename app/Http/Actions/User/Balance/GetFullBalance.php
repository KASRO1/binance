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
            $full_balance += $balance->amount * $currency->course;
        }
        return number_format($full_balance * $mainCurrency->course ,3, '.', '');
    }
}
