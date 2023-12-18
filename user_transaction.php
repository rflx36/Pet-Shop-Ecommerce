<?php



include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();


if (!isset($_SESSION['user_logged_in'])) {
    header("Location: user_login.php");
} else {
    if (!$_SESSION['user_logged_in']) {
        header("Location: user_login.php");
    }
}

if (!isset($_SESSION['transact_session_id'])) {
    header("Location: user_cart.php");
} else {
    unset($_SESSION['transact_session_id']);
}

$notify_value = '';
if (isset($_SESSION['action-notify'])) {

    $notify_value = $_SESSION['action-notify'];

    unset($_SESSION['action-notify']);
}



if (isset($_POST["invalid-resp"])) {
    $_SESSION['action-notify'] ='proccesing unfinished';
    unset($_POST["invalid-resp"]);

    $_SESSION['transact_session_id'] = 1;
    header("Location: user_transaction.php");
}

if (isset($_POST["confirm-transaction"])) {

    $_SESSION['transact_session_id'] = 1;
    date_default_timezone_set('Asia/Manila');

    $_SESSION['action-notify'] = $_POST["confirm-transaction"];
    unset($_POST["confirm-transaction"]);
    $c_DT = new DateTime();
    $u_mop_c = (isset($_POST['t-mop-iscash']));
    unset($_POST['t-mop-iscash']);


    $u_id = $_SESSION['user_id'];
    $c_id = $_SESSION['user_cart_id'];
    $u_TD = $c_DT->format('Y-m-d H:i:s');
    $u_TT = $_POST['u-transact-total'];


    $u_umop = ($u_mop_c) ? "Cash On Delivery" : "Credit / Debit Card";
    $u_c_expiry = $_POST['t-card-expiry-date'];
    $o_status = "pending";
    $e_card  = "";
    $e_cvc = "";
    if (!$u_mop_c) {

        $e_card = SetEncrypt(str_replace(' ', '', $_POST['t-card-number']));

        $e_cvc = SetEncrypt($_POST['t-card-cvc']);
    }

    
    $e_contacts = SetEncrypt($_POST['t-contact']);
   
    $e_add_street = SetEncrypt($_POST['t-address-street']);
    $e_add_zip = SetEncrypt($_POST['t-address-zip']);
    $e_add_city = SetEncrypt($_POST['t-address-city']);

    $e_f_name = SetEncrypt($_POST['t-first-name']);
    $e_l_name = SetEncrypt($_POST['t-last-name']);
    $e_email = SetEncrypt($_POST['t-email']);

    try {
        $stmt  = $con->prepare("INSERT INTO fp_users_transaction (user_id, cart_id, user_transaction_date, user_transaction_total, user_email, user_first_name, user_last_name, user_contact, user_address_street, user_address_zip, user_address_city, payment_method, p_card_number, p_expiry_date, p_cvc, transaction_status ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");


        $stmt->bind_param("ssssssssssssssss", $u_id, $c_id, $u_TD, $u_TT, $e_email, $e_f_name, $e_l_name, $e_contacts, $e_add_street, $e_add_zip, $e_add_city, $u_umop, $e_card, $u_c_expiry, $e_cvc, $o_status);
        $stmt->execute();

       
        ResetUserCartSession();
        /*
   $user_dat = mysqli_fetch_assoc($res);
                $contact_val = RequestDecrypt($user_dat["user_contact"]);
                $f_name_val = RequestDecrypt($user_dat["user_first_name"]);
                $l_name_val = RequestDecrypt($user_dat["user_last_name"]);
                $address_street_val = RequestDecrypt($user_dat["user_address_street"]);
                $address_zip_val = RequestDecrypt($user_dat["user_address_zip"]);
                $address_city_val = RequestDecrypt($user_dat["user_address_city"]);
                $email_val = RequestDecrypt($user_dat["user_email"]);
        */
        unset($_SESSION['transact_session_id']);
        
        header("Location: main_products.php");
    } catch (Exception $e) {

        $_SESSION['action-notify']  = "An Error Occured";

        header("Location: user_transaction.php");
    }
}


