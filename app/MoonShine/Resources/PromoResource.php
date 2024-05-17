<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetFiat;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promo;

use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Promo>
 */
class PromoResource extends ModelResource
{
    protected string $model = Promo::class;

    protected string $title = 'Промокоды';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                Text::make('Промокод', 'code')->sortable(),
                Text::make('Бонус за депозит', 'deposit_bonus')->sortable(),
                Text::make('Описание', 'description')->sortable(),
                Select::make('Валюта', 'currency')->options((new GetFiat())->run('options')),
                ])
        ];
    }

    /**
     * @param Promo $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
