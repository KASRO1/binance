<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetCurrencies;
use App\Http\Actions\User\Balance\Add;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transfer;

use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Transfer>
 */
class TransferResource extends ModelResource
{
    protected string $model = Transfer::class;

    protected string $title = 'Переводы';


    protected function afterCreated(Model $item): Model
    {
        $currency = Currency::query()->where('symbol', $item->currency)->first();
        $user = User::query()->where('id', $item->user_id)->first();
        (new Add())->run($currency->id, $item->amount, $user);
        return $item;
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        $users = User::query()->get()->pluck('email', 'id')->toArray();

        return [
            Block::make([
                ID::make()->sortable(),
                Select::make('Пользователь', 'user_id')->
                options($users)->
                sortable()->searchable(),
                Text::make('Сумма', 'amount')->sortable(),
                Text::make('Никнейм от кого перевод', 'username')->sortable(),
                Select::make('Валюта', 'currency')->options(Currency::query()->get()->pluck('symbol', 'symbol')->toArray())->sortable()->searchable(),

            ]),
        ];
    }

    /**
     * @param Transfer $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
