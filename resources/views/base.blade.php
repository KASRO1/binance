<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/assets/css/main.css"/>
    <link rel="stylesheet" href="/assets/fonts/fonts.css"/>
    <link rel="stylesheet" href="/assets/css/itc-custom-select.css"/>
    <script src="/assets/js/itc-custom-select.js"></script>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/axios.min.js"></script>
</head>

<body  class="h-full flex justify-between flex-col container m-auto">
<header onclick="closeModalExchange()" class="close_modal px-6 flex py-3 pt-7 justify-between">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5120 1024" class="h-6" fill="#F0B90B">
        <path
            d="M230.997333 512L116.053333 626.986667 0 512l116.010667-116.010667L230.997333 512zM512 230.997333l197.973333 197.973334 116.053334-115.968L512 0 197.973333 314.026667l116.053334 115.968L512 230.997333z m395.989333 164.992L793.002667 512l116.010666 116.010667L1024.981333 512l-116.992-116.010667zM512 793.002667l-197.973333-198.997334-116.053334 116.010667L512 1024l314.026667-314.026667-116.053334-115.968L512 793.002667z m0-165.973334l116.010667-116.053333L512 396.032 395.989333 512 512 626.986667z m1220.010667 11.946667v-1.962667c0-75.008-40.021333-113.024-105.002667-138.026666 39.978667-21.973333 73.984-58.026667 73.984-121.002667v-1.962667c0-88.021333-70.997333-145.024-185.002667-145.024h-260.992v561.024h267.008c126.976 0.981333 210.005333-51.029333 210.005334-153.002666z m-154.026667-239.957333c0 41.984-34.005333 58.965333-89.002667 58.965333h-113.962666V338.986667h121.984c52.010667 0 80.981333 20.992 80.981333 58.026666v2.005334z m31.018667 224c0 41.984-32.981333 61.013333-87.04 61.013333h-146.944v-123.050667h142.976c63.018667 0 91.008 23.04 91.008 61.013334v1.024z m381.994666 169.984V230.997333h-123.989333v561.024h123.989333v0.981334z m664.021334 0V230.997333h-122.026667v346.026667l-262.997333-346.026667h-114.005334v561.024h122.026667v-356.010666l272 356.992h104.96z m683.946666 0L3098.026667 228.010667h-113.962667l-241.024 564.992h127.018667l50.986666-125.994667h237.013334l50.986666 125.994667h130.005334z m-224.981333-235.008h-148.992l75.008-181.973334 73.984 181.973334z m814.037333 235.008V230.997333h-122.026666v346.026667l-262.997334-346.026667h-114.005333v561.024h122.026667v-356.010666l272 356.992h104.96z m636.970667-91.008l-78.976-78.976c-44.032 39.978667-83.029333 65.962667-148.010667 65.962666-96 0-162.986667-80-162.986666-176v-2.986666c0-96 67.968-174.976 162.986666-174.976 55.978667 0 100.010667 23.978667 144 62.976l78.976-91.008c-51.968-50.986667-114.986667-86.997333-220.970666-86.997334-171.989333 0-292.992 130.986667-292.992 290.005334V512c0 160.981333 122.965333 288.981333 288 288.981333 107.989333 1.024 171.989333-36.992 229.973333-98.986666z m527.018667 91.008v-109.994667h-305.024v-118.016h265.002666v-109.994667h-265.002666V340.992h301.013333V230.997333h-422.997333v561.024h427.008v0.981334z"
            p-id="2935"></path>
    </svg>

    <div class="flex gap-3  items-center">

        @if(Auth::check() && isset($balance_to_main_cur) )
            <p class="text-sm rounded-3xl  bg-gray4" style="padding: 3px 10px">
                <span id="balance_show">{{(new \App\Http\Actions\User\Balance\GetFullBalance())->run(Auth::user())}}</span> {{Auth::user()->main_currency}}
            </p>
        @endif




        <div class="h-6 w-6 flex items-center gap-2 cursor-pointer" onclick="showModalProfileContent()">


            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                <use xlink:href="#account-f"></use>
            </svg>
        </div>
    </div>

</header>
<main class="relative py-2 px-6 flex-1 flex gap-10 flex-col">
    @yield('content')
</main>
<footer class="px-6 bottom-0 w-full border-t justify-center text-center flex flex-col border-gray3 py-3">
    <p class="text-xs font-normal">
        Binance© 2024
    </p>
    <p class="text-xs font-normal">
        Terms of Use
    </p>
