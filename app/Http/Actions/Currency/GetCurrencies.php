<?php

namespace App\Http\Actions\Currency;

use App\Models\Currency;

class GetCurrencies
{
    public function run($type = 'data')
    {
        if ($type === 'data'){
            return Currency::query()
                ->get()->toArray();

        }
        else if($type === 'options'){
            return Currency::query()
                ->distinct()
                ->pluck('symbol', 'id')
                ->toArray();
        }
        else if ($type === 'only_value'){
            $symbols = Currency::distinct()->pluck('symbol')->toArray();
            $symbols = array_combine($symbols, $symbols);
            return $symbols;
        }

    }
}
