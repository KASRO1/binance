@extends('base')

@section('title', 'Главная страница')

@section('content')
    <section class="flex py-5 flex-col gap-6">
        <h1 class="text-xl">
            {{__('home.welcome')}}
        </h1>
        <div class="flex flex-col gap-2">
            <p class="text-gray2 text-sm font-normal">
                {{__('home.description')}}
            </p>
        </div>
        <div class="flex gap-3">
            <div class="flex flex-col gap-1">
                <p class="text-xs text-gray font-medium">
                    {{__('home.static1')}}
                </p>
                <p>
                    60.4m
                </p>
            </div>
            <div class="flex flex-col gap-1">
                <p class="text-xs text-gray font-medium">
                    {{__('home.static2')}}
                </p>
                <p>
                    3.7m
                </p>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <button class="__btn bg-yelow">
                {{__('home.btn_login')}}
            </button>
            <button class="__btn bg-yelow">
                {{__('home.btn_register')}}
            </button>

        </div>

    </section>
    <section class="flex py-5 flex-col gap-10">
        <h1 class="text-xl">
            {{__('home.title_p2p')}}
        </h1>
        <div class="flex flex-col gap-5">
            <div class="flex px-6 py-10 border border-gray4 rounded-3xl flex-col gap-6 ">
                <svg class="bn-svg w-[96px] h-[96px]" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                    <path d="M58 12.002l16 16H58v-16z" fill="#929AA5"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M22 12.002h36v16h16v56H22v-72zm6 19.997h40v4H28v-4zm0 8h12.248a16.074 16.074 0 00-4.74 4H28v-4zm32.49 4a16.076 16.076 0 00-4.739-4H68v4H60.49zm-32.49 4h5.163a15.891 15.891 0 00-1.04 4H28v-4zm34.837 0c.51 1.261.864 2.603 1.039 4h4.123v-4h-5.162zm-34.838 8h4.124a15.891 15.891 0 001.04 4H28v-4zm35.877 0a15.891 15.891 0 01-1.04 4H68v-4h-4.123zm-35.876 8h7.509a16.074 16.074 0 004.739 4H28v-4zm32.49 0a16.074 16.074 0 01-4.739 4H68v-4H60.49zm7.51 8v4H28v-4h40z"
                          fill="#929AA5"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M48 65.999c6.627 0 12-5.373 12-12s-5.373-12-12-12c-6.628 0-12 5.373-12 12s5.372 12 12 12zm0-16.8l-4.8 4.8 4.8 4.8 4.8-4.8-4.8-4.8z"
                          fill="#F0B90B"></path>
                </svg>
                <div class="flex flex-col gap-[15px]">
                    <h2 class="text-lg font-semibold text-white">
                        {{__('home.title_block1')}}
                    </h2>
                    <p class="text-white font-light">
                        {{__('home.description_block1')}}
                    </p>

                </div>
            </div>
            <div class="flex px-6 py-10 border border-gray4 rounded-3xl flex-col gap-6 ">
                <svg class="bn-svg w-[96px] h-[96px]" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M35.545 88c-4.668-.013-10.028-1.867-15.545-7.384V52.001h23.7l14.49 14.49a9.261 9.261 0 01-13.097 0l-6.194-6.194-2.019 2.018 9.606 9.71h29.515c0 8.816-7.148 15.964-15.965 15.964l-24.261.012h-.23z"
                          fill="#929AA5"></path>
                    <path d="M8 52h12v36H8V52z" fill="#929AA5"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M68 12c11.045 0 20 8.954 20 20s-8.955 20-20 20c-11.046 0-20-8.954-20-20s8.954-20 20-20zm0 28l-8-8 8-8 8 8-8 8z"
                          fill="#F0B90B"></path>
                </svg>
                <div class="flex flex-col gap-[15px]">
                    <h2 class="text-lg font-semibold text-white">
                        {{__('home.title_block2')}}

                    </h2>
                    <p class="text-white font-light">
                        {{__('home.description_block2')}}
                    </p>

                </div>
            </div>
            <div class="flex px-6 py-10 border border-gray4 rounded-3xl flex-col gap-6 ">
                <svg class="bn-svg w-[96px] h-[96px]" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M84 44H12v40h72V44zM48 61.998l-8-8 8-8 8 8-8 8z" fill="#929AA5"></path>
                    <path d="M30 8h36L48 26 30 8z" fill="#929AA5"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M48 33.999c11.045 0 20 8.954 20 20s-8.955 20-20 20c-11.046 0-20-8.954-20-20s8.954-20 20-20zm0 28l-8-8 8-8 8 8-8 8z"
                          fill="#F0B90B"></path>
                </svg>
                <div class="flex flex-col gap-[15px]">
                    <h2 class="text-lg font-semibold text-white">
                        {{__('home.title_block3')}}
                    </h2>
                    <p class="text-white font-light">
                        {{__('home.description_block3')}}
                    </p>

                </div>
            </div>
        </div>
        <div class="flex flex-col gap-5">
            <h1 class="text-xl mb-10">
                {{__('home.title_advantages')}}
            </h1>
            <div class="flex py-4  rounded-3xl flex-col gap-6 ">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.688 17.3333C12.8722 23.3333 14.2852 28 16.001 28C16.2401 28 16.4733 27.9094 16.6982 27.7371C16.1078 26.6217 15.7734 25.3499 15.7734 24C15.7734 21.2331 17.1781 18.7943 19.3132 17.3577C19.3135 17.3496 19.3137 17.3415 19.314 17.3333H12.688Z"
                        fill="#CACED3"></path>
                    <path
                        d="M4.07422 17.3333C4.57829 21.8933 7.63738 25.6832 11.7881 27.2397C11.5053 26.5991 11.2708 25.9055 11.0746 25.199C10.4784 23.0526 10.1061 20.3084 10.0201 17.3333H4.07422Z"
                        fill="#CACED3"></path>
                    <path
                        d="M10.0201 14.6667H4.07422C4.57829 10.1067 7.63738 6.31684 11.7881 4.76034C11.5053 5.40088 11.2708 6.09448 11.0746 6.801C10.4784 8.94737 10.1061 11.6916 10.0201 14.6667Z"
                        fill="#CACED3"></path>
                    <path
                        d="M20.9274 6.801C20.7311 6.09448 20.4966 5.40088 20.2138 4.76034C24.3646 6.31684 27.4237 10.1067 27.9277 14.6667H21.9818C21.8958 11.6916 21.5236 8.94737 20.9274 6.801Z"
                        fill="#CACED3"></path>
                    <path
                        d="M12.688 14.6667H19.314C19.1297 8.66673 17.7167 4 16.001 4C14.2852 4 12.8722 8.66673 12.688 14.6667Z"
                        fill="#CACED3"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M23.7735 29.3333C26.719 29.3333 29.1069 26.9455 29.1069 24C29.1069 21.0545 26.719 18.6667 23.7735 18.6667C20.828 18.6667 18.4402 21.0545 18.4402 24C18.4402 26.9455 20.828 29.3333 23.7735 29.3333ZM23.7735 21.6667L21.4402 24L23.7735 26.3333L26.1069 24L23.7735 21.6667Z"
                          fill="#F0B90B"></path>
                </svg>

                <div class="flex flex-col gap-[15px]">
                    <h2 class="text-lg font-semibold text-white">
                        {{__('home.advantages1_title')}}
                    </h2>
                    <p class="text-white font-light">
                        {{__('home.advantages1_description')}}
                    </p>

                </div>
            </div>
            <div class="flex py-4  rounded-3xl flex-col gap-6 ">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M8.66667 4.68001V1.34668L4 6.01335L8.66667 10.68V7.34668H18.6667C22.3486 7.34668 25.3333 10.3314 25.3333 14.0133V17.3306H28V14.0133C28 8.85869 23.8213 4.68001 18.6667 4.68001H8.66667ZM23.3333 24.6533H13.3333C9.65144 24.6533 6.66667 21.6686 6.66667 17.9867V14.6694H4V17.9867C4 23.1413 8.17868 27.32 13.3333 27.32H23.3333V30.6533L28 25.9867L23.3333 21.32V24.6533ZM22.6667 16C22.6667 19.6819 19.6819 22.6667 16 22.6667C12.3181 22.6667 9.33333 19.6819 9.33333 16C9.33333 12.3181 12.3181 9.33333 16 9.33333C19.6819 9.33333 22.6667 12.3181 22.6667 16ZM16 13.3333L18.6667 16L16 18.6667L13.3333 16L16 13.3333Z"
                          fill="#CACED3"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M22.6666 16C22.6666 19.6819 19.6818 22.6667 15.9999 22.6667C12.318 22.6667 9.33325 19.6819 9.33325 16C9.33325 12.3181 12.318 9.33333 15.9999 9.33333C19.6818 9.33333 22.6666 12.3181 22.6666 16ZM15.9999 13.3333L18.6666 16L15.9999 18.6667L13.3333 16L15.9999 13.3333Z"
                          fill="#F0B90B"></path>
                </svg>

                <div class="flex flex-col gap-[15px]">
                    <h2 class="text-lg font-semibold text-white">
                        {{__('home.advantages2_title')}}
                    </h2>
                    <p class="text-white font-light">
                        {{__('home.advantages2_description')}}
                    </p>

                </div>
            </div>
            <div class="flex  py-4  rounded-3xl flex-col gap-6 ">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="ic/spend-to-earn-2c-blk">
                        <path id="Subtract" fill-rule="evenodd" clip-rule="evenodd"
                              d="M9.52205 4C6.57654 4 4.18872 6.38782 4.18872 9.33333C4.18872 12.2789 6.57653 14.6667 9.52205 14.6667C12.4676 14.6667 14.8554 12.2789 14.8554 9.33333C14.8554 6.38782 12.4676 4 9.52205 4ZM9.52282 11.5294L11.7189 9.33333L9.52282 7.13725L7.32674 9.33333L9.52282 11.5294Z"
                              fill="#F0B90B"></path>
                        <path id="Union" fill-rule="evenodd" clip-rule="evenodd"
                              d="M22.1876 6.66667L24.9636 6.66667L20.8549 2.66667L16.7462 6.66667L19.5209 6.66667V11.3326H22.1876V6.66667ZM20.8555 13.3333C16.8055 13.3333 13.5222 16.6166 13.5222 20.6667C13.5222 24.7168 16.8055 28 20.8555 28C24.9056 28 28.1889 24.7168 28.1889 20.6667C28.1889 16.6166 24.9056 13.3333 20.8555 13.3333ZM20.8555 23.6667L23.8555 20.6667L20.8555 17.6667L17.8555 20.6667L20.8555 23.6667ZM10.8555 25.3333L10.8555 16.6678H8.18888L8.18888 25.3333H5.41284L9.52157 29.3333L13.6303 25.3333H10.8555Z"
                              fill="#CACED3"></path>
                    </g>
                </svg>

                <div class="flex flex-col gap-[15px]">
                    <h2 class="text-lg font-semibold text-white">
                        {{__('home.advantages3_title')}}
                    </h2>
                    <p class="text-white font-light">
                        {{__('home.advantages3_description')}}
                    </p>

                </div>
            </div>
        </div>

    </section>
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