</footer>
<div id="overlay"></div>
<svg aria-name="common" xmlns="http://www.w3.org/2000/svg"
     style="position: absolute; width: 0px; height: 0px; overflow: hidden;" aria-hidden="true">
    <symbol viewBox="0 0 24 24" id="account-f">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3ZM14.5 9.5C14.5 10.8807 13.3807 12 12 12C10.6193 12 9.5 10.8807 9.5 9.5C9.5 8.11929 10.6193 7 12 7C13.3807 7 14.5 8.11929 14.5 9.5ZM12 13.9961H8.66662C7.97115 13.9961 7.37518 14.7661 7.12537 15.5161C7.73252 16.4634 9.45831 17.9803 12 18.0023C14.5416 18.0243 16.3061 16.3616 16.8745 15.5161C16.6247 14.7661 16.0288 13.9961 15.3333 13.9961H12Z"
              fill="currentColor"></path>
    </symbol>
    <symbol viewBox="0 0 24 24" id="language-f">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M15.2307 20.4027C18.2316 19.2481 20.4577 16.5321 20.9137 13.25H16.9718C16.8248 16.1102 16.1791 18.638 15.2307 20.4027ZM14.473 13.25C14.2952 17.3518 13.2556 20.5 11.9998 20.5C10.744 20.5 9.70447 17.3518 9.52667 13.25H14.473ZM14.473 10.75H9.52667C9.70447 6.64821 10.744 3.5 11.9998 3.5C13.2556 3.5 14.2952 6.64821 14.473 10.75ZM16.9718 10.75H20.9137C20.4577 7.46786 18.2316 4.75191 15.2307 3.59731C16.1791 5.36198 16.8248 7.88979 16.9718 10.75ZM7.03566 10.75C7.18282 7.88774 7.82928 5.35836 8.77882 3.59353C5.77291 4.74598 3.54249 7.46427 3.08594 10.75H7.03566ZM7.03566 13.25H3.08594C3.54249 16.5357 5.77291 19.254 8.77882 20.4065C7.82928 18.6416 7.18282 16.1123 7.03566 13.25Z"
              fill="currentColor"></path>
    </symbol>
    <symbol viewBox="0 0 24 24" id="user-f">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M16 8C16 10.2091 14.2091 12 12 12C9.79086 12 8 10.2091 8 8C8 5.79086 9.79086 4 12 4C14.2091 4 16 5.79086 16 8ZM8 14C5.79086 14 4 15.7909 4 18V20H20V18C20 15.7909 18.2091 14 16 14H8Z"
              fill="currentColor"></path>
    </symbol>
    <symbol viewBox="0 0 24 24" id="wallet-f">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M4 8.5C4 6.01472 6.01472 4 8.5 4H20V20H8.5C6.01472 20 4 17.9853 4 15.5V8.5ZM8.5 7H17V10H8.5C7.67157 10 7 9.32843 7 8.5C7 7.67157 7.67157 7 8.5 7ZM13 13H17V17H13V13Z"
              fill="currentColor"></path>
    </symbol>
    <symbol viewBox="0 0 24 24" id="log-out-f">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M3.22266 6V3H6.22266H11.7227V6L6.22266 6L6.22266 18H11.7227V21H6.22266H3.22266V18V6ZM8.59134 13.5V10.5L15.1783 10.5L15.1782 5.98418L21.2079 12L15.1783 17.9797L15.1783 13.5H8.59134Z"
              fill="currentColor"></path>
    </symbol>
