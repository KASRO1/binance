<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\BalanceResource;
use App\MoonShine\Resources\CurrencyResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\PromoResource;
use App\MoonShine\Resources\SpreadResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;
use MoonShine\Contracts\Resources\ResourceContract;
use MoonShine\Menu\MenuElement;
use MoonShine\Pages\Page;
use Closure;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    /**
     * @return list<ResourceContract>
     */
    protected function resources(): array
    {
        return [];
    }

    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [];
    }

    /**
     * @return Closure|list<MenuElement>
     */
    protected function menu(): array
    {
        return [
            MenuGroup::make(static fn() => __('moonshine::ui.resource.system'), [
               MenuItem::make(
                   static fn() => __('moonshine::ui.resource.admins_title'),
                   new MoonShineUserResource()
               ),
               MenuItem::make(
                   static fn() => __('moonshine::ui.resource.role_title'),
                   new MoonShineUserRoleResource()
               ),
            ]),

            MenuItem::make(
                static fn() => "Пользователи",
                new UserResource()
            ),
            MenuItem::make(
                static fn() => "Балансы",
                new BalanceResource()
            ),
            MenuItem::make(
                static fn() => "Промокоды",
                new PromoResource()
            ),
            MenuGroup::make(static fn() => 'Валюты', [
                MenuItem::make(
                    static fn() => 'Валюты',
                    new CurrencyResource()
                ),
                MenuItem::make(
                    static fn() => 'Настройка спреда',
                    new SpreadResource()
                ),
            ]),
            MenuItem::make(
                static fn() => "Предложения P2P",
                new OrderResource()
            ),

        ];
    }

    /**
     * @return Closure|array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [

        ];
    }
}
