<?php

namespace App\Http\Controllers;

use App\Http\Actions\Currency\GetCourse;
use App\Http\Actions\Deposit\Create;
use App\Http\Requests\DepositRequest;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Spread;
use App\Models\Transaction;
use App\MoonShine\Resources\DepositResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function get($order_id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($order_id);
        $currency = Currency::query()->where('id', $order->currency_from)->first();
        $balance = Balance::query()->where('currency', $currency->id)->where('user_id', $user->id)->first();

        if($balance){
            $balance = $balance->amount;
        }
        else{
            $balance = 0;
        }
        if($user->open_deal){
            $status = Transaction::query()->where('id', $user->open_deal_id)->first()->status;
        }
        else{
            $status = null;
        }
        $order->status= $status;
        $order->balance = $balance;
        $order->currency_name = $currency->symbol;
        $order->price = number_format((new GetCourse())->run($order->currency_from), 2, '.', '');
        return response()->json($order);
    }

    public function deposit(DepositRequest $request)
    {
        (new Create())->run($request);
    }
}
