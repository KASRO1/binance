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
        if($cur_from->type == 'fiat' && $cur_to->type == 'fiat') {
            $status = '2';
        } else if ($cur_from->type == 'crypto' && $cur_to->type == 'crypto') {
            $status = '4';
        } else {
            $status = '2';
        }

        $transaction = (new Create)->run($user, $order, $amount, $status);
        (new Remove())->run($cur_from->id, $amount);

        return response()->json($transaction);
    }

    public function change(Request $request)
    {
        $user = auth()->user();
        $status = $request->status;
        $transaction = Transaction::query()->where('id', $request->transaction_id)->first();

        $order = Order::findOrFail($transaction->order_id);
        $course_from = (new GetCourse())->run($order->currency_from);
        $course_to = (new GetCourse())->run($order->currency_to);
        $amount = $transaction->amount * $course_from / $course_to;

        if($status == 5){
            (new Add())->run($order->currency_to,$amount);
            $user->open_deal = 0;
            $user->open_deal_id = null;
            $user->limit_deals -= 1;
            $user->save();

        }
        elseif ($status == 6){
            (new Add())->run($order->currency_from, $amount);
            $user->open_deal = 0;
            $user->open_deal_id = null;
            $user->save();
        }
        $transaction->status = $status;
        $transaction->save();
    }

}