</svg>
<section id="modalProfile " class="modalProfile">
    <div id="modalProfileContent" class="modalProfileContent ">
        <div class="flex flex-col px-6 ">

            <div class="flex  flex-col gap-2 py-5">
                <div class="text-xl items-center flex justify-between ">
                    <div>
                        <div onclick="closeModalProfileContent()" class="cursor-pointer h-7 w-7">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="css-11ppfta">
                                <path
                                    d="M6.697 4.575L4.575 6.697 9.88 12l-5.304 5.303 2.122 2.122L12 14.12l5.303 5.304 2.122-2.122L14.12 12l5.304-5.303-2.122-2.122L12 9.88 6.697 4.575z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>

                </div>
                @if(Auth::check())
                    <div class="flex gap-4">
                        @if(\Illuminate\Support\Facades\Auth::user()->limit_deals <= 0)
                            <div class="px-4 text-xs font-light py-1 bg-yelow rounded-full">
                                {{__('p2p.limit_deals')}}
                            </div>
                        @endif
                        <div class="px-4 text-xs font-light py-1 bg-ligth rounded-full">
                            {{__('p2p.your_profit')}}: <span class="text-green font-semibold">0$</span>
                        </div>
                        <div class="px-4 text-xs font-light py-1 bg-ligth rounded-full">
                            {{__('p2p.balance')}}: <span
                                class="text-green font-semibold">{{(new \App\Http\Actions\User\Balance\GetFullBalance())->run(Auth::user()) . ' ' . Auth::user()->main_currency}}</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="flex flex-col gap-4">
                @if(Auth::check())
                    <a href="{{route('profile')}}"
                       class="flex transition-all  cursor-pointer items-center font-normal text-gray2 gap-3">
                        <div class="w-8 h-8">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <use xlink:href="#user-f"></use>
                            </svg>
                        </div>
                        <p class="text-black">
                            {{__('p2p.my_profile')}}
                        </p>
                    </a>
                    <div onclick="window.location.href = '{{route('p2p')}}'"
                         class="flex transition-all  cursor-pointer items-center font-normal text-gray2 gap-3">
                        <div class="w-8 h-8">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <use xlink:href="#wallet-f"></use>
                            </svg>
                        </div>
                        <p class="text-black">
                            P2P
                        </p>
                    </div>
                    {{--                    <div class="flex transition-all  cursor-pointer  items-center font-normal text-gray2 gap-3">--}}
                    {{--                        <div class="w-8 h-8">--}}
                    {{--                            <svg viewBox="0 0 24 24" class="chat-icon" style="width: 32px; height: 32px;">--}}
                    {{--                                <path--}}
                    {{--                                    d="M21.002 17V12C21.002 11.6893 20.9862 11.3824 20.9555 11.0798C20.9528 11.0532 20.95 11.0266 20.947 11C20.4496 6.50005 16.6345 3 12.002 3C7.03139 3 3.00195 7.02944 3.00195 12V17H8.00195V11H5.5784C6.05941 7.88491 8.75217 5.5 12.002 5.5C15.2517 5.5 17.9445 7.88491 18.4255 11H16.002V17H16.9009C16.0053 17.8777 14.8748 18.5166 13.6124 18.8139C13.2482 18.3202 12.6625 18 12.002 18C10.8974 18 10.002 18.8954 10.002 20C10.002 21.1046 10.8974 22 12.002 22C12.8165 22 13.5173 21.5131 13.8292 20.8144C16.18 20.3296 18.1958 18.9281 19.4864 17H21.002Z"--}}
                    {{--                                    fill="currentColor"></path>--}}
                    {{--                            </svg>--}}
                    {{--                        </div>--}}
                    {{--                        <p class="text-black">--}}
                    {{--                            {{__('p2p.my_profile')}}--}}
                    {{--                        </p>--}}
                    {{--                    </div>--}}
                @endif
                <div class="menu">
                    <div
                        class="menu-link flex transition-all  cursor-pointer  items-center font-normal text-gray2 justify-between">
                        <div class="flex gap-2 items-center">
                            <div class="w-8 h-8">
                                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                    <use xlink:href="#language-f"></use>
                                </svg>
                            </div>
                            <p class="text-black">
                                Language
                            </p>
                        </div>
                        <div class="w-4 h-4 text-gray">
                            <svg class="bn-svg header-nav-collapseicon" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.11 12.178L16 8.287l1.768 1.768-5.657 5.657-1.768-1.768-3.889-3.889 1.768-1.768 3.889 3.89z"
                                      fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>
                    <div style="padding-inline-start: 44px" class="menu-block hidden flex flex-col ">
                        <a href="{{route("language:lang", "en")}}" class="py-5">
                            English
                        </a>
                        <a href="{{route("language:lang", "es")}}" class="py-5">
                            Español
                        </a>
                    </div>
                </div>
                @if(Auth::check())
                    <a href="{{route('logout')}}"
                       class="flex transition-all  cursor-pointer items-center font-normal text-gray2 gap-3">
                        <div class="w-8 h-8">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <use xlink:href="#log-out-f"></use>
                            </svg>
                        </div>
                        <p class="text-black">
                            {{__('p2p.logout')}}
                        </p>
                    </a>
                @endif
                @if(!Auth::check())
                    <div class="menu">
                        <div
                            class="menu-link flex transition-all  cursor-pointer  items-center font-normal text-gray2 justify-between">
                            <div class="flex gap-2 items-center">
                                <div class="w-8 h-8">
                                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <use xlink:href="#language-f"></use>
                                    </svg>
                                </div>
                                <p class="text-black">
                                    Account
                                </p>
                            </div>
                            <div class="w-4 h-4 text-gray">
                                <svg class="bn-svg header-nav-collapseicon" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12.11 12.178L16 8.287l1.768 1.768-5.657 5.657-1.768-1.768-3.889-3.889 1.768-1.768 3.889 3.89z"
                                          fill="currentColor"></path>
                                </svg>
                            </div>
                        </div>
                        <div style="padding-inline-start: 44px" class="menu-block hidden flex flex-col ">
                            <a href="{{route("login")}}" class="py-5">
                                {{__('login.btn_login')}}
                            </a>
                            <a href="{{route("register")}}" class="py-5">
                                {{__('register.btn_register')}}
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>


</body>
<script src="/assets/js/index.js"></script>
@yield('script')
<script>
    showAnswerMenu()
</script>

</html>
