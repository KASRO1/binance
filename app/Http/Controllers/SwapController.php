<?php

namespace App\Http\Controllers;

use App\Http\Actions\Currency\GetCourse;
use App\Http\Actions\Currency\GetCrypto;
use App\Http\Actions\Currency\GetFiat;
use App\Http\Requests\SwapRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Actions\User\Balance\Get;
use App\Http\Actions\User\Balance\Remove;
use App\Http\Actions\User\Balance\Add;


class SwapController extends Controller
{
    public function index()
    {
        $currency_fiat = (new GetFiat())->run();
        $currency_crypto = (new GetCrypto())->run();
        return view('pages.swap', compact('currency_fiat', 'currency_crypto'));
    }

    public function swap(SwapRequest $request)
    {
        $amount_from = $request->input('amount_from');
        $currency_from = $request->input('currency_from');
        $currency_to = $request->input('currency_to');

        $currency_from = Currency::query()->where('id', $currency_from)->first();
        $currency_to = Currency::query()->where('id', $currency_to)->first();
        $balance = (new Get())->run($currency_from->id);
        $course_from = (new GetCourse())->run($currency_from->id);
        $course_to = (new GetCourse())->run($currency_to->id);
        if ($balance < $amount_from) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient funds, please top up your balance'
            ], 400);
        }
        $amount_to = $amount_from * $course_from / $course_to;
        (new Remove())->run($currency_from->id, $amount_from);
        (new Add())->run($currency_to->id, $amount_to);

        return response()->json([
            'success' => true,
            'message' => 'Swap success'
        ]);
    }

    public function data(SwapRequest $request)
    {
        $amount_from = $request->input('amount_from');
        $currency_from = $request->input('currency_from');
        $currency_to = $request->input('currency_to');

        $currency_from = Currency::query()->where('id', $currency_from)->first();
        $currency_to = Currency::query()->where('id', $currency_to)->first();
        $balance = (new Get())->run($currency_from->id);

        $course_from = (new GetCourse())->run($currency_from->id);
        $course_to = (new GetCourse())->run($currency_to->id);

        $amount_to = number_format($amount_from * $course_from / $course_to, 4, '.', '');
        $course = number_format(1 * $course_from / $course_to, 4);


        return response()->json([
            'success' => true,
            'amount_to' => $amount_to,
            'balance' => $balance,
            'course_from' => $course,
            'currency_from' => $currency_from->symbol,
            'currency_to' => $currency_to->symbol,
        ]);
    }
}
