
let modified_p = [];
let mod_dp = [];
let p_query = [];
var p_d_query = [];

let a = "??jk$%i&&", w = "%wjk??i";
let wc_id = w + "$cid$$??k";
let ap_id = a + "eml2%k?";
var cart_notif_triggered = false;
function Reset(){
    window.location.href = "user_cart.php";
}

function ConfirmCartChanges(){
    /*
    let modify = new Promise(function(resolve,reject){
        UpdateProductModif();
        resolve();
    });
    await modify;
    */
    UpdateProductModif();
    var confirm_submit = document.getElementById('user-action-submit');
   confirm_submit.click();
}
function TriggerCartNotif(){
    let cart_cont = document.getElementById("notifier-cont-cart-id");
    cart_cont.style.transform = "translateY(-10px)";
}

function ResetAction(){
    
    document.getElementById('user-action-query-id').value = '';
}
function UpdateProductModif() {
    

    var textarea = document.getElementById('user-action-query-id');
    textarea.value = '';
    for (var i = 0; i < modified_p.length; i++) {
        textarea.value += "s&?!Us" + p_query[i] + "\n";
    }
    for (var i = 0; i < p_d_query.length; i++) {
        textarea.value += "U&?!dU" + p_d_query[i] + "\n";
    }
}
function productDeduct(pID, cID,pc_ID,p_cost) {

    if (mod_dp.includes(pID)){
        return;
    }
    if (!cart_notif_triggered){
        cart_notif_triggered = true;
        TriggerCartNotif()
    }

    var temp_pID = document.getElementById(pID + '-amount-id');
    
    if (temp_pID.value > 1) {
        temp_pID.value = parseInt(temp_pID.value) - 1;
       
        
        if (modified_p.includes(pID)) {
            p_query[modified_p.indexOf(pID)] = temp_pID.value + wc_id + cID + ap_id + pID + ";";
        } else {
            modified_p.push(pID);
            p_query.push(temp_pID.value + wc_id + cID + ap_id + pID + ";");
        }
        var temp_total =document.getElementById('cart-product-total-'+pc_ID);
       
        temp_total.innerHTML = "<span>₱</span><input class='product-value-class' type='number' disabled value='"+temp_pID.value  * p_cost+"'>";
        SetTotal();
    }
}
function productAdd(pID, cID,pc_ID,p_cost) {
    if (mod_dp.includes(pID)){
        return;
    }
    if (!cart_notif_triggered){
        cart_notif_triggered = true;
        TriggerCartNotif()
    }

    var temp_pID = document.getElementById(pID + '-amount-id');
    temp_pID.value = parseInt(temp_pID.value) + 1;
    

    if (modified_p.includes(pID)) {
        p_query[modified_p.indexOf(pID)] = temp_pID.value + wc_id + cID + ap_id + pID + ";";

    } else {
        modified_p.push(pID);
        p_query.push(temp_pID.value + wc_id + cID + ap_id + pID + ";");
    }
    
    var temp_total =document.getElementById('cart-product-total-'+pc_ID);
    
    temp_total.innerHTML = "<span>₱</span><input class='product-value-class' type='number' disabled value='"+temp_pID.value  * p_cost+"'>";
    SetTotal();
}

function productDelete(pID, cID,pc_ID) {
    if (!cart_notif_triggered){
        cart_notif_triggered = true;
        TriggerCartNotif()
    }

    var prod_placeholder = document.getElementById('product-placeholder-'+pc_ID);
    var prod_placeholder_solid =document.getElementById('product-placeholder-solid-'+pc_ID);
    var prod_cont = document.getElementById('product-cont-'+pc_ID);

    
    prod_placeholder.style.height ="0px";
    
    prod_placeholder_solid.style.height ="0px";

    prod_cont.style.height="0px";
    prod_cont.style.opacity = "0";
    prod_cont.style.pointerEvents = "none";
    p_d_query.push(wc_id + cID + ap_id + pID + ";")
    mod_dp.push(pID);
    
    
    var temp_total =document.getElementById('cart-product-total-'+pc_ID);
    var temp_amount = document.getElementById(pID+'-amount-id');
    setTimeout(() => {
        temp_total.innerHTML = "<span>₱</span><input class='product-value-class' type='number' disabled value='0'>";
        temp_amount.value = 0;
        SetTotal();
    },300);
    
}

function RestrictInput(pID) {
    var pinput = document.getElementById(pID + '-amount-id');
    if (!cart_notif_triggered){
            cart_notif_triggered = true;
    }
    inputValue = pinput.value;
    inputValue = inputValue.replace(/^0+/, '');

    inputValue = inputValue.replace(/[^0-9-]+/g, '');

    inputValue = inputValue.replace(/^-/, '');
    inputValue = inputValue.replace(/^0*$/, '1');

    pinput.value = inputValue
}


var UpdateNotif = false;

function TriggerUpdateNotif() {
    if (UpdateNotif) {
        return
    }

    UpdateNotif = true;
    //notif style code update
}


function SetTotal(){
    var subtotal_cost_label = document.getElementById('subtotal-id');
    
    var total_cost_label = document.getElementById('total-id');
    var tax_cost_label = document.getElementById('vat-id');

    var val_subtotal = RecalculateTotal(true).toFixed(2);
    var val_total = RecalculateTotal(false).toFixed(2); 
    subtotal_cost_label.innerHTML ="<span>₱ </span>"+val_subtotal;
    total_cost_label.innerHTML = "<span>₱ </span>"+ val_total;
    
    tax_cost_label.innerHTML = "<span>₱ </span>"+ (val_total - val_subtotal).toFixed(2);;

    
}

function RecalculateTotal(value_case){
    var p_v_arr = document.getElementsByClassName('product-value-class');
    
    var p_a_arr = document.getElementsByClassName('product-amount-class');
    var total = 0;
    //console.log(p_v_arr);
    var total_items = 0;
    for (var i = 0 ; i < p_v_arr.length ; i++){
        
        total += parseInt(p_v_arr[i].value);
        //console.log(p_v_arr[i]);
        total_items += parseInt(p_a_arr[i].value);
    }
    var total_dat = total ;
    if (value_case){
         total_dat = (total * 0.88);
    }
   
    document.getElementById('total-items-id').innerHTML = total_items;
    return total_dat;
   
}



var RemindNotifStart = true;
function RemindNotif(){
    let cart_cont = document.getElementById("notifier-cont-cart-id");
    
    if (RemindNotifStart){
        RemindNotifStart = false;
            
        cart_cont.style.animationName = "none"; 
        void cart_cont.offsetWidth;
        cart_cont.style.animationName = "ContShake";    
        setTimeout(() => {
            RemindNotifStart = true;
        }, 800);
    }
    
}


function ConfirmCheckout(session){
    
    let checkout_proceed = document.getElementById('order-confirmed-checkout');
    if (session == 0){
      checkout_proceed.name = "invalid";
    }

    if (cart_notif_triggered){
        RemindNotif();
    }
    else{
        checkout_proceed.click();
    }
    
}