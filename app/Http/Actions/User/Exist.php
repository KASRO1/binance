<?php

namespace App\Http\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Exist
{
    public function run($data)
    {
        if($data['type'] === 'email'){
            $user = User::query()->where('email', $data['value'])->first();
            if($user){
                return response()->json(['exist' => true]);
            }
            else{
                return response()->json(['exist' => false]);

            }
        }
        if($data['type'] === 'email_and_password'){
            $password = Hash::make($data['password']);
            $user = User::query()->where('email', $data['value'])->where('password', $password)->first();
            if($user){
                return response()->json(['exist' => true]);
            }
            else{
                return response()->json(['exist' => false]);
            }
        }
        return response()->json(['exist' => false]);
    }
}
