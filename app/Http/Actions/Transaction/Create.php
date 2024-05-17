<?php

namespace App\Http\Actions\Transaction;

use App\Models\Order;
use App\Models\Transaction;

class Create
{
    public function run($user, $order, $amount, $status)
    {
        $user->open_deal = true;
        $user->open_deal_id = $order->id;
        $user->save();
        return Transaction::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'amount' => $amount,
            'status' => $status
        ]);
    }
}
