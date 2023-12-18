
function SetProductSelection(p_id,input_cont){
    var s_cont = document.getElementById('order-cont-bg-id-'+p_id);
    var p_cont = document.getElementById('orders-product-cont-'+p_id);

    /* height: 0%; 
    border-radius: 0px;*/
    s_cont.style.width =  (input_cont.checked)?"100%":"0%";
    s_cont.style.borderRadius = (input_cont.checked)?"15px":"100px";
    
    s_cont.style.opacity =  (input_cont.checked)?"0.5":"0";
    s_cont.style.height = (input_cont.checked)?"100%":"50%";
    
    p_cont.style.transform = (input_cont.checked)?"translateX(20px)":"translateX(0px)";
    p_cont.style.width = (input_cont.checked)?"calc(100% - 60px)":"calc(100% - 40px)";
   
    UpdateMultiApprovalDisplay();
}
let MultiApprovalCont = document.getElementById('action-selection-id');
let MultiApprovalCont_text = document.getElementById('action-selection-p-id');
function UpdateMultiApprovalDisplay(){

    var selected_orders_cont  = document.querySelectorAll('.order-selection-class');
    let selected = [];
    selected_orders_cont.forEach(o_cont => {
  
        if (o_cont.checked){

            selected.push(o_cont.id);
        }
    }); 

    //MultiApprovalCont_text.innerHTML = selected.join(', ');
    console.log(selected.length);
    if (selected.length > 0){
        MultiApprovalCont.style.transform = "translateY(-10px)";
       MultiApprovalCont_text.innerHTML = selected.length+" order selected";
    }
    else{

        MultiApprovalCont.style.transform = "translateY(50px)";
        MultiApprovalCont_text.innerHTML = selected.length+" order selected";
    }



    //document.getElementById('selected-orders-id').value = 
}



function RequestViewOrder(p_id){
    var dat_set = document.getElementById('orders-action-button');

    dat_set.value=p_id;
    dat_set.click();
}

function ToggleBG(){
        
    let bg = document.getElementById('dark-bg');
    bg.style.opacity = "0.25";
    bg.style.pointerEvents = "all";
    console.log("worksfine");
}

function RequestViewCancel(){
    window.location.href = "admin_dashboard_orders.php";
}

function RequestViewCancelHistory(){
    window.location.href = "admin_dashboard_transactions.php";
}


