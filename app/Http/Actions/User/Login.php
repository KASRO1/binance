<?php

namespace App\Http\Actions\User;

use Illuminate\Support\Facades\Auth;

class Login
{
    public function run($request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            return response()->json(['status' => 'success', 'data' => Auth::user()]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        }
    }
}

