<?php

namespace App\Http\Actions\Bonus;

use App\Models\Deposit;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;

class Get
{


    public function run($user = null)
    {
        if(!$user){
            $user = auth()->user();
        }
        $promo = $user->promo_code;
        $deposits = Deposit::query()->where('user_id', $user->id)->where('status', 2)->get();
        if($promo && $deposits->count() <= 1){
            $promo = Promo::query()->where('code', $promo)->first();
            $bonus = $promo->deposit_bonus;
        }
        elseif ($deposits->count() <= 1){
            $bonus = 30;
        }
        else{
            $bonus = 0;
        }
        return $bonus;

    }
}
