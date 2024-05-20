<?php

namespace App\Http\Controllers;

use App\Http\Actions\System\SetLanguage;
use App\Models\Currency;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function setLanguage($language)
    {
        return (new SetLanguage())->run($language);
    }

    public function register(){

        $currency = Currency::query()->where('type', 'fiat')->get()->toArray();
        return view("pages.register", ['currencies' => $currency]);
    }

    public function login()
    {
        return view("pages.login");
    }

    public function convert($from, $to, $amount)
    {
        dd(123);
        $user = auth()->user();
        $main_currency = Currency::query()->where('symbol', $user->main_currency)->first();
        $from = Currency::query()->where('symbol', $from)->first();
        $to = Currency::query()->where('symbol', $to)->first();
        $amount = $amount * $from->course;
        $amount = $amount / $to->course;
        $to_amount_main_currency = $amount * $main_currency->course;
        return $to_amount_main_currency;
    }

    public function convertToMainCur($from, $amount)
    {
        $user = auth()->user();
        $main_currency = Currency::query()->where('symbol', $user->main_currency)->first();
        $from = Currency::query()->where('id', $from)->first();
        $amount = $amount * $from->course;
        $amount = number_format($amount / $main_currency->course, 2, '.', '');
        return response()->json(['amount' => $amount, 'currency' => $main_currency->symbol]);
    }

}
