<?php

namespace App\Http\Actions\User;

use App\Models\Currency;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;

class Profile
{
    public function run()
    {
        $user = Auth::user();
        $user->color = $this->get_color($user['email'][0]);

        $transfers = Transfer::query()->where('user_id', $user->id)->latest('created_at')->get()->toArray();
        foreach ($transfers as $key => $transfer){

            $transfers[$key]['color'] = $this->get_color($transfer['username'][0]);
        }


        $promo_discount = Promo::query()->where('code', $user->promo_code)->first();
        if($promo_discount){
            $promo_discount = $promo_discount->deposit_bonus;
        }
        else{
            $promo_discount = 30;
        }

        return view('pages.profile', ['user'=> $user, 'transfers' => $transfers, 'promo_discount' => $promo_discount]);
    }

    private function generateColor($index) {
        $hash = md5('color' . $index);
        return '#' . substr($hash, 0, 6);
    }

    private function get_color($letter) {
        $colors = [];
        foreach (range('a', 'z') as $index => $item) {
            $colors[$item] = $this->generateColor($index);
        }
        foreach (range('A', 'Z') as $index => $item) {
            $colors[$item] = $this->generateColor($index);
        }

        if (!array_key_exists($letter, $colors)) {
            return null;
        }

        return $colors[$letter];
    }

}
