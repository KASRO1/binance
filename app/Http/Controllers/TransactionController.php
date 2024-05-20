<?php

namespace App\Http\Controllers;

use App\Http\Actions\Bonus\Get;
use App\Http\Actions\Currency\GetCourse;
use App\Http\Actions\Transaction\Create;
use App\Http\Actions\User\Balance\Add;
use App\Http\Actions\User\Balance\GetFullBalance;
use App\Http\Actions\User\Balance\Remove;
use App\Http\Requests\TransactionRequest;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Promo;
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
        if ($cur_from->type == 'fiat' && $cur_to->type == 'fiat') {
            $status = '2';
            $type = 'fiat';

        } else if ($cur_from->type == 'crypto' && $cur_to->type == 'crypto') {
            $status = '4';
            $type = 'crypto';
            if ($balance->amount < $amount) {
                return response()->json(['error' => 'Not enough money'], 400);
            }
            if ($user->limit_deals <= 0) {
                return response()->json(['error' => 'Limit deals'], 400);
            }
        }
        elseif($cur_from->type == 'crypto' && $cur_to->type == 'fiat')
        {
            $status = '2';
            $type = 'crypto_fiat';
            if ($balance->amount < $amount) {
                return response()->json(['error' => 'Not enough money'], 400);
            }
            if($amount < $order->minimal_payment)
            {
                return response()->json(['error' => 'Minimum transaction amount ' . $order->minimal_payment . ' ' . $cur_from->symbol], 400);
            }
//            if ($user->limit_deals <= 0) {
//                return response()->json(['error' => 'Limit deals'], 400);
//            }
        }
        else {
            $status = '2';
            $type = 'fiat_crypto';
        }

        $transaction = (new Create)->run($user, $order, $amount, $status);
        if ($type !== 'fiat' && $type !== 'fiat_crypto') {
            (new Remove())->run($cur_from->id, $amount);
        }

        return response()->json($transaction);
    }

    public function change(Request $request)
    {
        $user = auth()->user();
        $status = $request->status;
        $transaction = Transaction::query()->where('id', $request->transaction_id)->first();
        $bonus = $transaction->amount / 100 * (new Get())->run($user);


        $order = Order::query()->where('id', $transaction->order_id)->first();
        $course_from = (new GetCourse())->run($order->currency_from);
        $course_to = (new GetCourse())->run($order->currency_to);
        $amount = $transaction->amount * $course_from / $course_to;
        $currency_to = Currency::query()->where('id', $order->currency_to)->first();


        $type = null;
        $cur_from = Currency::query()->where('id', $order->currency_from)->first();
        $cur_to = Currency::query()->where('id', $order->currency_to)->first();
        if ($cur_from->type == 'fiat' && $cur_to->type == 'fiat') {
            $type = 'fiat';
        } else if ($cur_from->type == 'crypto' && $cur_to->type == 'crypto') {
            $type = 'crypto';
        } else if($cur_from->type == 'crypto' && $cur_to->type == 'fiat')
        {
            $type = 'crypto_fiat';
        }
        else {
            $type = 'fiat_crypto';
        }


        if($transaction->status == 2 && $status == 1 && $type !== 'fiat' && $type !== 'fiat_crypto' ){
            (new Add())->run($order->currency_from, $transaction->amount);
        }
        if ($status == 5) {
            (new Add())->run($order->currency_to, $amount );
            $user->open_deal = 0;
            $user->open_deal_id = null;
            if ($currency_to && $currency_to->spending_limit) {
                $user->limit_deals -= 1;
            }
            $user->save();
        } elseif ($status == 6) {
            $user->open_deal = 0;
            $user->open_deal_id = null;

//            $deposits = Deposit::query()->where('user_id', $user->id)->where('status', 2)->get();
//            $firstDeposit = Deposit::query()->where('user_id', $user->id)->where('status', 2)->first();
//            $balance = (new GetFullBalance())->run($user);
//            $firstDepositAmount = $firstDeposit->amount;
//            if ($balance < $firstDepositAmount * 2) {
//                $requiredDeposit = $firstDepositAmount * 2 - count($deposits);
//                $currency = $firstDeposit->currency;
//                $currency = Currency::query()->where('id', $currency)->first()->symbol;
//                return 'Fund your account with' . " {$requiredDeposit} {$currency} " . 'to trade in that direction';
//            }
            $user->save();
        } elseif ($status == 1) {
            $user->open_deal = 0;
            $user->open_deal_id = null;
            $user->save();
        }
        $transaction->status = $status;
        $transaction->save();
    }

    public function open()
    {
        $user = auth()->user();
        if ($user->open_deal) {
            $open = true;
            $transaction = Transaction::query()->where('id', $user->open_deal_id)->first()->toArray();
            $deposit = Deposit::query()->where('transaction_id', $transaction['id'])->first();
            $order = Order::query()->where('id', $transaction['order_id'])->first()->toArray();
            $cur_from = Currency::query()->where('id', $order['currency_from'])->first();
            $cur_to = Currency::query()->where('id', $order['currency_to'])->first();
            if ($cur_from->type == 'fiat' && $cur_to->type == 'fiat') {
                $type = 'fiat';
            } else if ($cur_from->type == 'crypto' && $cur_to->type == 'crypto') {
                $type = 'crypto';
            }

            else if($cur_from->type == 'crypto' && $cur_to->type == 'fiat')
            {
                $type = 'crypto_fiat';
            }

            else {
                $type = 'fiat_crypto';
            }
        } else {
            $open = false;
            $type = null;
            $order = null;
            $deposit = null;
            $transaction = null;
        }


        $data = [
            'open' => $open,
            'transaction' => $transaction,
            'order' => $order,
            'deposit' => $deposit,
            'type' => $type
        ];

        return response()->json($data);
    }

}
