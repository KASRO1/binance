<?php

namespace App\Http\Controllers;

use App\Http\Actions\Currency\GetCourse;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Spread;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function get($order_id)
    {
        $order = Order::findOrFail($order_id);
        $currency = Currency::query()->where('id', $order->currency_to)->first();
        $order->currency_name = $currency->symbol;
        $order->price = number_format((new GetCourse())->run($order->currency_from), 2, '.', '');
        return response()->json($order);
    }
}
