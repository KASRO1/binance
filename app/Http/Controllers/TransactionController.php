<?php

namespace App\Http\Controllers;

use App\Http\Actions\Currency\GetCourse;
use App\Http\Actions\Transaction\Create;
use App\Http\Actions\User\Balance\Add;
use App\Http\Actions\User\Balance\Remove;
use App\Http\Requests\TransactionRequest;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(TransactionRequest $request)
    {
        $user = auth()->user();
        $order = Order::findOrFail($request->order_id);
        $amount = $request->amount;
        $cur_from = Currency::query()->where('id', $order->currency_from)->first();
        $cur_to = Currency::query()->where('id', $order->currency_to)->first();
        $balance = Balance::query()->where('user_id', $user->id)->where('currency', $order->currency_from)->first();

        if($cur_from->type == 'fiat' && $cur_to->type == 'fiat') {
            $status = '2';
            $type = 'fiat';

        } else if ($cur_from->type == 'crypto' && $cur_to->type == 'crypto') {
            $status = '4';
            $type = 'crypto';
            if ($balance->amount < $amount) {
                return response()->json(['error' => 'Not enough money'], 400);
            }
        } else {
            $status = '2';
            $type = 'fiat_crypto';
        }

        $transaction = (new Create)->run($user, $order, $amount, $status);
        if ($type !== 'fiat'){
            (new Remove())->run($cur_from->id, $amount);
        }

        return response()->json($transaction);
    }

    public function change(Request $request)
    {
        $user = auth()->user();
        $status = $request->status;
        $transaction = Transaction::query()->where('id', $request->transaction_id)->first();

        $order = Order::query()->where('id',$transaction->order_id)->first();
        $course_from = (new GetCourse())->run($order->currency_from);
        $course_to = (new GetCourse())->run($order->currency_to);
        $amount = $transaction->amount * $course_from / $course_to;
        $currency_to = Currency::query()->where('id', $order->currency_to)->first();

        if($status == 5){
            (new Add())->run($order->currency_to,$amount);
            $user->open_deal = 0;
            $user->open_deal_id = null;
            if($currency_to && $currency_to->spending_limit){
                $user->limit_deals -= 1;
            }
            $user->save();

        }
        elseif ($status == 6){
            (new Add())->run($order->currency_from, $amount);
            $user->open_deal = 0;
            $user->open_deal_id = null;
            $user->save();
        }
        elseif ($status == 1){
            $user->open_deal = 0;
            $user->open_deal_id = null;
            $user->save();
        }
        $transaction->status = $status;
        $transaction->save();
    }

}
