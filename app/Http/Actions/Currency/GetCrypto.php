<?php

namespace App\Http\Actions\Currency;

use App\Models\Currency;

class GetCrypto
{
    public function run($type = 'data')
    {
        if ($type === 'data'){
            return Currency::query()
                ->where('type', 'crypto')
                ->get()->toArray();

        }
        else if($type === 'options'){
            return Currency::query()
                ->where('type', 'crypto')
                ->distinct()
                ->pluck('symbol')
                ->toArray();
        }

    }
}
