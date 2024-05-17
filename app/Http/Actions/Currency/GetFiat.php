<?php

namespace App\Http\Actions\Currency;

use App\Models\Currency;

class GetFiat
{
    public function run($type = 'data')
    {
        if ($type === 'data'){
            return Currency::query()
                ->where('type', 'fiat')
                ->get()->toArray();

        }
        else if($type === 'options'){
            return Currency::query()
                ->where('type', 'fiat')
                ->distinct()
                ->pluck('symbol', 'id')
                ->toArray();
        }

    }
}
