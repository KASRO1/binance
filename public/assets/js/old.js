
    const select2 = new ItcCustomSelect(document.getElementById('select-2'));
    const select3 = new ItcCustomSelect(document.getElementById('select-3'));
    step = 1;
    type = '{{$type}}';
    let open_order = false;
    let open_order_id = null;


    function renderDescription(){
    const description1 = document.getElementById('description1')
    const description2 = document.getElementById('description2')
    const description3 = document.getElementById('description3')

    if(type == 'crypto_fiat'){
    description1.classList.remove('hidden')
    description2.classList.add('hidden')
    description3.classList.remove('hidden')
    description3.innerHTML = '{{__('p2p.description3_crypto_fiat')}}'
}
    if(type == 'fiat_crypto'){
    description1.classList.add('hidden')
    description2.classList.remove('hidden')
    description3.classList.remove('hidden')
    description2.innerHTML = '{{__('p2p.description2')}}'
    description3.innerHTML = '{{__('p2p.description3')}}'
}



}
    function getData() {
    axios.get('{{route('transaction.open')}}')
    .then(function (response) {
    let data = response.data;
    if (data.open) {
    open_order = true;
    step = data.transaction.status
    if (step == 5 || step == 6) {
    changeStatusTransaction(step)
    return
}
    const openActualModel = document.getElementById('openActualModel')
    openActualModel.setAttribute('onclick', `showModalExchange(this, 100, ${data.order.id}, ${data.transaction.status})`)
    showModalExchange("", 100, data.order.id, data.transaction.status)

    updateData(data.order.id)

    $('#amount').val(data.transaction.amount)
    type = data.type
    console.log(type)
    if (type == 'crypto_fiat') {
    const commission_div = document.getElementById('commission_div')
    commission_div.classList.remove('hidden')
}
    if (step == 4 && data.deposit == null) {
    step = 3
    changeStatusTransaction(3)

}
    renderDescription()
    if(type == 'fiat_crypto'){
    const i_paid = document.getElementById('i_paid')
    i_paid.disabled = false
}

}
})
    .catch(function (error) {
    console.log(error);

});
}

    getData()
    let audio = false;

    function updateData(order_id) {
    axios.get('/order/get/' + order_id)
        .then(function (response) {
            let order = response.data;
            open_order_id = order.id;
            document.querySelectorAll('#order_id').forEach(
                (el) => {
                    el.value = order.id;
                }
            );

            document.querySelectorAll('#status').forEach(
                (el) => {
                    el.value = order.status;
                    document.getElementById('status').value = order.status;
                    // showStep(step);
                    if (order.status !== null) {
                        step = order.status;
                        if (!audio) {
                            if (step == 5) {
                                changeStatusTransaction(5)
                                if(step == 5){
                                    playSound('/assets/kassa.mp3')
                                }

                                updateBalance();
                                updateBalance('balance1')
                                audio = true
                            }
                            if (step == 6) {
                                changeStatusTransaction(6)
                            }
                        }
                    }

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
            document.querySelectorAll('#minimal_payment').forEach(
                (el) => {
                    el.innerHTML = order.minimal_payment + ' ' + order.currency_name
                    const description1 = document.getElementById('description1')
                    el.value = order.minimal_payment + ' ' + order.currency_name;
                    axios.get(`/currency/to_main_cur/${order.currency_from}/${order.minimal_payment * 200}`)
                        .then(function (response) {
                            description1.innerHTML =  `{{__('p2p.description1_1')}} ${response.data.amount} ${response.data.currency} {{__('p2p.description1_2')}}`
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }
            );
            document.querySelectorAll('#balance').forEach(
                (el) => {
                    el.value = order.balance;
                    el.innerHTML = parseFloat(order.balance).toFixed(4) + ' ' + order.currency_name;
                }
            );
            document.querySelectorAll('#currency').forEach(
                (el) => {
                    el.innerHTML = order.currency_name;

                }
            );
            document.querySelectorAll('#currency_to').forEach(
                (el) => {
                    el.innerHTML = order.currency_to_name;

                }
            );
            document.querySelectorAll('#qr_code').forEach(
                (el) => {
                    el.src = '/storage/' + order.qr_code;
                }
            )
            document.querySelectorAll('#commission').forEach(
                (el) => {
                    const amount = document.getElementById('amount').value ? document.getElementById('amount').value : document.getElementsByName('amount')[0].value;
                    axios.get(`/currency/to_main_cur/${order.currency_from}/${amount}`)
                        .then(function (response) {
                            el.value = (response.data.amount / 100 * 15).toFixed(3) + ' ' + response.data.currency;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            );
            document.querySelectorAll('#credentials').forEach(
                (el) => {

                    if(type == 'crypto_fiat'){
                        const credentials = document.getElementById('credentials')
                        credentials.disabled = false;
                        credentials.value = null
                        const onShowCryptoFiat = document.querySelector('.onShowCryptoFiat')
                        onShowCryptoFiat.classList.remove('hidden')
                    }
                    else{
                        el.value = order.сredentials;
                    }
                    if(type == 'fiat_crypto'){
                        const onShowFiatCrypto = document.querySelector('.onShowFiatCrypto')
                        onShowFiatCrypto.classList.remove('hidden')
                    }
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
    axios.post('/transaction/create', {
        order_id: document.getElementById('order_id').value,
        amount: document.getElementsByName('amount')[0].value,
        status: step,
    })
        .then(function (response) {
            open_order = true;
            const transaction_id = document.getElementById('transaction_id');
            transaction_id.value = response.data.id;
            this.step = step;
            showStep(step);
        })
        .catch(function (error) {
            changeAllErrors(error.response.data.error)
            this.step = 1;

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
    this.step = step;
    showStep(step);
    updateBalance();

})
    .catch(function (error) {
    this.step = step - 1;
    changeAllErrors(error.response.data.error)

});
}

    function backStep(step_func) {
    changeStatusTransaction(step_func)
    if(step_func == 1){
    open_order = false;
}
    step = step_func
    updateBalance();
}

    function showStep(step) {
    hiddenAllStep();
    changeAllErrors('')
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

    function playSound(url) {
    const audio = new Audio(url);
    audio.play().catch(error => {
    console.error('Ошибка при воспроизведении звука:', error);
});
}
    let textIndex = 0;
    function changeText() {
    let textArray = ["{{__('p2p.loading_text1')}}", "{{__('p2p.loading_text2')}}", "{{__('p2p.loading_text3')}}", "{{__('p2p.loading_text4')}}"];

    let textElement = document.getElementById('text_loading');
    textElement.innerText = textArray[textIndex];
    textIndex++;
    if (textIndex >= textArray.length) {
    textIndex = 0;
}
}
    nextStep.forEach((el) => {
    el.addEventListener('click', () => {
        step++;

        const status = document.getElementById('status');
        status.value = step;
        el.innerHTML = `<div class="bn-spinner__nezha"><div class="nezha-line" style="animation-delay: 50ms;"></div><div class="nezha-line" style="animation-delay: 100ms;"></div><div class="nezha-line" style="animation-delay: 150ms;"></div><div class="nezha-line" style="animation-delay: 200ms;"></div></div>`;
        renderDescription()
        if(type == 'fiat_crypto'){
            const i_paid = document.getElementById('i_paid')
            i_paid.disabled = false
        }
        if (type == 'crypto') {
            if (step == 2) {
                createTransaction(4);
                changeText()
                setInterval(() => {
                    changeText()
                }, 1000)
                setTimeout(() => {
                    changeStatusTransaction(5)

                    if(step == 5){
                        playSound('/assets/kassa.mp3')
                    }
                }, 5000)
            }
        } else if (type == 'fiat_crypto' || type == 'crypto_fiat') {
            if (step == 2) {
                createTransaction(2);
            } else {
                changeStatusTransaction(step);
            }
            if(type == 'crypto_fiat'){
                const commission_div = document.getElementById('commission_div')
                commission_div.classList.remove('hidden')
                const credentials = document.getElementById('credentials')
                credentials.disabled = false;
                credentials.value = null
            }


        }
        updateBalance();
        updateData(document.getElementById('order_id').value)

        el.innerHTML = `Next`;

    });
});
    const p2pForm = document.getElementById('p2pForm');
    p2pForm.addEventListener('submit', (e) => {
    e.preventDefault();
    window.location.href = '/p2p/' + select2.value + '/' + select3.value;
});

    function updateBalance(id_el = 'balance_show') {
    axios.get('{{route('balance.get')}}')
    .then(function (response) {
    let balance = response.data;
    const balance_el = document.getElementById(id_el);
    if(balance == balance_el.textContent){
    return
}
    animateNumber(id_el, balance / 3, balance.toFixed(1), 3000);
})
    .catch(function (error) {
    console.log(error);
});
}

    function animateNumber(elementId, start, end, duration) {
    const element = document.getElementById(elementId);
    if (!element) {
    console.error('Element not found with ID:', elementId);
    return;
}

    let startTime = null;

    function updateNumber(currentTime) {
    if (!startTime) {
    startTime = currentTime;
}

    const elapsedTime = currentTime - startTime;
    const fraction = elapsedTime / duration;

    if (fraction < 1) {
    let currentNumber = start + (end - start) * easeInOutQuad(fraction);
    element.textContent = Math.round(currentNumber);
    requestAnimationFrame(updateNumber);
} else {
    element.textContent = end;
}
}

    function easeInOutQuad(t) {
    return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
}

    requestAnimationFrame(updateNumber);
}


    function selectProcentBalance(procent) {

    let balance = document.getElementById('balance').value;
    let amount = balance * procent / 100;
    document.getElementsByName('amount')[0].value = amount.toFixed(2);
    const element = document.getElementById('amount_el')
    inactiv_is_still_empty('btn_step2', element)
}


    {{--        @if(Auth::user() &&  Auth::user()->open_deal)--}}

    {{--        @if($type === 'crypto' && $open_order->status == 4)--}}
    {{--        changeStatusTransaction(5)--}}
    {{--        @endif--}}
    {{--        const elements = document.querySelectorAll('.close');--}}
    {{--        const elements_modal = document.querySelectorAll('.close_modal');--}}
    {{--        elements_modal.forEach((el) => {--}}
    {{--            el.removeAttribute('onclick')--}}
    {{--        });--}}
    {{--        elements.forEach((el) => {--}}
    {{--            el.classList.add('hidden');--}}
    {{--        });--}}
    {{--        @endif--}}


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
    formData.append('amount', document.getElementById('amount').value ? document.getElementById('amount').value : document.getElementsByName('amount')[0].value)
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

    function createDeposit() {
    const formData = new FormData(TradeForm)
    formData.append('currency', {{$cur_from['id']}})
    formData.append('amount', document.getElementById('amount').value)
    formData.append('transaction_id', document.getElementById('transaction_id').value)
    axios.post('/deposit/create', formData)
    .then(function (response) {
    changeStatusTransaction(4)
})
    .catch(function (error) {
    console.log(error);
});
}

    function inactiv_is_still_empty(el_id_inactive, el_validate){
    const el = document.getElementById(el_id_inactive)
    if(el_validate.value === ''){
    el.disabled = true
}else{
    el.disabled = false
}
}

    function resetAllData() {
    document.getElementById('amount').value = ''
    document.getElementById('amount_el').value = ''
    document.getElementById('file_input').disabled = true
    document.getElementById('file_input').setAttribute('type', 'button')
    document.getElementById('receipt').value = ''
    step = 1
    hiddenAllStep()

}
    function copy_text(id) {
    const el = document.querySelector('.copy')
    const text = el.value;
    navigator.clipboard.writeText(text)
    .then(() => {
    console.log('Text copied to clipboard');
})
    .catch((error) => {
    console.error('Error copying text: ', error);
});
}
