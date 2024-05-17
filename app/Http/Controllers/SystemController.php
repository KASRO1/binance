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

}
