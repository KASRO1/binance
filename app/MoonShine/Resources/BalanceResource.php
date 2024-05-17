<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetCurrencies;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Balance;

use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Balance>
 */
class BalanceResource extends ModelResource
{
    protected string $model = Balance::class;

    protected string $title = 'Балансы';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                Select::make('Валюта', 'currency')->options((new GetCurrencies())->run('options'))->sortable(),
                Text::make('Сумма', 'amount')->sortable(),
                Select::make('Пользователь', 'user_id', function (Balance $balance){
                    $user = User::query()->find($balance->user_id);
                    return $user->email;
                })->options(User::all()->pluck('email', 'id')->toArray())->sortable(),

            ]),
        ];
    }

    /**
     * @param Balance $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
