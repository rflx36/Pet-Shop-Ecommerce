let amount_id = document.getElementById('amount-id');

function AmountDeduct() {
    if (amount_id.value <= 1) {
        return;
    }
    amount_id.value--;
}

function AmountAdd() {
    amount_id.value++;
}


function RestrictInputSelected() {
    var pinput = document.getElementById('amount-id');

    inputValue = pinput.value;
    inputValue = inputValue.replace(/^0+/, '');

    inputValue = inputValue.replace(/[^0-9-]+/g, '');

    inputValue = inputValue.replace(/^-/, '');
    inputValue = inputValue.replace(/^0*$/, '1');

    pinput.value = inputValue
}