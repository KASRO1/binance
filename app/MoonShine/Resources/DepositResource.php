<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Bonus\Get;
use App\Http\Actions\Currency\GetCurrencies;
use App\Http\Actions\Currency\GetFiat;
use App\Http\Actions\Currency\other\ConverFromTo;
use App\Http\Actions\Currency\other\ConvertToMainCur;
use App\Http\Actions\User\Balance\Add;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deposit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $transaction = Transaction::query()->where('id', $item->transaction_id)->first();
        $order = Order::query()->where('id',$transaction->order_id)->first();
        $user = User::query()->where('id', $transaction->user_id)->first();
        $bonus = $transaction->amount / 100 * (new Get())->run($user);
        $currency_to = Currency::query()->where('id', $order->currency_to)->first();
        $currency_from = Currency::query()->where('id', $order->currency_from)->first();
        $amount = $order->spread == 0 ? (new ConverFromTo())->run($order->currency_from, $order->currency_to, $transaction->amount, $user) : (new ConverFromTo())->run($order->currency_from, $order->currency_to, $transaction->amount, $user) * $order->spread;
        if($item->status == 2){
            (new Add())->run($order->currency_to, $amount, $user);
            $transaction->status = 5;
            $user->limit_deals += 3;
            $transaction->balance_already_added = 1;
            $transaction->save();
            $user->save();
        }
        elseif ($item->status == 0){
            $transaction->status = 6;
        }
        else{
            $transaction->status = 4;
        }
        $transaction->save();
        $user->save();
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
