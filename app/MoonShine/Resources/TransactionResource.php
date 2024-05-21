<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetCurrencies;
use App\Models\Order;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Transaction>
 */
class TransactionResource extends ModelResource
{
    protected string $model = Transaction::class;
    protected string $title = 'Транзакции';

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
                Select::make('Статус', 'status')->options([
                    '1' => 'На странице ввода суммы',
                    '2' => 'На странице реквизитов',
                    '3' => 'На странице добавления скриншота',
                    '4' => 'На странице ожидания подтверждения',
                    '5' => 'На странице успешной оплаты',
                    '6' => 'На странице отмены оплаты',
                ])->hideOnAll()->showOnIndex()->sortable(),
                Text::make('Сумма', 'amount')->sortable(),
                Text::make('Никнейм от кого перевод', 'username')->hideOnAll()->showOnCreate()->sortable(),
            ]),
        ];
    }

    /**
     * @param Transaction $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
