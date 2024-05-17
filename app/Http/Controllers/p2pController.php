<?php

namespace App\Http\Controllers;

use App\Http\Actions\Currency\GetCourse;
use App\Http\Actions\Currency\GetCrypto;
use App\Http\Actions\Currency\GetCurrencies;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Spread;
use App\Models\Transaction;
use App\MoonShine\Resources\SpreadResource;
use Illuminate\Http\Request;

class p2pController extends Controller
{
    public function index()
    {
        $orders = Order::query()->get()->toArray();
        foreach ($orders as $key => $order) {
            $price_cur = Currency::query()->where('id', $order['currency_from'])->first();
            $price = (new GetCourse())->run($order['currency_from']);
            $orders[$key]['price'] = number_format($price, 2, '.', '');
            $orders[$key]['currency_name'] = $price_cur->symbol;
        }

        $currencies = (new GetCrypto())->run();
        return redirect('/p2p/' . $currencies[0]['symbol'] . '/' . $currencies[1]['symbol']);
//        return view('pages.p2p', ['orders' => $orders, 'currencies' => $currencies]);
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
        $orders = Order::query()->where('currency_from', $cur_from->id)->where('currency_to', $cur_to->id)->get()->toArray();
        if($user && $user->open_deal){
            $open_order = Transaction::query()->where('id', $user->open_deal_id)->first();
        } else {
            $open_order = null;
        }
        foreach ($orders as $key => $order) {
            $price_cur = Currency::query()->where('id', $order['currency_from'])->first();
            $price = (new GetCourse())->run($order['currency_from']);
            $orders[$key]['price'] = number_format($price, 2, '.', '');
            $orders[$key]['currency_name'] = $price_cur->symbol;
        }
        $balance = Balance::query()->where('currency', $cur_from->id)->first();
        $currencies = (new GetCrypto())->run();


        if($cur_from->type == 'fiat' && $cur_to->type == 'fiat') {
            $type = 'fiat';
        } else if ($cur_from->type == 'crypto' && $cur_to->type == 'crypto') {
            $type = 'crypto';
        } else {
            $type = 'fiat_crypto';
        }


        return view('pages.p2p', ['orders' => $orders, 'currencies' => $currencies, 'balance' => $balance, 'cur_from' => $cur_from, 'cur_to' => $cur_to, 'type' => $type, 'open_order' => $open_order]);
    }
}
