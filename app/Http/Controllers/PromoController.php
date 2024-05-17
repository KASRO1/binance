<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Actions\Promo\Exist;
class PromoController extends Controller
{
    public function exist(Request $request)
    {
        return (new Exist())->run($request);
    }
}
