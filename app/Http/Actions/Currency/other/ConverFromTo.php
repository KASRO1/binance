<?php

namespace App\Http\Actions\Currency\other;

use App\Models\Currency;

class ConverFromTo
{

    public function run($fromCurrencyId, $toCurrencyId, $amount)
    {
        $fromCurrency = Currency::query()->where('id', $fromCurrencyId)->first();
        $toCurrency = Currency::query()->where('id', $toCurrencyId)->first();

        if (!$fromCurrency || !$toCurrency) {
            throw new \Exception('Currency not found');
        }

        $amountInBaseCurrency = $amount * $fromCurrency->course;
        $convertedAmount = $amount * $fromCurrency->course / $toCurrency->course;
        return $convertedAmount;
    }
}
