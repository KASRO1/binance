<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Http\Actions\Currency\GetCrypto;
use App\Http\Actions\Currency\GetCurrencies;
use App\Http\Actions\Currency\GetFiat;
use Illuminate\Database\Eloquent\Model;
use App\Models\Spread;

use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Spread>
 */
class SpreadResource extends ModelResource
{
    protected string $model = Spread::class;

    protected string $title = 'Спред';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Select::make("currency_from", 'currency_from')->options((new GetCurrencies())->run('options'))->sortable(),
                Text::class::make('Спред', 'spread')->sortable(),
                Checkbox::make('Активен ли', 'active')->sortable()->default(true)
            ]),
        ];
    }

    /**
     * @param Spread $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
