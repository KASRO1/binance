<?php

namespace App\Http\Controllers;

use App\Http\Actions\Currency\GetCourse;
use App\Http\Actions\Currency\GetCrypto;
use App\Http\Actions\Currency\GetCurrencies;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Spread;
use App\Models\Transaction;
use App\MoonShine\Resources\SpreadResource;
use Illuminate\Http\Request;

class p2pController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::query()->get()->toArray();
        foreach ($orders as $key => $order) {
            $price_cur = Currency::query()->where('id', $order['currency_from'])->first();
            $price = (new GetCourse())->run($order['currency_to']);
            $orders[$key]['price'] = number_format($price, 2, '.', '');
            $orders[$key]['currency_name'] = $price_cur->symbol;
        }

        $currencies = (new GetCrypto())->run();
        if ($user) {
            $main_currency = Currency::query()->where('symbol', $user->main_currency)->first()->toArray();
            $usdt = Currency::query()->where('symbol', 'USDT')->first() ? Currency::query()->where('symbol', 'USDT')->first()->toArray() : $currencies[0];
            return redirect('/p2p/' . $main_currency['symbol'] . '/' . $usdt['symbol']);
        }

        return redirect('/p2p/' . $currencies[0]['symbol'] . '/' . $currencies[1]['symbol']);
    }

    public function sort(Request $request)
    {
        $currency_from = $request->input('currency_from');
        $currency_to = $request->input('currency_to');
        return redirect('p2p.sort.show:' . $currency_from . ':' . $currency_to);
    }

    public function show_sort($cur_from, $cur_to)
    {
        $user = auth()->user();
        $cur_to = Currency::query()->where('symbol', $cur_to)->first();
        $cur_from = Currency::query()->where('symbol', $cur_from)->first();
        $orders = Order::query()
            ->orderByRaw("
        CASE
            WHEN autoMode = 1 AND bestPrice = 1 THEN 0
            WHEN bestPrice = 1 THEN 1
            WHEN autoMode = 1 THEN 2
            ELSE 3
        END
    ")
            ->where('currency_from', $cur_from->id)
            ->where('currency_to', $cur_to->id)
            ->get()
            ->toArray();


        if ($user && $user->open_deal) {
            $open_order = Transaction::query()->where('id', $user->open_deal_id)->first();
        } else {
            $open_order = null;
        }

        foreach ($orders as $key => $order) {
            $price_cur = Currency::query()->where('id', $order['currency_from'])->first();
            $price_from = (new GetCourse())->run($order['currency_to']);
            $price = (new GetCourse())->run($order['currency_from']);
            $price_cur_from_to_cur_to = $price_from / $price;
            if ($order['bestPrice']) {
                $orders[$key]['price'] = number_format($price_cur_from_to_cur_to, 5, '.', '');
            } else {
                $price_cur_from_to_cur_to = $price_cur_from_to_cur_to + ($price_cur_from_to_cur_to / 100 * 5);
                $orders[$key]['price'] = number_format($price_cur_from_to_cur_to, 5, '.', '');
            }

            $orders[$key]['currency_name'] = $price_cur->symbol;
            $orders[$key]['currency_to_name'] = $price_cur->symbol;
        }


        $balance = Balance::query()->where('currency', $cur_from->id)->first();
        $balance_to_main_cur = 0;
        $currencies_from = (new GetCrypto())->run();
        if ($user) {
            $main_currency = Currency::query()->where('symbol', $user->main_currency)->first()->toArray();
            $user->main_currency_arr = $main_currency;
            $currencies_from[] = $main_currency;

            if (!$balance) {
                $balance = 0;
            } else {
                $balance_to_main_cur = $balance->amount * $cur_from->course * $main_currency['course'];
            }
        }

        if($user->limit_deals == 0)
        {
            $error = $this->checkLimits($user->id);
        }
        else
        {
            $error = null;
        }


        $currencies_to = (new GetCurrencies())->run();

        if ($cur_from->type == 'fiat' && $cur_to->type == 'fiat') {
            $type = 'fiat';
        } else if ($cur_from->type == 'crypto' && $cur_to->type == 'crypto') {
            $type = 'crypto';
        } else if ($cur_from->type == 'crypto' && $cur_to->type == 'fiat') {
            $type = 'crypto_fiat';
        } else {
            $type = 'fiat_crypto';
        }
        return view('pages.p2p', ['error' => $error, 'orders' => $orders, 'user' => $user, 'currencies' => $currencies_to, 'currencies_from' => $currencies_from, 'balance' => $balance, 'cur_from' => $cur_from, 'cur_to' => $cur_to, 'type' => $type, 'open_order' => $open_order, 'balance_to_main_cur' => $balance_to_main_cur,]);
    }

    public function checkLimits($userId)
    {
        $deposits = Deposit::where('user_id', $userId)->where('status', 2)->get();
        $firstDeposit = $deposits->first();
        if ($firstDeposit == null) {
            return false;
        }


        $transactions = Transaction::where('user_id', $userId)->where('status', 5)->get();

        $completedTransaction = $transactions->count();
        $limitMultiplier = 0;
        if ($completedTransaction % 3 == 0) {
            switch ($completedTransaction / 3) {
                case 1:
                    $limitMultiplier = 5;
                    break;
                case 2:
                    $limitMultiplier = 10;
                    break;
                case 3:
                    $limitMultiplier = 20;
                    break;
                case 4:
                    $limitMultiplier = 40;
                    break;
                case 5:
                    $limitMultiplier = 80;
                    break;
            }
        }

        $limit = $firstDeposit->amount * $limitMultiplier;
        $currency = $firstDeposit->currency;
        $currency = Currency::query()->where('id', $currency)->first()->symbol;
        return ['message' => "To continue changing currencies, add {$limit} {$currency} to your account", 'limit' => $limit, 'currency' => $currency];



    }
}
