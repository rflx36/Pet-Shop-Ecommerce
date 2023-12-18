

const ccInputElement = document.querySelector('#card-number');
let cvcInput = document.getElementById('security-code');
let contactInput = document.getElementById('contact-input-id');
contactInput.addEventListener('input', function(event) {
    let input = event.target;
    input.value = input.value.replace(/\D/g, '');
});

cvcInput.addEventListener('input', function(event2) {
    let input2 = event2.target;
    input2.value = input2.value.replace(/\D/g, '');
});


ccInputElement.format = () => {
    let cursorPosition = ccInputElement.selectionStart;
    let partBeforeCursorPosition = ccInputElement.value.substring(0, cursorPosition);
    let partAfterCursorPosition = ccInputElement.value.substring(cursorPosition);

    const originalLength = partBeforeCursorPosition.length;
    partBeforeCursorPosition = partBeforeCursorPosition.replace(/\s/gi, '');
    cursorPosition -= originalLength - partBeforeCursorPosition.length;
    partAfterCursorPosition = partAfterCursorPosition.replace(/\s/gi, '');
    const ccNumber = partBeforeCursorPosition + partAfterCursorPosition;

    const parts = ccNumber.match(/.{1,4}/g);

    ccInputElement.value = parts?.join(' ') || '';
    cursorPosition += Math.floor(cursorPosition * 1 / 4);
    ccInputElement.setSelectionRange(cursorPosition, cursorPosition);
};

ccInputElement.addEventListener('input', ccInputElement.format);

ccInputElement.addEventListener('keydown', event => {
    const cursorPosition = ccInputElement.selectionStart;

    if (event.key == 'Backspace') {
        if (cursorPosition == ccInputElement.selectionEnd
            && ccInputElement.value[cursorPosition - 1] == ' ') {
            event.preventDefault();
            const newCursorPosition = cursorPosition - 2;
            ccInputElement.value = ccInputElement.value.substring(0, newCursorPosition) + ccInputElement.value.substring(cursorPosition);
            ccInputElement.setSelectionRange(newCursorPosition, newCursorPosition);
            ccInputElement.format();
        }
    }
    else if (event.key == 'ArrowRight') {
        if (ccInputElement.value[cursorPosition + 1] == ' ') {
            const newCursorPosition = cursorPosition + 1;
            ccInputElement.setSelectionRange(newCursorPosition, newCursorPosition);
        }
    }
    else if (event.key == 'ArrowLeft') {
        if (ccInputElement.value[cursorPosition - 1] == ' ') {
            const newCursorPosition = cursorPosition - 1;
            ccInputElement.setSelectionRange(newCursorPosition, newCursorPosition);
        }
    }
});


function formatCardNumber(event) {
    let input = event.target;
    let value = input.value.replace(/\D/g, '');
    input.value = value;
}



let c_pass = false;

function TogglePaymentMethod(IsCash) {
    let p_m_a = document.getElementById('payment-method-a');
    let p_m_b = document.getElementById('payment-method-b');
    c_pass = IsCash;

    p_m_a.style.color = (IsCash) ? "#2a2a2a87" : "#EB5749";
    p_m_b.style.color = (!IsCash) ? "#2a2a2a87" : "#EB5749";

    document.getElementById('input-payment-a').checked = !IsCash;
    document.getElementById('input-payment-b').checked = IsCash;
    let c_details_title = document.getElementById('card-title-id');
    let c_details_input = document.getElementById('card-details-input-id');

    let p_details_cont = document.getElementById('card-details-input-id');

    p_details_cont.style.opacity = (IsCash) ? "1" : "0";

    p_details_cont.style.height = (IsCash) ? "65px" : "0px";
    document.getElementById('card-title-id').style.opacity = (IsCash)?"1":"0";

    if (!IsCash) {
        

        document.getElementById('card-number').removeAttribute('required');

        document.getElementById('expiry-date').removeAttribute('required');

        document.getElementById('security-code').removeAttribute('required');
    }
    else {

        document.getElementById('card-number').setAttribute('required', '');

        document.getElementById('expiry-date').setAttribute('required', '');

        document.getElementById('security-code').setAttribute('required', '');
    }
}

let p_submit = document.getElementById('payment-submit-id');
function ValidateTransactionInfo(){
    let cInput = document.getElementById('contact-input-id');
    if (c_pass){
        if (ccInputElement.value.length != 19){
            TriggerInvalidResponse("Invalid Card Number");
            return;
        }
        
        if (cvcInput.value.length != 3){
            TriggerInvalidResponse("Invalid CVC");
            return;
        }
    }

    if (cInput.value.length != 11){
        TriggerInvalidResponse("Invalid Phone Number ");
        return;
    }
    
    p_submit.click();
}

function TriggerInvalidResponse(response){
   p_submit.name = 'invalid-resp';
   p_submit.value = response;
   p_submit.click();
}