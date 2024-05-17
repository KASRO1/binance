<?php

namespace App\Http\Actions\Currency;

use App\Models\Currency;
use App\Models\Spread;

class GetCourse
{
    public function run($currency)
    {
        $currency_db = Currency::where('id', $currency)->first();
        $spread = Spread::query()->where('currency_from', $currency)->first();
        if($spread && $spread->active){
            return $currency_db->course * $spread->spread;
        }
        else{
            return $currency_db->course;
        }
    }
}
