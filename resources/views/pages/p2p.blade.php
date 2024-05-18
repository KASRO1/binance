@extends('base')

@section('title', __('p2p.title'))
@section('content')

    <div class="py-2 px-6 flex-1 flex gap-10 flex-col">
        <div class="flex pt -5 flex-col gap-6">
            <h1 class="text-2xl">
                {{__('p2p.title')}}
            </h1>
            {{--            @if(\Illuminate\Support\Facades\Auth::check())--}}
            {{--                <div class="flex flex-col gap-2">--}}
            {{--                    <p class="text-sm font-medium text-gray">--}}
            {{--                        {{__('p2p.your_currency')}}--}}
            {{--                    </p>--}}

            {{--                    <div class="itc-select disable" id="select-1">--}}
            {{--                        <button type="button" class="itc-select__toggle" name="car"--}}
            {{--                                value="{{Auth::user()->main_currency}}" data-select="toggle"--}}
            {{--                                data-index="1">{{Auth::user()->main_currency}}</button>--}}
            {{--                        <div class="itc-select__dropdown">--}}
            {{--                            <ul class="itc-select__options">--}}
            {{--                                <li class="itc-select__option" data-select="option" data-value="usd" data-index="1">--}}
            {{--                                    {{Auth::user()->main_currency}}--}}
            {{--                                </li>--}}
            {{--                            </ul>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}

            {{--                </div>--}}
            {{--            @endif--}}
        </div>
        <div class="flex flex-col gap-3">
            <div class="flex flex-col gap-2">

                <form id="p2pForm" method="get" class="flex gap-2 items-center">
                    <div class="itc-select" id="select-2">
                        <button type="button" class="itc-select__toggle  h-10" name="currency_from"
                                value="{{$cur_from['symbol']}}" data-select="toggle"
                                data-index="{{$cur_from['id']}}">
                            {{$cur_from['symbol']}}
                        </button>
                        <div class="itc-select__dropdown">
                            <ul class="itc-select__options">
                                @foreach($currencies_from as $currency)
                                    <li class="itc-select__option" data-select="option"
                                        data-value="{{$currency['symbol']}}" data-index="{{$currency['id']}}">
                                        {{$currency['symbol']}}
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="itc-select" id="select-3">
                        <button type="button" class="itc-select__toggle  h-10" name="currency_to"
                                value="{{$cur_to['symbol']}}" data-select="toggle"
                                data-index="{{$cur_to['id']}}">
                            {{$cur_to['symbol']}}
                        </button>
                        <div class="itc-select__dropdown">
                            <ul class="itc-select__options">
                                @foreach($currencies as $currency)
                                    <li class="itc-select__option" data-select="option"
                                        data-value="{{$currency['symbol']}}" data-index="{{$currency['id']}}">
                                        {{$currency['symbol']}}
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <button type="submit" style="height: 80%"
                            class="px-4 rounded flex items-center  bg-yelow text-yelow2 ">
                        <svg width="16px" height="16px" viewBox="0 0 32 32" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="black" stroke="black">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"><title>arrow-right-circle</title>
                                <desc>Created with Sketch Beta.</desc>
                                <defs></defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                   sketch:type="MSPage">
                                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                       transform="translate(-310.000000, -1089.000000)" fill="#000000">
                                        <path
                                            d="M332.535,1105.88 L326.879,1111.54 C326.488,1111.93 325.855,1111.93 325.465,1111.54 C325.074,1111.15 325.074,1110.51 325.465,1110.12 L329.586,1106 L319,1106 C318.447,1106 318,1105.55 318,1105 C318,1104.45 318.447,1104 319,1104 L329.586,1104 L325.465,1099.88 C325.074,1099.49 325.074,1098.86 325.465,1098.46 C325.855,1098.07 326.488,1098.07 326.879,1098.46 L332.535,1104.12 C332.775,1104.36 332.85,1104.69 332.795,1105 C332.85,1105.31 332.775,1105.64 332.535,1105.88 L332.535,1105.88 Z M326,1089 C317.163,1089 310,1096.16 310,1105 C310,1113.84 317.163,1121 326,1121 C334.837,1121 342,1113.84 342,1105 C342,1096.16 334.837,1089 326,1089 L326,1089 Z"
                                            id="arrow-right-circle" sketch:type="MSShapeGroup"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </button>
                </form>
            </div>

            @if(Auth::check() && Auth::user()->limit_deals == 0 && $type === 'crypto')
                <div class="flex flex-col pt-7 gap-3">
                    <div class="h-24 items-center justify-center flex text-red">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.326 13.909l-1.429 1.417L12 13.429l-3.897 3.897-1.429-1.417 3.909-3.898-3.909-3.908 1.429-1.417L12 10.583l3.897-3.897 1.429 1.417-3.897 3.908 3.897 3.898z"
                                fill="currentColor"></path>
                        </svg>
                    </div>

                    <p class="text-white text-xl text-center">
                        You have exhausted your cryptocurrency transaction limit
                    </p>
                    <p class="text-gray2 text-sm text-center">
                        {{$error}}
                    </p>
                    <a href="{{route('p2p.sort.show:id:id', [$user->main_currency_arr['symbol'], $cur_to->symbol])}}"
                       class="flex items-center justify-center __btn bg-yelow">Exchange</a>
                </div>
            @elseif(count($orders) != 0)
                @foreach($orders as $order)
                    <div
                        class="{{$order['bestPrice'] ? 'border-yelow border rounded-xl relative py-3 pt-7 px-3 ' : ''}}  flex border-b border-gray4 py-3 flex-col gap-1">
                        @if($order['bestPrice'])
                            <div style="top: 0; left: 0; border-radius: 10px 0px 10px 0px "
                                 class="absolute text-xs px-5  bg-yelow_3 text-yelowп ">
                                Best price
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <div
                                class="flex items-center justify-center relative rounded-md text-center flex-none bg-gray4 text-white"
                                style="width: 24px; height: 24px; line-height: 24px;">
                                {{$order['username'][0]}}
                                <div class="border border-gray4 absolute right-0 bottom-0 rounded-full bg-green-300"
                                     style="width: 10px; height: 10px; max-height: 14px; max-width: 14px;"></div>
                            </div>
                            {{$order['username']}}
                            <svg class="bn-svg ml-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                 style="width: 18px; height: 18px;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M16.438 4.313L14.814 1.5 12 3.124 9.187 1.5 7.562 4.313H4.313v3.25L1.5 9.186 3.124 12 1.5 14.813l2.813 1.625v3.248h3.25L9.186 22.5 12 20.876l2.813 1.624 1.625-2.814h3.248v-3.248l2.814-1.624L20.876 12 22.5 9.187l-2.814-1.625V4.313h-3.248zm-.902 4.215l1.414 1.414-6.364 6.364L7.05 12.77l1.414-1.414 2.122 2.122 4.95-4.95z"
                                      fill="#F0B90B"></path>
                            </svg>
                        </div>
                        <div class="flex items-center font-normal text-xs text-gray gap-2">
                            {{$order['orders']}} {{__('p2p.orders')}}
                            <hr class="border-none bg-gray flex w-px h-min-[10px] mx-2 h-[10px]"/>
                            {{$order['completion']}} {{__('p2p.completion')}}
                        </div>
                        <div class="font-semibold">
                            {{$order['price']}} {{$order['currency_name']}}
                        </div>
                        <div class="flex items-center font-normal text-xs text-gray gap-2">
                            {{__('p2p.available')}}: {{$order['available'] }}
                        </div>
                        <div class="flex items-center font-normal text-xs text-gray gap-2">
                            {{__('p2p.limit')}}: {{$order['limit'] }}
                        </div>
                        <div
                            class=" flex pt-3 items-center {{!$order['AutoMode']  ? 'justify-end' : 'justify-between'}}">

                            @if($order['AutoMode'])
                                <div class="flex items-center text-xs gap-2">
                                    <div class="w-1 h-[10px] rounded bg-yelow2"></div>
                                    Auto mode
                                </div>

                            @endif
                            @if(Auth::check())
                                <div class="">
                                    <button onclick="showModalExchange(this, 100, {{$order['id']}})"
                                            class="bg-yelow text-black text-xs rounded-md px-4 py-[2px]">{{__('p2p.exchange')}}
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            @elseif(count($orders) == 0)
                <div class="flex flex-col pt-5 gap-3">
                    <div class="h-24 items-center justify-center flex text-red">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.326 13.909l-1.429 1.417L12 13.429l-3.897 3.897-1.429-1.417 3.909-3.898-3.909-3.908 1.429-1.417L12 10.583l3.897-3.897 1.429 1.417-3.897 3.908 3.897 3.898z"
                                fill="currentColor"></path>
                        </svg>
                    </div>

                    <p class="text-white text-xl text-center">
                        {{__('p2p.no_orders')}}
                    </p>
                    <p class="text-gray2 text-sm text-center">
                        {{__('p2p.no_orders_description')}}
                    </p>
                </div>

            @endif

        </div>
        <div class="flex px-4 py-4 border border-gray4 rounded-3xl flex-col gap-6">
            <div class="flex flex-col gap-[15px]">
                <h2 class="text-center font-semibold text-white">
                    {{__('p2p.title_description')}}
                </h2>
                <p class="text-white text-center text-xs font-light">
                    {{__('p2p.description')}}
                </p>
            </div>
        </div>
    </div>
    <section id="modalTrade" class="modalTrade hidden pb-10 pt-5 px-5">
        <form id="TradeForm" class="flex flex-1 h-full flex-col gap-5">
            <input class="hidden" value="" id="order_id">
            <input class="hidden" value="{{$open_order ? $open_order->id : null}}" id="transaction_id">
            <input class="hidden" value="{{$open_order ? $open_order->status : 1}}" id="status">
            <input class="hidden" value="{{$balance ? $balance['amount'] : null}}" id="balance">
            <input class="hidden" value="{{$open_order ? $open_order->amount : null}}" id="amount">
            <div class="flex flex-col">
                <div class="text-black pb-5 flex w-full justify-between">
                    <h2>{{__('p2p.exchange')}} <span id="currency">USDT</span></h2>
                    <div onclick="closeModalExchange()" class="close cursor-pointer h-5 w-5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-11ppfta">
                            <path
                                d="M6.697 4.575L4.575 6.697 9.88 12l-5.304 5.303 2.122 2.122L12 14.12l5.303 5.304 2.122-2.122L14.12 12l5.304-5.303-2.122-2.122L12 9.88 6.697 4.575z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex font-light gap-1 items-center text-sm text-gray">
                    {{__('p2p.price')}}
                    <span class="text-green font-medium" id="price">57.54 PHP</span>
                </div>
            </div>
            <div id="infoExchange" class="flex flex-col gap-3">
                <div class="flex font-normal text-sm items-center text-black gap-2">
                    <div
                        class="flex items-center justify-center relative rounded-md text-center flex-none bg-gray4 text-white"
                        style="width: 24px; height: 24px; line-height: 24px;">
                        <span id="avatar">财</span>
                        <div class="border border-gray4 absolute right-0 bottom-0 rounded-full bg-green-300"
                             style="width: 10px; height: 10px; max-height: 14px; max-width: 14px;"></div>
                    </div>
                    <span id="username">
                        CryptoJeffTrading
                    </span>

                    <svg class="bn-svg ml-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                         style="width: 18px; height: 18px;">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M16.438 4.313L14.814 1.5 12 3.124 9.187 1.5 7.562 4.313H4.313v3.25L1.5 9.186 3.124 12 1.5 14.813l2.813 1.625v3.248h3.25L9.186 22.5 12 20.876l2.813 1.624 1.625-2.814h3.248v-3.248l2.814-1.624L20.876 12 22.5 9.187l-2.814-1.625V4.313h-3.248zm-.902 4.215l1.414 1.414-6.364 6.364L7.05 12.77l1.414-1.414 2.122 2.122 4.95-4.95z"
                              fill="#F0B90B"></path>
                    </svg>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.orders')}}</p>
                    <p class="text-black" id="orders">98.60%</p>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.execution_method')}}</p>
                    <p class="text-green font-semibold" id="execution_method">{{__('p2p.automatic_mode')}}</p>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.completion')}}</p>
                    <p class="text-black"><span id="orders">703</span> {{__('p2p.orders')}}</p>
                </div>

                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.available')}}</p>
                    <p class="text-black" id="available">100.00 USDT</p>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.positive_feedback')}}</p>
                    <div class="text-black items-center flex gap-1">
                        <div class="text-gray">
                            <svg class="bn-svg text-iconNormal mr-3xs" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M8 9.723l3.444-3.391V3.01h.888a3.106 3.106 0 013.106 3.105v1.673H21v6.425a4.778 4.778 0 01-4.778 4.778H8V9.723zm-2-.038H3v9.306h3V9.685z"
                                      fill="currentColor"></path>
                            </svg>
                        </div>
                        99.25%
                    </div>
                </div>
                <p class="font-medium text-black">
                    {{__("p2p.payment_details")}}
                </p>
                {{--                <input name="password" placeholder="Your creditals" type="text" class="__input text-black mb-3" />--}}
                @if($type === 'crypto')
                    <div class="flex justify-between items-center">
                        <p class="font-light text-xs text-gray">
                            {{__('p2p.balance')}} <span class="font-medium" id="balance">
                            {{$balance ? $balance['amount'] : 0}} {{$cur_from['symbol']}}
                        </span>
                        </p>
                        <div class="flex gap-2">
                            <button onclick="selectProcentBalance(10)" type="button"
                                    class="bg-gray3 transition-all hover:bg-yelow hover:text-black text-white text-xs rounded-md px-4 py-[2px]">
                                10%
                            </button>
                            <button onclick="selectProcentBalance(50)" type="button"
                                    class="bg-gray3 transition-all hover:bg-yelow hover:text-black text-white text-xs rounded-md px-4 py-[2px]">
                                50%
                            </button>
                            <button onclick="selectProcentBalance(100)" type="button"
                                    class="bg-gray3 transition-all hover:bg-yelow hover:text-black text-white text-xs rounded-md px-4 py-[2px]">
                                MAX
                            </button>
                        </div>
                    </div>
                @endif
                <input name="amount" id="amount_el" placeholder="Amount" type="text" class="__input text-black mb-3"/>
                <button type="button" class="__btn bg-yelow nextStep">{{__('p2p.exchange')}}</button>
                <button type="button" onclick="closeModalExchange()"
                        class="__btn bg-red text-white">{{__('p2p.close')}}</button>
            </div>
            <div id="paymentExchange" class="hidden flex flex-col gap-3">
                <div class="flex font-normal text-sm items-center text-black gap-2">
                    <div
                        class="flex items-center justify-center relative rounded-md text-center flex-none bg-gray4 text-white"
                        style="width: 24px; height: 24px; line-height: 24px;">
                        <span id="avatar">财</span>
                        <div class="border border-gray4 absolute right-0 bottom-0 rounded-full bg-green-300"
                             style="width: 10px; height: 10px; max-height: 14px; max-width: 14px;"></div>
                    </div>
                    <span id="username">
                        CryptoJeffTrading
                    </span>

                    <svg class="bn-svg ml-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                         style="width: 18px; height: 18px;">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M16.438 4.313L14.814 1.5 12 3.124 9.187 1.5 7.562 4.313H4.313v3.25L1.5 9.186 3.124 12 1.5 14.813l2.813 1.625v3.248h3.25L9.186 22.5 12 20.876l2.813 1.624 1.625-2.814h3.248v-3.248l2.814-1.624L20.876 12 22.5 9.187l-2.814-1.625V4.313h-3.248zm-.902 4.215l1.414 1.414-6.364 6.364L7.05 12.77l1.414-1.414 2.122 2.122 4.95-4.95z"
                              fill="#F0B90B"></path>
                    </svg>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.orders')}}</p>
                    <p class="text-black" id="orders">98.60%</p>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.execution_method')}}</p>
                    <p class="text-green font-semibold" id="execution_method">{{__('p2p.automatic_mode')}}</p>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.completion')}}</p>
                    <p class="text-black"><span id="orders">703</span> {{__('p2p.orders')}}</p>
                </div>

                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.available')}}</p>
                    <p class="text-black" id="available">100.00 USDT</p>
                </div>
                <div class="flex font-light text-sm justify-between">
                    <p class="text-gray">{{__('p2p.positive_feedback')}}</p>
                    <div class="text-black items-center flex gap-1">
                        <div class="text-gray">
                            <svg class="bn-svg text-iconNormal mr-3xs" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M8 9.723l3.444-3.391V3.01h.888a3.106 3.106 0 013.106 3.105v1.673H21v6.425a4.778 4.778 0 01-4.778 4.778H8V9.723zm-2-.038H3v9.306h3V9.685z"
                                      fill="currentColor"></path>
                            </svg>
                        </div>
                        99.25%
                    </div>
                </div>
                <p class="font-medium text-black">
                    {{__("p2p.payment_details")}}
                </p>
                <div class="h-48 m-auto">
                    <img id="qr_code" class="h-48" src="./assets/img/qr.png" alt=""/>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-sm font-normal text-gray">
                        {{__('p2p.credentials')}}
                    </p>
                    <input id="credentials" disabled name="password" value="92984829284" type="text"
                           class="__input text-black mb-3"/>
                </div>
                @if($type === 'crypto_fiat')
                    <div class="flex flex-col gap-1">
                        <p class="text-sm font-normal text-gray">
                            {{__('p2p.commission')}}
                        </p>
                        <input id="commission" disabled name="password" value="4102$" type="text"
                               class="__input text-black mb-3"/>
                    </div>
                    <p class="text-xs font-normal text-gray">
                        {{__('p2p.description1')}}
                    </p>
                @endif
                <p class="text-xs font-normal text-gray">
                    {{__('p2p.description2')}}
                </p>
                <div class="flex gap-1 text-yelow2">
                    <div class="w-4 h-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-19x2nsy">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M12 21a9 9 0 100-18 9 9 0 000 18zM10.75 8.5V6h2.5v2.5h-2.5zm0 9.5v-7h2.5v7h-2.5z"
                                  fill="currentColor"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-normal">
                        {{__('p2p.description3')}}
                    </p>
                </div>

                <button type="button" class="__btn bg-yelow nextStep">{{__('p2p.i_paid')}}</button>
                <button type="button" onclick="backStep(1)"
                        class="__btn bg-gray2/30 text-black">{{__("p2p.back")}}</button>
            </div>
            <div id="documentUpload" class="flex hidden flex-col gap-3">
                <div class="flex justify-center items-center h-96">
                    <svg class="h-72 bn-emptyState-icon" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                        <path d="M84 28H64V8l20 20z" fill="#AEB4BC"></path>
                        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
                              d="M24 8h40v20h20v60H24V8zm10 30h40v4H34v-4zm40 8H34v4h40v-4zm-40 8h40v4H34v-4z"
                              fill="#AEB4BC"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M22.137 64.105c7.828 5.781 18.916 5.127 26.005-1.963 7.81-7.81 7.81-20.474 0-28.284-7.81-7.81-20.474-7.81-28.284 0-7.09 7.09-7.744 18.177-1.964 26.005l-14.3 14.3 4.243 4.243 14.3-14.3zM43.9 57.9c-5.467 5.468-14.331 5.468-19.799 0-5.467-5.467-5.467-14.331 0-19.799 5.468-5.467 14.332-5.467 19.8 0 5.467 5.468 5.467 14.332 0 19.8z"
                              fill="#AEB4BC"></path>
                    </svg>
                </div>
                <p class="text-sm font-normal text-gray">
                    {{__('p2p.upload_receipt')}}
                </p>
                <label class="__btn flex justify-center cursor-pointer items-center bg-green text-white" for="receipt">
                    {{__('p2p.select_image')}}
                </label>
                <input name="document" id="receipt" type="file" accept="image/*"
                       class="__input hidden text-black mb-3"/>
                <button type="button" disabled id="file_input"
                        class="__btn bg-yelow nextStep">{{__('p2p.next')}}</button>
                <button type="button" onclick="backStep(2)"
                        class="__btn bg-gray2/30 text-black">{{__('p2p.back')}}</button>
            </div>
            <div id="loadingExchange" class="hidden flex justify-between h-full flex-col">
                <div class="flex flex-1 h-full justify-center flex-col gap-3">
                    <div class="bn-spinner__nezha">
                        <div class="nezha-line" style="animation-delay: 50ms;"></div>
                        <div class="nezha-line" style="animation-delay: 100ms;"></div>
                        <div class="nezha-line" style="animation-delay: 150ms;"></div>
                        <div class="nezha-line" style="animation-delay: 200ms;"></div>
                    </div>
                    <p class="text-center font-medium text-black">
                        {{__('p2p.status_waiting')}}
                    </p>
                </div>

                {{--                <button type="button" onclick="closeModalExchange()" class="__btn bg-gray2/30 text-black">{{__("p2p.back")}}</button>--}}
            </div>
            <div id="successExchange" class="hidden flex justify-between h-full flex-col">
                <div class=" flex flex-1 h-full justify-center flex-col gap-3">
                    <div class="h-24 items-center justify-center flex text-green">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-24">
                            <path
                                d="M19.068 4.932A9.917 9.917 0 0012 2a9.917 9.917 0 00-7.068 2.932A9.917 9.917 0 002 11.988C2 17.521 6.479 22 12 22a9.917 9.917 0 007.068-2.932A9.992 9.992 0 0022 11.988a9.918 9.918 0 00-2.932-7.056zm-8.912 12.234L5.71 12.71l1.42-1.42 3.025 3.024 6.7-6.713 1.421 1.42-8.121 8.145z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                    <p class="text-center font-medium text-black">
                        {{__('p2p.status_success')}}
                    </p>
                </div>
                <button type="button" onclick="closeModalExchange()"
                        class="__btn bg-gray2/30 text-black">{{__("p2p.close")}}</button>
            </div>
            <div id="errorExchange" class="hidden flex justify-between h-full flex-col">

                <div class=" flex flex-1 h-full justify-center flex-col gap-3">
                    <div class="h-24 items-center justify-center flex text-red">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5.326 13.909l-1.429 1.417L12 13.429l-3.897 3.897-1.429-1.417 3.909-3.898-3.909-3.908 1.429-1.417L12 10.583l3.897-3.897 1.429 1.417-3.897 3.908 3.897 3.898z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                    <p class="text-center font-medium text-black">
                        {{__('p2p.status_error')}}
                    </p>
                </div>
                <button type="button" onclick="closeModalExchange()"
                        class="__btn bg-gray2/30 text-black">{{__("p2p.close")}}</button>
            </div>
        </form>
    </section>

@endsection


@section("script")
    <script>
        const select2 = new ItcCustomSelect(document.getElementById('select-2'));
        const select3 = new ItcCustomSelect(document.getElementById('select-3'));
        @if(Auth::user() &&  Auth::user()->open_deal)
        let step = {{$open_order->status}};

        @else
        let step = 1;

        @endif
        function updateData(order_id) {
            axios.get('/order/get/' + order_id)
                .then(function (response) {
                    let order = response.data;

                    document.querySelectorAll('#order_id').forEach(
                        (el) => {
                            el.value = order.id;
                        }
                    );

                    document.querySelectorAll('#status').forEach(
                        (el) => {
                            el.value = order.status;
                            document.getElementById('status').value = order.status;
                            step = order.status;
                            changeStatusTransaction(order.status)
                        }
                    );

                    document.querySelectorAll('#price').forEach(
                        (el) => {
                            el.innerHTML = order.price;
                        }
                    );
                    document.querySelectorAll('#username').forEach(
                        (el) => {
                            el.innerHTML = order.username;
                        }
                    );
                    document.querySelectorAll('#avatar').forEach(
                        (el) => {
                            el.innerHTML = order.username[0]
                        }
                    )
                    document.querySelectorAll('#orders').forEach(
                        (el) => {
                            el.innerHTML = order.orders;
                        }
                    );
                    document.querySelectorAll('#execution_method').forEach(
                        (el) => {
                            el.innerHTML = order.AutoMode ? 'Auto mode' : 'Manual mode';
                        }
                    );
                    document.querySelectorAll('#available').forEach(
                        (el) => {
                            el.innerHTML = order.available + ' ' + order.currency_name;

                        }
                    );
                    document.querySelectorAll('#balance').forEach(
                        (el) => {
                            el.innerHTML = order.balance + ' ' + order.currency_name;

                        }
                    );
                    document.querySelectorAll('#qr_code').forEach(
                        (el) => {
                            el.src = '/storage/' + order.qr_code;
                        }
                    )
                    document.querySelectorAll('#credentials').forEach(
                        (el) => {
                            el.value = order.сredentials;
                        }
                    );
                    // document.getElementById('commission').value = order.commission;
                })
                .catch(function (error) {
                    console.log(error);
                });


        }


        const nextStep = document.querySelectorAll('.nextStep');


        function createTransaction(step) {
            console.log('При создани' + step)
            axios.post('/transaction/create', {
                order_id: document.getElementById('order_id').value,
                amount: document.getElementsByName('amount')[0].value,
                status: step,
            })
                .then(function (response) {
                    const transaction_id = document.getElementById('transaction_id');
                    transaction_id.value = response.data.id;
                    showStep(step);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function changeStatusTransaction(step) {
            console.log(step)
            axios.post('{{route('transaction.change')}}', {
                order_id: document.getElementById('order_id').value,
                transaction_id: document.getElementById('transaction_id').value,
                status: step,
            })
                .then(function (response) {
                    showStep(step);

                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function backStep(step_func) {
            changeStatusTransaction(step_func)
            step = step_func
        }

        function showStep(step) {
            hiddenAllStep();
            if (step == 1) {
                document.getElementById('infoExchange').classList.remove('hidden');
            } else if (step == 2) {
                document.getElementById('paymentExchange').classList.remove('hidden');
            } else if (step == 3) {
                document.getElementById('documentUpload').classList.remove('hidden');
            } else if (step == 4) {
                document.getElementById('loadingExchange').classList.remove('hidden');
            } else if (step == 5) {
                document.getElementById('successExchange').classList.remove('hidden');
            } else if (step == 6) {
                document.getElementById('errorExchange').classList.remove('hidden');
            }
        }

        nextStep.forEach((el) => {
            el.addEventListener('click', () => {
                step++;
                console.log(step)

                const status = document.getElementById('status');
                status.value = step;
                el.innerHTML = `<div class="bn-spinner__nezha"><div class="nezha-line" style="animation-delay: 50ms;"></div><div class="nezha-line" style="animation-delay: 100ms;"></div><div class="nezha-line" style="animation-delay: 150ms;"></div><div class="nezha-line" style="animation-delay: 200ms;"></div></div>`;
                @if($type == 'crypto')
                if (step == 1) {
                    createTransaction(4);
                    setTimeout(() => {
                        changeStatusTransaction(5)
                    }, 5000)
                }
                @elseif($type == 'fiat_crypto' || $type == 'crypto_fiat')
                if (step == 1) {
                    createTransaction(2);
                } else {
                    changeStatusTransaction(step);
                }
                @endif
                updateData(document.getElementById('order_id').value)

                el.innerHTML = `Next`;

            });
        });
        const p2pForm = document.getElementById('p2pForm');
        p2pForm.addEventListener('submit', (e) => {
            e.preventDefault();
            window.location.href = '/p2p/' + select2.value + '/' + select3.value;
        });


        function selectProcentBalance(procent) {
            let balance = document.getElementById('balance').value;
            let amount = balance * procent / 100;
            document.getElementsByName('amount')[0].value = amount;
        }


        @if(Auth::user() &&  Auth::user()->open_deal)
        showModalExchange("", 100, {{$open_order->order_id }}, {{$open_order->status}})
        changeStatusTransaction({{$open_order->status}})
        @if($type === 'crypto' && $open_order->status == 4)
        changeStatusTransaction(5)
        @endif
        const elements = document.querySelectorAll('.close');
        const elements_modal = document.querySelectorAll('.close_modal');
        elements_modal.forEach((el) => {
            el.removeAttribute('onclick')
        });
        elements.forEach((el) => {
            el.classList.add('hidden');
        });
        @endif


        const receipt = document.getElementById('receipt')
        const file_input = document.getElementById('file_input')
        receipt.addEventListener('change', (e) => {
            file_input.disabled = false;
            file_input.setAttribute('type', 'submit')
        })
        const TradeForm = document.getElementById('TradeForm')
        TradeForm.addEventListener('submit', (e) => {
            e.preventDefault()
            const formData = new FormData(TradeForm)
            formData.append('currency', {{$cur_from['id']}})
            formData.append('amount', document.getElementById('amount_el').value)
            formData.append('transaction_id', document.getElementById('transaction_id').value)
            axios.post('/deposit/create', formData)
                .then(function (response) {
                    changeStatusTransaction(4)
                })
                .catch(function (error) {
                    console.log(error);
                });
        })
        setInterval(() => {
            updateData(document.getElementById('order_id').value)
        }, 10000)

    </script>
@endsection
