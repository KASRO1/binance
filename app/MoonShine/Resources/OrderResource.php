<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetCurrencies;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Image;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Order>
 */
class OrderResource extends ModelResource
{
    protected string $model = Order::class;

    protected string $title = 'Предложения P2P';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Имя пользователя', 'username')->sortable(),
                Text::make('Кол-во сделок', 'orders')->sortable(),
                Text::make('Завершено сделок', 'completion')->sortable(),
                Text::make('Доступно $', 'available')->sortable(),
                Text::make('Доступные лимиты', 'limit')->sortable(),
                Image::make('QR', 'qr_code')->sortable(),
                Text::make('Отзывов', 'feedback')->sortable(),
                Text::make('Комиссия', 'commission')->sortable(),
                Text::make('Платежные реквизиты', 'сredentials')->sortable(),
                Select::make('Валюта от', 'currency_from')->options((new GetCurrencies())->run('options'))->sortable(),
                Select::make('Валюта в', 'currency_to')->options((new GetCurrencies())->run('options'))->sortable(),
                Checkbox::make('Лучшая цена', 'bestPrice')->sortable(),
                Checkbox::make('Автоматический режим', 'AutoMode')->sortable(),



            ]),
        ];
    }

    /**
     * @param Order $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