function ResetUserCartSession()
{
    $con = $GLOBALS['con'];

    unset($_SESSION['user_cart_id']);

    $id =  $_SESSION['user_id'];

    $get_cart_id =
        "SELECT DISTINCT c.cart_id FROM fp_users_cart c LEFT JOIN fp_users_transaction t ON c.cart_id = t.cart_id 
            AND c.user_id = t.user_id WHERE c.user_id = $id AND t.cart_id IS NULL";
    $cart_id = '';
    $result_cart_id = $con->query($get_cart_id);
    if ($result_cart_id && mysqli_num_rows($result_cart_id) > 0) {
        $temp_id_val = mysqli_fetch_assoc($result_cart_id);
        //  $cart_idz = $temp_id_val["cart_id"];

        // $cart_id = mysqli_fetch_column($result_cart_id);
        $temp_id_val = mysqli_fetch_assoc($result_cart_id);
        $cart_id = $temp_id_val["cart_id"];
    }

    $_SESSION['user_cart_id'] = $cart_id;
}


function Display_Products($con)
{
    $value = '';
    $current_cart_id =  $_SESSION['user_cart_id'];

    if ($current_cart_id != '') {
        //current user cart session is not empty


        $products_query =
            "SELECT u.product_amount, u.product_id,  p.product_name, p.product_cost, p.product_image_1, p.product_ratings, p.product_ratings_total 
            FROM fp_users_cart u INNER JOIN fp_products p ON u.product_id = p.product_id WHERE u.cart_id =$current_cart_id";
        $result_products = $con->query($products_query);

        if ($result_products) {


            $p_subtotal = 0;
            $p_vat = 0;
            $p_total = 0;
            $is_empty = true;
            $total_items = 0;
            if ($result_products->num_rows > 0) {
                $product_cont_id = 0;
                $p_total = 0;

                $is_empty = false;
                while ($product = $result_products->fetch_assoc()) {
                    $total_items += 1  * $product["product_amount"];

                    $p_total += $product["product_cost"] * $product["product_amount"];
                    $p_subtotal = $p_total * 0.88;
                    $p_vat = $p_total * 0.12;
                    $product_cont_id++;
                }
            }

            if ($is_empty) {
                header("Location : user_cart.php");
            }

            $value .=
                "
            <div class='my-order-cont'>
                <div class='order-list-cont'>
                        <div class='order-detail'>
                            <p id='order-title'> Order Summary </p>
                            <div class='order-list-items'>
                                <p>Total Items:</p>
                                <p id='total-items-id'>$total_items</p>
                            </div>
                            <div class='order-subtotal'>
                                <p>Subtotal:</p>
                                <p id='subtotal-id'><span>₱ </span>$p_subtotal</p>
                            </div>
                            <div class='order-tax'>
                                <p>VAT (12%):</p>
                                <p id='vat-id'><span>₱ </span>$p_vat</p>
                            </div>
                            <hr>
                            <div class='order-total'>
                                <p>Total:</p>
                                <p id='total-id'><span>₱ </span>$p_total</p>
                            </div>
                            
                        </div>
                    
                      
                    </div>
                </div>
            <div class='action-cont'>
          
                <input id='total-val-inv' name='u-transact-total' value='$p_total' type='number'>
            </div>
            ";
        } else {
            //user cart is empty
        }
    }
    return $value;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>furrpection</title>
    <link rel="stylesheet" href="CSS/main_products.css">

    <link rel="stylesheet" href="CSS/mobile_navbar.css">

    <link rel="stylesheet" href="CSS/main_footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="bg-darker" id='bg-dark'>

    </div>
    <div class="nav-user-cont" id="nav-user-cont-id">
        <a href="main_redirect_products.php">Products</a>
        <a href="main_about.php">About</a>
        <a href="#">Contacts</a>
        <?php
        if (isset($_SESSION['user_logged_in'])) {
            if ($_SESSION['user_logged_in']) {
                echo "
                                    <a href='#'>Account Settings</a>
                                    <a href='#'>Transaction History</a>
                                    <a href='user_cart.php'>My Cart</a>
                                    <a href='user_likes.php'>My Likes</a>
                                    <a href='user_logout.php'>Log out</a>
                                    ";
            } else {
                echo "
                                    <a href='user_login.php'>Log In</a>";
            }
        } else {
            echo "<a href='user_login.php'>Log In</a>";
        }

        ?>

    </div>

    <div class="notifier-cont" onclick="Disable();" id="notifier-cont-login-id">
        <div class="log-in-notifier" id="notifier-cont-id">
            <p> Please log in to proceed. </p>
            <button onclick="AccountLogIn();">
                <p> Log In </p>
            </button>
        </div>
        <?php
        if ($notify_value != '') {
            echo
            "
            <div class='action-notifier' id='action-notifier-id'>
                <p>" . $notify_value . "</p>
            </div>
            ";
        }
        ?>
        <div class="cart-changes-notifier" id='notifier-cont-cart-id'>
            <p> You have unsaved changes </p>
            <div class="cart-button-cont">
                <button onclick="Reset();">
                    <p>Reset</p>
                </button>

                <button id='cart-save' onclick="ConfirmCartChanges();">
                    <p>Save Changes</p>
                </button>
            </div>
        </div>
    </div>
    <div class="navbar">
        <div class="nav-logo-section">
            <h1 onclick="RedirectHome();" id='main-logo-text'>FURRPECTION</h1>
        </div>
        <div class="nav-sections">
            <a href="main_products.php">Products</a>
            <a href="main_about.php">About</a>
            <a href="#">Contacts</a>
        </div>
        <div class="nav-user">
            <?php

            $cart_amount = 0;
            $cart_case = "AccountLogIn();";
            if (isset($_SESSION['user_logged_in'])) {
                if ($_SESSION['user_logged_in'] && isset($_SESSION['user_cart_id'])) {

                    $current_cart_id =  $_SESSION['user_cart_id'];
                    if ($current_cart_id != '') {
                        $user_cart_amount =
                            "SELECT u.product_amount, u.product_id,  p.product_name, p.product_cost, p.product_image_1, p.product_ratings, p.product_ratings_total 
                            FROM fp_users_cart u INNER JOIN fp_products p ON u.product_id = p.product_id WHERE u.cart_id =$current_cart_id";
                        $result_amount = $con->query($user_cart_amount);
                        if ($result_amount) {

                            $cart_amount = $result_amount->num_rows;
                        }
                    }

                    $cart_case = "AccountCart();";
                }
            }

            echo "<div class='nav-cart' onclick='$cart_case'>
                    <img src='CSS/Resources/Images/icon-cart-inverted.png'>
                    <p>$cart_amount </p>
                </div>";


            if (isset($_SESSION['user_logged_in'])) {
                if ($_SESSION['user_logged_in']) {
                    echo "<div class='nav-account' onclick='Account();'>";
                } else {
                    echo "<div class='nav-account' onclick='AccountLogIn();'>";
                }
            } else {
                echo "<div class='nav-account' onclick='AccountLogIn();'>";
            }
            ?>
            <div class="nav-account-dropdown" id="account-dd">
                <a href="#">Account Settings</a>
                <a href="#">Transaction History</a>
                <a href="user_cart.php">My Cart</a>
                <a href="user_likes.php">My Likes</a>
                <a href="user_logout.php">Log out</a>
            </div>
            <img src="CSS/Resources/Images/icon-user-inverted.png">
            <?php
            if (isset($_SESSION['user_logged_in'])) {
                if ($_SESSION['user_logged_in']) {
                    echo "<p>Account</p>";
                } else {
                    echo "<p> Log In </p>";
                }
            } else {
                echo "<p> Log In </p>";
            }

            ?>
        </div>

        <div class="nav-toggler" id="nav-toggler-id" onclick="ToggleNav();">
        </div>

    </div>
    </div>
    <div class="product-user-cart" id='p-user-cart-transaction-cont'>
        <div class="user-location">
            <a href="index.html">Home</a>
            <p>></p>
            <a href="main_products.php">Products</a>
            <p>></p>
            <a href="user_cart.php">My Cart</a>
            <p>></p>
            <a id="current-dir" href="#">Transaction</a>
        </div>
        <div class="products-cont">

            <?php
            $user_id = $_SESSION['user_id'];

            $email_val = "";
            $contact_val = "";
            $f_name_val = "";
            $l_name_val = "";

            $address_street_val = "";
            $address_zip_val = "";
            $address_city_val = "";
            $res = $con->query("SELECT user_email  FROM fp_users WHERE user_id = $user_id");
            
            if ($res && mysqli_num_rows($res) > 0) {
                $user_dat = mysqli_fetch_assoc($res);
                /*
                $contact_val = RequestDecrypt($user_dat["user_contact"]);
                $f_name_val = RequestDecrypt($user_dat["user_first_name"]);
                $l_name_val = RequestDecrypt($user_dat["user_last_name"]);
                $address_street_val = RequestDecrypt($user_dat["user_address_street"]);
                $address_zip_val = RequestDecrypt($user_dat["user_address_zip"]);
                $address_city_val = RequestDecrypt($user_dat["user_address_city"]);
                */  
                $email_val = RequestDecrypt($user_dat["user_email"]);
            }

            $logged_display = " <form method='POST' id='list-cart' autocomplete='off'>
            <div class='my-transaction-cont'>
                <div class='transaction-details-class' id='details-product'>
                    <h1>Personal Details</h1>
                    <div class='details-input-h'>
                        <div class='details-input'>
                            <label>FIRST NAME</label>
                            <input type='text' name='t-first-name' required maxlength='50' value='$f_name_val'>
                        </div>
                        <div class='details-input'>
                            <label>LAST NAME</label>
                            <input type='text' name='t-last-name' required maxlength='50'  value='$l_name_val'>
                        </div>
                    </div>
                    <div class='details-input-h'>
                    <div class='details-input'>
                        <label>EMAIL ADDRESS</label>
                        <input type='email' name='t-email' required maxlength='50' value='$email_val' id='disabled-unchangeable'>
                    </div>
                    <div class='details-input'>
                        <label>PHONE NUMBER</label>
                        <input type='text' name='t-contact' id='contact-input-id'  required maxlength='11'>
                    </div>
                </div>
                </div>
                <div class='transaction-details-class' id='details-shipping'>
                    <h1>Shipping Details</h1>
                    <div class='details-input'>
                    <label>STREET ADDRESS</label>
                    <input type='text' maxlength='255' required name='t-address-street' value='$address_street_val'>
                    </div>
                    <div class='details-input-h'>
                        <div class='details-input'>
                            <label>ZIP CODE</label>
                            <input type='text' maxlength='255' required name='t-address-zip' value='$address_zip_val'>
                        </div>
                        <div class='details-input'>
                            <label>CITY</label>
                            <input type='text' maxlength='255' required name='t-address-city' value='$address_city_val'>
                        </div>
                    </div>
                </div>
                <div class='transaction-details-class' id='details-payment'>
                    <h1>Payment Method</h1>
                    <div class='details-input-p'  onclick='TogglePaymentMethod(false);'>
                        <input name='t-mop-iscash' id='input-payment-a' type='radio'  checked  >
                        <label id='payment-method-a' style='color:#EB5749;' >Cash On Delivery</label>
                    </div>
                    <div class='details-input-p' onclick='TogglePaymentMethod(true);'>
                        <input id='input-payment-b'type='radio' >
                        <label id='payment-method-b' >Credit or Debit Card</label>
                    </div>

                    <h1 id='card-title-id' >Payment Details</h1>
                    <div class='details-input-h' id='card-details-input-id'>
                        <div class='details-input' id='d-i-3'>
                            <label>CARD NUMBER</label>
                            <input id='card-number' name='t-card-number' inputmode='numeric' maxlength='19'placeholder='XXXX XXXX XXXX XXXX' oninput='formatCardNumber(event)'>
                        </div>
                        <div class='details-input' id='d-i-2'>
                            <label>EXPIRY DATE</label>
                            <input id='expiry-date' name='t-card-expiry-date' placeholder='MM/YY' type='month'    >
                        </div>
                        <div class='details-input' id='d-i-1'>
                            <label>SECURITY CODE</label>
                            <input id='security-code' name='t-card-cvc' type='text' placeholder='CVC'  maxlength='3' >
                        </div>
                    
                    </div>
                    
                </div>

                <div class='payment-confirm-transaction' onclick='ValidateTransactionInfo();'>
                    <p>Confirm Payment</p>
                </div>

                <button id='payment-submit-id' type='submit' value='Successfully Placed Order' name='confirm-transaction'>
                </button>
            </div>
            
            
            
            ";
            $logged_display_end = "
            
            </form>";
            $display = Display_Products($con);
            echo $logged_display . $display . $logged_display_end;

            ?>

        </div>
        <footer class="footer" style="margin-top:150px">
            <div class="container">
                <div class="row">
                    <div class="footer-col">
                        <h4>Furrpection</h4>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Account</a></li>
                            <li><a href="#">Products</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Help?</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Contact</h4>
                        <ul>
                            <li><a href="#"><i class="fa-solid fa-envelope"></i> : furrpection@gmail.com</a></li>
                            <li><a href="#"><i class="fa-solid fa-phone"></i> : +63 951 1605 272</a></li>
                            <li><a href="#"><i class="fa-solid fa-location-dot"></i> : San Jose, Montalban</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Follow Us</h4>
                        <div class="social-links">
                            <a href="#"><i class="fa-brands fa-facebook"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script type="text/javascript" src="JS/user_notif.js"></script>
    <script type="text/javascript" src="JS/user_cart.js"></script>
    <script type="text/javascript" src="JS/user_transaction.js"></script>

    <script type="text/javascript" src="JS/main.js"></script>

    <script type="text/javascript" src="JS/user_nav_toggler.js"></script>
    <script src="https://kit.fontawesome.com/a1ba985915.js"></script>
</body>

</html>