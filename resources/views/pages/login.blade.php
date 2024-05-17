@extends('base')

@section('title', 'Главная страница')

@section('content')
    <form id="login_form" class="flex py-5 flex-col gap-6">
        <h1 class="text-2xl">
            {{__('login.title')}}
        </h1>

        <div id="enter_email" class="flex flex-col gap-1">
            <p class="text-sm font-medium text-gray">
                {{__('login.label_email')}}
            </p>
            <input name="email" id="email_input" type="text" class="__input">
            <p id="email_error" class="text-sm text-red"></p>
        </div>
        <div id="enter_password" class="flex hidden  flex-col gap-1">
            <p class="text-sm font-medium text-gray">
                {{__('login.label_password')}}
            </p>
            <input id="password_input" name="password" type="text" class="__input">
            <p id="password_error" class="text-sm text-red"></p>
        </div>
        <button type="button" id="nextStep" class="__btn bg-yelow">{{__('login.btn_next')}}</button>
        <a href="{{route('register')}}" class="text-sm text-yelow2 hover:text-yelow transition-all">{{__('login.register')}}</a>
    </form>
@endsection


@section("script")
    <script>
        const nextStep = document.getElementById('nextStep');
        const enter_email = document.getElementById('enter_email');
        const enter_password = document.getElementById('enter_password');
        const array = {
            element: nextStep,
            text: "{{__('login.btn_login')}}",
        };
        nextStep.addEventListener('click', () => {
            async function performValidation() {
                const url = "{{route('auth.exist')}}";
                const validateEmail = await validate('email', 'email');
                const validateNotExistEmail = await validate('email', 'not_exist_email', url);

                if (validateEmail && validateNotExistEmail) {
                    tabsSwitcher(array, 'enter_email', 'enter_password', 2000, true);
                }
            }

            performValidation().catch(console.error);
        })

        const login_form = document.getElementById('login_form');
        login_form.addEventListener('submit', (e) => {
            e.preventDefault();
            const url = "{{route('auth.login')}}";
            const formData = new FormData(login_form);
            axios.post(url, formData)
                .then((response) => {
                    if (response.data.status === 'success') {
                    }
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        const errors = error.response.data.errors;
                        for (const key in errors) {
                            const errorElement = document.getElementById(`${key}_error`);
                            errorElement.innerText = errors[key][0];
                        }
                    }
                });
        });
    </script>
@endsection
