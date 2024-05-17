@extends('base')

@section('title', 'Главная страница')

@section('content')
    <div class="flex pt-5 flex-col gap-6">
        <div class="flex gap-3">
            <div class="w-12 h-12 text-lg flex items-center justify-center rounded-full bg-purple-950">
                C
            </div>
            <div class="flex flex-col gap-4 ">
                <div class="flex items-center gap-2">
                    CheapAndCrypto
                    <svg class="bn-svg ml-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 18px; height: 18px;">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.438 4.313L14.814 1.5 12 3.124 9.187 1.5 7.562 4.313H4.313v3.25L1.5 9.186 3.124 12 1.5 14.813l2.813 1.625v3.248h3.25L9.186 22.5 12 20.876l2.813 1.624 1.625-2.814h3.248v-3.248l2.814-1.624L20.876 12 22.5 9.187l-2.814-1.625V4.313h-3.248zm-.902 4.215l1.414 1.414-6.364 6.364L7.05 12.77l1.414-1.414 2.122 2.122 4.95-4.95z" fill="#F0B90B"></path>
                    </svg>
                </div>
                <div class="flex font-normal text-sm flex-col gap-1">
                    <p class="text-gray">
                        {{__('profile.last_online')}} 2h ago
                    </p>
                    <p class="text-gray">
                        {{__('profile.register')}} 2020-10-26
                    </p>
                </div>
                <div class="flex gap-4 text-gray text-sm font-normal flex-wrap">
                    <div class="flex items-center text-nowrap gap-1 ">
                        Email
                        <div class="text-green w-4 h-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-5s6rw0"><path d="M19.068 4.932A9.917 9.917 0 0012 2a9.917 9.917 0 00-7.068 2.932A9.917 9.917 0 002 11.988C2 17.521 6.479 22 12 22a9.917 9.917 0 007.068-2.932A9.992 9.992 0 0022 11.988a9.918 9.918 0 00-2.932-7.056zm-8.912 12.234L5.71 12.71l1.42-1.42 3.025 3.024 6.7-6.713 1.421 1.42-8.121 8.145z" fill="currentColor"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center text-nowrap gap-1 ">
                        SMS
                        <div class="text-green w-4 h-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-5s6rw0"><path d="M19.068 4.932A9.917 9.917 0 0012 2a9.917 9.917 0 00-7.068 2.932A9.917 9.917 0 002 11.988C2 17.521 6.479 22 12 22a9.917 9.917 0 007.068-2.932A9.992 9.992 0 0022 11.988a9.918 9.918 0 00-2.932-7.056zm-8.912 12.234L5.71 12.71l1.42-1.42 3.025 3.024 6.7-6.713 1.421 1.42-8.121 8.145z" fill="currentColor"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center text-nowrap gap-1 ">
                        ID Verification

                        <div class="text-green w-4 h-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-5s6rw0"><path d="M19.068 4.932A9.917 9.917 0 0012 2a9.917 9.917 0 00-7.068 2.932A9.917 9.917 0 002 11.988C2 17.521 6.479 22 12 22a9.917 9.917 0 007.068-2.932A9.992 9.992 0 0022 11.988a9.918 9.918 0 00-2.932-7.056zm-8.912 12.234L5.71 12.71l1.42-1.42 3.025 3.024 6.7-6.713 1.421 1.42-8.121 8.145z" fill="currentColor"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center text-nowrap gap-1 ">
                        Address

                        <div class="text-green w-4 h-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-5s6rw0"><path d="M19.068 4.932A9.917 9.917 0 0012 2a9.917 9.917 0 00-7.068 2.932A9.917 9.917 0 002 11.988C2 17.521 6.479 22 12 22a9.917 9.917 0 007.068-2.932A9.992 9.992 0 0022 11.988a9.918 9.918 0 00-2.932-7.056zm-8.912 12.234L5.71 12.71l1.42-1.42 3.025 3.024 6.7-6.713 1.421 1.42-8.121 8.145z" fill="currentColor"></path></svg>
                        </div>
                    </div>

                </div>
                <div class="flex gap-3 flex-col">
                    <div class="flex font-light text-sm justify-between">
                        <p class="text-gray">{{__('profile.orders')}}</p>
                        <p class="text-white">98.60%</p>
                    </div>
                    <div class="flex font-light text-sm justify-between">
                        <p class="text-gray">{{__('profile.execution_method')}}</p>
                        <p class="text-green font-semibold">{{__('profile.automatic_mode')}}</p>
                    </div>
                    <div class="flex font-light text-sm justify-between">
                        <p class="text-gray">{{__('profile.completion')}}</p>
                        <p class="text-white">703 orders</p>
                    </div>

                    <div class="flex font-light text-sm justify-between">
                        <p class="text-gray">{{__('profile.available')}}</p>
                        <p class="text-white">100.00 USDT</p>
                    </div>
                    <div class="flex font-light text-sm justify-between">
                        <p class="text-gray">{{__('profile.positive_feedback')}}</p>
                        <div class="text-white items-center flex gap-1 ">
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
                </div>

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
