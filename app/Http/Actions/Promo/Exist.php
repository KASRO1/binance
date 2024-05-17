<?php

namespace App\Http\Actions\Promo;

use App\Models\Currency;
use App\Models\Promo;
use App\Models\User;

class Exist
{
    public function run($request)
    {
        $promo = Promo::query()->where('code', $request->promocode)->first();
        if ($promo) {
            $currency = Currency::query()->where('id', $promo->currency)->first();
            return response()->json(['exist' => true, 'message' => $promo->description, 'currency' => $currency->symbol]);
        } else {
            return response()->json(['exist' => false]);
        }
    }
}
