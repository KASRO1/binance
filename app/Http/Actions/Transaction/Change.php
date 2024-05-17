<?php

namespace App\Http\Actions\Transaction;

class Change
{
    public function run($status, $transaction)
    {
        $transaction->status = $status;
        $transaction->save();
        return $transaction;
    }
}
