<?php

namespace App\Http\Actions\User;

use App\Models\Currency;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Create
{
    public function run($request)
    {
        $promocode = Promo::query()->where('code', $request->promocode)->first();
        $currency = Currency::query()->where('symbol', $request->currency)->first();
        $user = User::query()->create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'promo_code' => $promocode ? $promocode->code : null,
            'main_currency' => $currency->symbol,
        ]);

        return response()->json(['status' => 'success', 'data' => $user], 201);
    }
}
