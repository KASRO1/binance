<?php

namespace App\Http\Actions\System;

use Illuminate\Support\Facades\App;

class SetLanguage
{
    public function run($language)
    {
        App::setLocale($language);
        session()->put('locale', $language);
        return redirect()->back();
    }
}
