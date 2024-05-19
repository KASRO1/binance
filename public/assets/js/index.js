function tabsSwitcher(data, prevStep, nextStep_id, timeout = 0, submit = false) {

    const element = data.element;
    element.innerHTML = `
        <div class="bn-spinner__nezha"><div class="nezha-line" style="animation-delay: 50ms;"></div><div class="nezha-line" style="animation-delay: 100ms;"></div><div class="nezha-line" style="animation-delay: 150ms;"></div><div class="nezha-line" style="animation-delay: 200ms;"></div></div>
        `;
    setTimeout(() => {
        document.getElementById(prevStep).classList.add("hidden");
        document.getElementById(nextStep_id).classList.remove("hidden");
        element.innerHTML = data.text;
        if (submit) {
            element.setAttribute('type', 'submit');
        }
    }, timeout);

}

function scrollTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
}



function showModalExchange(el, timeout = 100, order_id = null, step = 1) {
    const body = document.querySelector("body");
    body.classList.add("overflow-hidden");
    const modal = document.getElementById("modalTrade");
    modal.classList.add("block");
    hiddenAllStep()
    updateData(order_id);
    showStep(step)
    modal.classList.remove("hidden");
    setTimeout(() => {
        scrollTop();
        modal.classList.add("active");
    }, timeout);
}
function hiddenAllStep() {
    document.getElementById('infoExchange').classList.add('hidden');
    document.getElementById('paymentExchange').classList.add('hidden');
    document.getElementById('documentUpload').classList.add('hidden');
    document.getElementById('loadingExchange').classList.add('hidden');
    document.getElementById('successExchange').classList.add('hidden');
    document.getElementById('errorExchange').classList.add('hidden');
}

function setLoading(el) {
    el.innerHTML = `
        <div class="bn-spinner__nezha"><div class="nezha-line" style="animation-delay: 50ms;"></div><div class="nezha-line" style="animation-delay: 100ms;"></div><div class="nezha-line" style="animation-delay: 150ms;"></div><div class="nezha-line" style="animation-delay: 200ms;"></div></div>
        `;
}

function closeModalExchange() {
    const body = document.querySelector("body");
    body.classList.remove("overflow-hidden");
    const modal = document.getElementById("modalTrade");
    modal.classList.remove("active");
    setTimeout(() => {
        modal.classList.add("hidden");
        modal.classList.remove("block");
    }, 100);
}

function showModalProfileContent(el, timeout = 100) {
    const body = document.querySelector("body");
    body.classList.add("overflow-hidden");
    const modal = document.getElementById("modalProfileContent");
    modal.classList.add("block");
    modal.classList.remove("hidden");
    setTimeout(() => {
        scrollTop();
        modal.classList.add("active");
    }, timeout);
}

function closeModalProfileContent() {
    const body = document.querySelector("body");
    body.classList.remove("overflow-hidden");
    const modal = document.getElementById("modalProfileContent");
    modal.classList.remove("active");
    setTimeout(() => {
        modal.classList.add("hidden");
        modal.classList.remove("block");
    }, 100);
}

function showAnswerMenu() {
    const menu = document.querySelectorAll('.menu');
    menu.forEach(el => {
        const trigger = el.querySelector('.menu-link')
        trigger.addEventListener('click', () => {
            el.querySelector('.menu-block').classList.toggle('hidden')
        })
    });
}

function validateEmail(value) {
    const email = value;
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
}

async function validate(input, type, url = null, data = null) {
    const el = document.getElementById(input + '_input');
    const error = document.getElementById(input + '_error');
    const value = el.value;

    if (type === "email") {
        if (value === '') {
            error.innerHTML = 'Email is required';
            el.classList.add('error');
            return Promise.resolve(false);
        }
        if (!validateEmail(value)) {
            error.innerHTML = 'Invalid email';
            el.classList.add('error');
            return Promise.resolve(false);
        }
    }
    if (type === 'password_confirm') {
        const password = document.getElementById('password_input')
        const password_confirm = document.getElementById('password_confirm')
        if (password.value !== password_confirm.value) {
            error.innerHTML = 'Passwords do not match';
            el.classList.add('error');
            return Promise.resolve(false);
        }
    }
    if (type === "password") {
        if (value === '') {
            error.innerHTML = 'Password is required';
            el.classList.add('error');
            return Promise.resolve(false);
        }
        if (value.length < 6) {
            error.innerHTML = 'Password must be at least 6 characters';
            el.classList.add('error');
            return Promise.resolve(false);
        }
    }

    if (type === "exist_email" || type === "not_exist_email") {
        let array = {
            type: 'email',
            value: value
        };
        return axios.post(url, array).then(response => {
            if ((type === "exist_email" && response.data.exist) || (type === "not_exist_email" && !response.data.exist)) {
                error.innerHTML = type === "exist_email" ? 'Email is already taken' : 'Email does not exist';
                el.classList.add('error');
                return false;
            }
            return true;
        }).catch(err => {
            console.log(err);
            return false;
        });
    }

    return Promise.resolve(true);
}

let timeot = null;

function existPromocode(url) {

    const el = document.getElementById('promocode');
    const info = document.getElementById('promocode_info');
    const promocode = el.value;
    info.innerHTML = '     <div class="bn-spinner__nezha">\n' +
        '                        <div class="nezha-line" style="animation-delay: 50ms; background: white"></div>\n' +
        '                        <div class="nezha-line" style="animation-delay: 100ms; background: white"></div>\n' +
        '                        <div class="nezha-line" style="animation-delay: 150ms; background: white"></div>\n' +
        '                        <div class="nezha-line" style="animation-delay: 200ms; background: white"></div>\n' +
        '                    </div>';

    if (timeot) {
        clearTimeout(timeot);
    }
    timeot = setTimeout(() => {
        axios.post(url, {promocode: promocode}).then(response => {
            const select = document.querySelector('[name="currency"]');
            if (response.data.exist) {
                info.innerHTML = response.data.message;
                select2.value = response.data.currency;
                select.value = response.data.currency;
                select.setAttribute('data-index', 0)
                select.innerHTML = response.data.currency;
                select.disabled = true;
            } else {
                info.innerHTML = '';
                select.removeAttribute('disabled') ;
            }

        }).catch(err => {
            console.log(err);

        });
    }, 500);
}
