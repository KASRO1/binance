<?php

namespace App\Http\Actions\Deposit;

use App\Http\Requests\DepositRequest;
use App\Models\Deposit;

class Create
{
    public function run($request)
    {

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('documents', 'public');
        }
        return Deposit::query()->create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'screenshot' => $path,
            'currency' => $request->currency,
            'transaction_id' => $request->transaction_id
        ]);
    }
}
