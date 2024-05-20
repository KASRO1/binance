<?php

namespace App\Http\Actions\User\Balance;

use App\Models\Balance;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;

class Add
{

    /**
     * @param $currency - id
     * @param $amount - float
     */
    public function run($currency, $amount, $user = null)
    {
        if($user == null)
        {
            $user = auth()->user();
        }
        Log::info('Add balance', ['currency' => $currency, 'amount' => $amount]);

        $debugTrace = debug_backtrace();
        $caller = $debugTrace[1];

        Log::info('Function called from', ['file' => $caller['file'], 'line' => $caller['line']]);
        $balance = Balance::where('user_id', $user->id)->where('currency', $currency)->first();
        if ($balance) {
            $balance->amount += $amount;
            $balance->save();
        } else {
            $balance = new Balance();
            $balance->user_id = $user->id;
            $balance->currency = $currency;
            $balance->amount = $amount;
            $balance->save();
        }
        Log::info('Balance added', ['currency' => $balance, 'amount' => $amount]);
    }

}
