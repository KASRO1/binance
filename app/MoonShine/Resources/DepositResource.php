<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetCurrencies;
use App\Http\Actions\Currency\GetFiat;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deposit;

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
    protected function beforeUpdating(Model $item): Model
    {
        $transaction = Transaction::query()->where('id', $item->transaction_id)->first();
        if($item->status == 1){
            $transaction->status = 5;
        }
        elseif ($item->status == -1){
            $transaction->status = 6;
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
                Select::make('Статус', 'status')->options(['-1' => 'Closed', '0' => 'Waiting', '1' => 'Success'])->sortable(),
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
