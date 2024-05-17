@extends('base')

@section('title', 'Swap')

@section('content')
    <form id="swap" class="px-4 py-6 rounded-3xl gap-32  border border-gray4 flex flex-col  justify-between">
        <div class="flex  flex-col gap-5">
            <div class="flex flex-col gap-3">
                <div class="hover:border-yelow transition-all border border-transparent bg-gray4 rounded-xl px-4 py-2 flex-col flex gap-2">
                    <p class="text-white text-xs font-light">
                        {{__('swap.you_pay')}}
                    </p>
                    <div class="flex justify-between ">
                        <input oninput="updateData()" name="amount_from" class="style_reset_input flex-1" placeholder="{{__('swap.enter_amount')}}">
                        <select onchange="updateData()"  name="currency_from" class="bg-transparent">

                            @foreach($currency_crypto as $currency)
                                <option value="{{$currency['id']}}">{{$currency['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="flex flex-col gap-3">
                <div class="hover:border-yelow transition-all border border-transparent bg-gray4 rounded-xl px-4 py-2 flex-col flex gap-2">
                    <p class="text-white text-xs font-light">
                        {{__('swap.you_receive')}}
                    </p>
                    <div class="flex justify-between ">
                        <input name="amount_to" class="style_reset_input flex-1" placeholder="{{__('swap.enter_amount')}}">
                        <select onchange="updateData()" name="currency_to" class="bg-transparent">

                            @foreach($currency_crypto as $currency)
                                <option value="{{$currency['id']}}">{{$currency['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3">
            <div class="flex justify-between">
                <div class="flex text-sm flex-col gap-1">
                    <p class="text-gray2">
                        {{__('swap.estimated_price')}}
                    </p>
                    <p id="course" class="text-white">
                        1 USDT ≈ 92.26 ALL
                    </p>
                </div>
                <div class="flex text-sm flex-col gap-1">
                    <p class="text-gray2">
                        {{__('swap.your_balance')}}
                    </p>
                    <p id="balance" class="text-white text-end">
                        100 eth
                    </p>
                </div>
            </div>
            <div class="w-full">
                <button type="submit" class="__btn w-full bg-yelow transition-all hover:bg-yelow2">{{__('swap.swap')}}</button>
            </div>
            <p id="error" class="text-red text-center">
            </p>


        </div>
    </form>

@endsection


@section("script")
    <script>
        const select1 = document.querySelector('select[name="currency_from"]');
        const select2 = document.querySelector('select[name="currency_to"]');
        const amount1 = document.querySelector('input[name="amount_from"]');
        const amount2 = document.querySelector('input[name="amount_to"]');
        select2.selectedIndex = 1;
        updateData();
        function updateData(){


            axios.post('{{route('swap.data')}}', {
                currency_from: select1.value,
                currency_to: select2.value,
                amount_from: amount1.value,
                amount_to: amount2.value,
            })
                .then((response) => {
                    document.getElementById('course').innerHTML = `1 ${response.data.currency_to} ≈ ${response.data.course_from} ${response.data.currency_from}`;
                    document.getElementById('balance').innerHTML = response.data.balance + ' ' + response.data.currency_from;
                    amount2.value = response.data.amount_to;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
        const form = document.getElementById('swap');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const button = form.querySelector('button');
            const error = form.querySelector('#error');
            setLoading(button);
            axios.post('{{route('swap.post')}}', formData)
                .then((response) => {
                    button.innerHTML = "Swap done!";
                    button.classList.add('bg-green');
                    button.classList.remove('bg-red');
                    button.classList.add('text-white');
                    button.classList.remove('bg-yelow');
                    error.innerHTML = '';
                    updateData();
                })
                .catch((error_) => {
                    button.innerHTML = "Swap failed!";
                    button.classList.add('bg-red');
                    button.classList.add('text-white');
                    button.classList.remove('bg-yelow');
                    error.innerHTML = error_.response.data.message;
                });
        })
    </script>
@endsection
