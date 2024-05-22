@extends('base')

@section('title', 'Главная страница')
@php

    function formatNumber($num) {
        $isNegative = $num < 0; // Проверяем, отрицательное ли число
        $numStr = number_format(abs($num), 20, '.', ''); // Преобразуем число в строку с 20 знаками после запятой

        list($integer, $fraction) = explode('.', $numStr); // Разделяем число на целую и дробную части

        if ($integer !== '0') { // У числа есть ненулевая целая часть
            if ($fraction) {
                // Обрезаем дробную часть до первых двух цифр
                return ($isNegative ? '-' : '') . $integer . '.' . substr($fraction, 0, 2);
            }
            return ($isNegative ? '-' : '') . $integer;
        } else {
            // Целая часть равна 0, работаем с дробной частью
            if ($fraction) {
                $nonzeroIndex = strcspn($fraction, '123456789'); // Находим первый значащий символ
                // Берем две значимые цифры после всех нулей
                $significantDigits = substr($fraction, $nonzeroIndex, 2);
                return ($isNegative ? '-' : '') . '0.' . str_repeat('0', $nonzeroIndex) . $significantDigits;
            }
            return ($isNegative ? '-' : '') . '0';
        }
    }
@endphp
@section('content')
    <div class="flex pt-5 flex-col gap-6">
        <div class="flex pt-5 flex-col gap-10">
            <div class="flex gap-3">
                <div class="relative w-12 h-12 text-lg flex items-center justify-center rounded-full " style="background-color: {{$user->color}}">
                    {{$user->email[0]}}
                    <div class="w-4 h-4 bg-green transition-all rounded-full absolute right-0 bottom-0 text-gray3 ">

                    </div>
                </div>
                <div class="flex flex-col flex-1 gap-4 ">
                    <div class="flex items-center gap-2">
                        {{$user->email}}
                    </div>
                    <div class="flex font-normal text-sm flex-col gap-1">

                        <p class="text-gray">
                            Joined on {{(new \Carbon\Carbon())->parse($user->created_at)->format('Y-m-d')}}
                        </p>
                    </div>

                    <div class="flex gap-3 flex-col">
                        <div class="flex font-light text-sm justify-between">
                            <p class="text-gray">Your assets</p>
                            <p class="text-white">{{(new \App\Http\Actions\User\Balance\GetFullBalance())->run($user)}} $</p>
                        </div>

{{--                        <div class="flex font-light text-sm justify-between">--}}
{{--                            <p class="text-gray">Profit</p>--}}
{{--                            <p class="text-green font-semibold">+600 bs(60$)</p>--}}
{{--                        </div>--}}
{{--                        <div class="flex font-light text-sm justify-between">--}}
{{--                            <p class="text-gray">Deposit</p>--}}
{{--                            <p class="text-white">400 bs</p>--}}
{{--                        </div>--}}
                        <div class="flex font-light text-sm justify-between">
                            <p class="text-gray">{{__('profile.deposit_bonus')}}</p>
                            <p class="text-white">{{$promo_discount}} %</p>
                        </div>
                        <div class="flex font-light text-sm justify-between">
                            <p class="text-gray">Limit deals</p>
                            <p class="text-white">{{$user->limit_deals}}</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex flex-col gap-3">
                <p class="text-gray2 text-lg text-center">
                    History
                </p>
            </div>
            <div class="flex mb-10 flex-col gap-2">
                @foreach($transfers as $transfer)
                    <div class="border justify-between flex gap-2 items-center p-5 border-gray3 rounded-xl">
                        <div class="flex items-center gap-2">
                            <div class="relative w-12 h-12 text-lg flex items-center justify-center rounded-full " style="background-color: {{$transfer['color']}}">
                                {{$transfer['username'][0]}}

                            </div>
                            {{$transfer['username']}}
                        </div>
                        <p class="text-green">
                            + {{formatNumber($transfer['amount']) . ' ' . $transfer['currency']}}
                        </p>
                    </div>
                @endforeach
            </div>



        </div>

    </div>

@endsection


@section("script")
    <script>
        const nextStep = document.getElementById('nextStep');
        const enter_email = document.getElementById('enter_email');
        const enter_password = document.getElementById('enter_password');
        const array = {
            element: nextStep,
            text: "Login"
        };
        nextStep.addEventListener('click', () => {
            tabsSwitcher(array, 'enter_email', 'enter_password', 2000);
        })

    </script>
@endsection
