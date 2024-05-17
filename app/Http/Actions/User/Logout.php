<?php

namespace App\Http\Actions\User;

use Illuminate\Support\Facades\Auth;

class Logout
{
    public function run()
    {
        Auth::logout();
        return redirect('/');
    }
}

