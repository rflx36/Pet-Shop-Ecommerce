var account_dd_toggle = false;
let acount_dd = document.getElementById('account-dd');
let notif_cont_id = document.getElementById('notifier-cont-id');
let notif_cont_log_id = document.getElementById('notifier-cont-login-id');
let bg_dark = document.getElementById('bg-dark');

function Account() {

    if (account_dd_toggle) {
        account_dd_toggle = false;
        acount_dd.style.height = "0px";
        acount_dd.style.padding = "0px";
        acount_dd.style.borderRadius = "5px";

    } else {
        account_dd_toggle = true;

        acount_dd.style.height = "200px";

        acount_dd.style.paddingTop = "10px";
        acount_dd.style.paddingBottom = "10px";
        acount_dd.style.borderRadius = "15px";
    }

}

function AccountLogIn() {
    window.location.href = "user_login.php";
}

function AccountCart() {
    window.location.href = "user_cart.php";
}
function Login() {
    notif_cont_id.style.transform = "translateY(-10px)";
    console.log("Login to proceed");

    bg_dark.style.opacity = "0.25";
    notif_cont_log_id.style.pointerEvents = "all";
}

function Disable() {
    // notif_cont_log_id.style.display = "none";

    bg_dark.style.opacity = "0";

    notif_cont_log_id.style.pointerEvents = "none";
    notif_cont_id.style.transform = "translateY(50px)";


}