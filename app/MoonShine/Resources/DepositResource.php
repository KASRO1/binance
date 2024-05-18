<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetCurrencies;
use App\Http\Actions\Currency\GetFiat;
use App\Http\Actions\User\Balance\Add;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deposit;

use Illuminate\Support\Facades\Auth;
use MoonShine\Fields\Image;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Deposit>
 */
class DepositResource extends ModelResource
{
    protected string $model = Deposit::class;

    protected string $title = 'Депозиты';
    protected function afterUpdated(Model $item): Model
    {
        $user = Auth::user();
        $transaction = Transaction::query()->where('id', $item->transaction_id)->first();
        $order = Order::query()->where('id',$transaction->order_id)->first();
        $currency_to = Currency::query()->where('id', $order->currency_to)->first();
        if($transaction->status == 4){
            (new Add())->run($item->currency_from, $transaction->amount);
               $user->open_deal = 0;
                $user->open_deal_id = null;
                if($currency_to && $currency_to->spending_limit){
                    $user->limit_deals -= 1;
                }
            $transaction->balance_already_added = 1;
        }
        if($item->status == 2){
            $transaction->status = 5;
               $user->open_deal = 0;
                $user->open_deal_id = null;
                if($currency_to && $currency_to->spending_limit){
                    $user->limit_deals -= 1;
                }
        }
        elseif ($item->status == 0){
            $transaction->status = 6;
               $user->open_deal = 0;
                $user->open_deal_id = null;
                if($currency_to && $currency_to->spending_limit){
                    $user->limit_deals -= 1;
                }
        }
        else{
            $transaction->status = 4;
        }
        $transaction->save();
        return $item;
    }
    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Select::make('Пользователь', 'user_id', function (Balance $balance){
                    $user = User::query()->find($balance->user_id);
                    return $user->email;
                })->options(User::all()->pluck('email', 'id')->toArray())->sortable(),
                Text::make('Сумма', 'amount')->sortable(),
                Image::make('Скриншот оплаты', 'screenshot'),
                Select::make('Валюта', 'currency')->options((new GetFiat())->run('options'))->sortable(),
                Select::make('Статус', 'status')->options(['Closed', 'Waiting', 'Success'])->sortable(),
            ]),
        ];
    }

    /**
     * @param Deposit $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
