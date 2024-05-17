<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;

use MoonShine\Components\Boolean;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Number;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Currency>
 */
class CurrencyResource extends ModelResource
{
    protected string $model = Currency::class;

    protected string $title = 'Валюты';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                Text::make('Короткое название', 'symbol')->sortable()->disabled(),
                Text::make('Полное название', 'name')->sortable()->hideOnIndex(),
                Text::make('Курс', 'course')->sortable(),
                Select::make('Тип', 'type')->options(['fiat' => 'fiat', 'crypto' => 'crypto'])->sortable(),
                Checkbox::make('Списывает лимит сделок', 'spending_limit')->sortable(),
            ]),
        ];
    }

    /**
     * @param Currency $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
