@extends('base')

@section('title', __('register.title'))

@section('content')
    <form id="register_form" class="flex py-5 flex-col gap-6">
        <h1 class="text-2xl">
            {{__('register.title')}}
        </h1>

        <div id="enter_email" class="flex  flex-col gap-1">
            <p class="text-sm font-medium text-gray">
                {{__('register.label_email')}}
            </p>
            <input name="email" id="email_input" type="text" class="__input">
            <p id="email_error" class="text-sm text-red"></p>

        </div>
        <div id="enter_password" class="flex hidden  flex-col gap-1">
            <p class="text-sm font-medium text-gray ">
                {{__('register.label_password')}}
            </p>
            <input id="password_input" name="password" type="password" class="__input">

            <p class="text-sm font-medium text-gray">
                {{__('register.label_ConfirmPassword')}}
            </p>
            <input id="password_confirm" type="password" class="__input">
            <p id="password_error" class="text-sm text-red"></p>
        </div>
        <div id="option_account" class="flex hidden   flex-col gap-3">
            <p class="text-sm font-medium text-gray ">
                {{__('register.label_mainCurrency')}}
            </p>
            <div id="select-2"></div>
            <a onclick="togglePromo()"
               class="cursor-pointer text-sm text-yelow2 hover:text-yelow transition-all">{{__('register.label_have_promo')}}</a>
            <div id="enter_promo" class="hidden">
                <p class="text-sm font-medium text-gray">
                    {{__('register.label_promocode')}}
                </p>
                <input id="promocode" name="promocode" type="text" class="__input">
                <div id="promocode_info" class="py-2 text-yelow2">

                </div>
            </div>
        </div>
        <button type="button" id="nextStep" class="__btn bg-yelow">{{__('register.btn_next')}}</button>


        <div class="flex gap-1">
            <p class="text-sm font-medium text-gray">
                {{__('login.already_have_account')}}
            </p>
            <a href="{{route('login')}}" class="text-sm text-yelow2 hover:text-yelow transition-all">{{__('login.btn_login')}}</a>
        </div>
    </form>
@endsection


@section("script")
    <script>
        const select2 = new ItcCustomSelect('#select-2', {
            name: 'currency',
            targetValue: 'USD',
            options: [
                    @foreach($currencies as $currency)
                ['{{$currency['symbol']}}', '{{$currency['symbol']}}'],
                @endforeach
            ],
        });
        let step = 0;
        const nextStep = document.getElementById('nextStep');
        const enter_email = document.getElementById('enter_email');
        const enter_password = document.getElementById('enter_password');
        const array = {
            element: nextStep,
            text: "{{__('register.btn_next')}}",
        };
        const array1 = {
            element: nextStep,
            text: "{{__('register.btn_register')}}",
        };

        async function step1Validation() {
            const url = "{{route('auth.exist')}}";
            const validateEmail = await validate('email', 'email');
            const validateExistEmail = await validate('email', 'exist_email', url);

            if (validateEmail && validateExistEmail) {
                tabsSwitcher(array, 'enter_email', 'enter_password', 2000);
                step = 1;
            }

        }

        async function step2Validation() {
            if (await validate('password', 'password') && await validate('password', 'password_confirm')) {
                tabsSwitcher(array1, 'enter_password', 'option_account', 2000, true);
                const promocode = document.getElementById('promocode');

                promocode.addEventListener('input', async () => {
                       const url = "{{route('promo.exist')}}";
                        existPromocode(url)
                })


            }
        }

        nextStep.addEventListener('click', () => {
            if (step == 0) {
                step1Validation().catch(console.error);

            } else if (step == 1) {
                step2Validation().catch(console.error);
            }
        })

        function togglePromo() {
            const enter_promo = document.getElementById('enter_promo');
            enter_promo.classList.toggle('hidden');
        }

        const register_form = document.getElementById('register_form');
        register_form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const url = "{{route('auth.register')}}";
            const data = new FormData(register_form);
            data.set('currency', select2.value);
            axios.post(url, data).then((response) => {
                if (response.data.status == 'success') {
                    setTimeout(() => {
                        nextStep.innerText = "{{__('register.back_to_login')}}";
                        nextStep.classList.add('bg-green');
                        nextStep.classList.add('text-white');
                        nextStep.classList.remove('bg-yelow');
                        setTimeout(() => {
                            window.location.href = "{{route('login')}}";
                        }, 1000);

                    }, 2000);
                }
            }).catch((error) => {
                console.log(error.response.data);
            })


        })
    </script>
@endsection
