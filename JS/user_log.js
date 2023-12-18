

let container = document.getElementById('cont-input-id');
let divider = document.getElementById('log-div-id');
let log_input_a = document.getElementById('log-input-id-a');
let log_input_b = document.getElementById('log-input-id-b');
let reg = document.getElementById('register');
let h1 = document.getElementById('h1-id');
let log_in_button = document.getElementById('login-button-id');

let log = document.getElementById('login');
let sign_up_button = document.getElementById('signup-button-id');

let label_a = document.getElementById('label-a');
let label_b = document.getElementById('label-b');
let label_c = document.getElementById('label-c');
let label_d = document.getElementById('label-d');

let reg_input_a = document.getElementById('reg-input-a');
let reg_input_b = document.getElementById('reg-input-b');
let reg_input_c = document.getElementById('reg-input-c');
let reg_input_d = document.getElementById('reg-input-d');

let log_button = document.getElementById('login-button-id');
let reg_button = document.getElementById('signup-button-id');
if (document.getElementById('error-reg-id').innerHTML != ''){
    ToggleRegister();
}
function ToggleRegister() {
    log_button.disabled = true;
    reg_button.disabled = false;
    container.style.top = '-225px';
    divider.classList.toggle('divider-enabled');

    log_input_a.style.width = '0px';
    log_input_b.style.width = '0px';
    log_input_a.style.height = '0px';
    log_input_b.style.height = '0px';


    reg_input_a.style.width = '300px';
    reg_input_a.style.height = '40px';
    reg_input_b.style.width = '300px';
    reg_input_b.style.height = '40px';
    reg_input_c.style.width = '300px';
    reg_input_c.style.height = '40px';
    reg_input_d.style.width = '300px';
    reg_input_d.style.height = '40px';

    h1.style.fontSize = '0px';
    h1.style.marginTop = '-35px';

    reg.style.top = '-100px';

    log_in_button.style.height = '0px';
    log_in_button.style.width = '0px';

    log.style.opacity = '1';
    log.style.bottom = '-100px';
    log.style.zIndex = '1';

    sign_up_button.style.height = '50px';
    sign_up_button.style.width = '230px';
    label_a.style.opacity = '1';
    label_b.style.opacity = '1';
    label_c.style.opacity = '1';
    label_d.style.opacity = '1';

}

function ToggleLogin() {
    log_button.disabled = false;
    reg_button.disabled = true;
    label_a.style.opacity = '0';
    label_b.style.opacity = '0';
    label_c.style.opacity = '0';
    label_d.style.opacity = '0';

    container.style.top = '0px';
    divider.classList.toggle('divider-enabled');

    log_input_a.style.width = '300px';
    log_input_b.style.width = '300px';
    log_input_a.style.height = '40px';
    log_input_b.style.height = '40px';
    reg_input_a.style.width = '0px';
    reg_input_a.style.height = '0px';
    reg_input_b.style.width = '0px';
    reg_input_b.style.height = '0px';
    reg_input_c.style.width = '0px';
    reg_input_c.style.height = '0px';
    reg_input_d.style.width = '0px';
    reg_input_d.style.height = '0px';
    h1.style.fontSize = '50px';
    h1.style.marginTop = '15px';


    reg.style.top = '-40px';


    log_in_button.style.height = '50px';
    log_in_button.style.width = '230px';

    log.style.transitionDelay = '0s';
    log.style.opacity = '-';
    log.style.bottom = '-75px';
    log.style.zIndex = '-3';

    sign_up_button.style.height = '0px';
    sign_up_button.style.width = '0px';
}