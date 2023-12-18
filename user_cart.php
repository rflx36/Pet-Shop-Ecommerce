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

if (isset($_GET['checkout'])) {
    $_SESSION['transact_session_id'] = 1;
    unset($_GET['checkout']);
    header("Location: user_transaction.php");
}

if (isset($_GET['invalid'])) {
    echo "Cart is Empty";
}

$notify_value = '';

if (isset($_SESSION['action-notify'])) {

    $notify_value = $_SESSION['action-notify'];

    unset($_SESSION['action-notify']);
}




if (isset($_GET['action-submit'])) {

    //$query = $_POST['action-query'];

    if (empty($_GET['action-query'])) {

        header("Location: user_cart.php");
        die;
    }
    $actionQuery = $_GET['action-query'];

    //echo $actionQuery;

    $actionQuery = str_replace('s&?!Us', 'update fp_users_cart set product_amount = ', $actionQuery);

    $actionQuery = str_replace('U&?!dU', 'delete from fp_users_cart ', $actionQuery);

    $actionQuery = str_replace('%wjk??i', ' where', $actionQuery);

    $actionQuery = str_replace('??jk$%i&&', ' and', $actionQuery);


    $actionQuery = str_replace('$cid$$??k', ' cart_id = ', $actionQuery);


    $actionQuery = str_replace('eml2%k?', ' product_id = ', $actionQuery);
    $queries = explode(';', $actionQuery);

    foreach ($queries as $query) {
        $query = trim($query);

        $success = true;

        $flags = 0;
        if (!empty($query)) {
            $stmt = $con->prepare($query);

            if ($stmt) {
                $stmt->execute();

                if ($stmt->errno) {

                    $success = false;
                    $flags++;
                }
                if ($success) {
                    $_SESSION['action-notify'] = "Changes Saved";
                } else {
                    $_SESSION['action-notify'] = "failed (" . $flags . ")";
                }
                $stmt->close();
            } else {
                // Handle errors in preparing the statement
                $_SESSION['action-notify'] = "Failed:" . $con->error;
            }
        }
    }

    /*
    if (strpos($actionQuery, '<uU/>') != false || strpos($actionQuery, '<dD/>')) {
        $actionQuery = str_replace('<uU/>', 'UPDATE fp_users_cart SET product_amount = ', $actionQuery);

        $actionQuery = str_replace('<dD/>', 'DELETE FROM fp_users_cart', $actionQuery);
    }


    if ($con->multi_query($_GET['action-query'])) {
        $success = true;
        $flags = 0;
        do {

            if ($con->errno) {
                $success = false;
                $flags++;
            }
        } while ($con->more_results() && $con->next_result());

        if ($success) {
            $_SESSION['action-notify'] = "Changes Saved";
        } else {
            $_SESSION['action-notify'] = "failed (" . $flags . ")";
        }
    } else {
        $_SESSION['action-notify'] = "Failed:" . $con->error;
    }
    */
    header("Location: user_cart.php");
}

if (isset($_GET['product-load'])) {
    $_SESSION['product-id'] = $_GET['product-load'];
    header("Location: main_products_selected.php");
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

            $value .=
                "
                
                <div class='my-cart-cont'>
                <div class='cart-product-info-cont'>
                        <p id='label-details'>Product Details</p>
                        <p id= 'label-quantity'>Quantity</p>
                        <p id= 'label-total' >Total</p>
                        <p id= 'label-empty' ></p>
                    </div>
            ";
            $c = 0;
            $p_subtotal = 0;
            $p_vat = 0;
            $p_total = 0;
            $is_empty = true;
            $total_items = 0;
            if ($result_products->num_rows > 0) {
                $product_cont_id = 0;
                $p_total = 0;
                $c = 1;

                while ($product = $result_products->fetch_assoc()) {
                    if ($is_empty) {
                        $is_empty = false;
                    }
                    $total_items += 1  * $product["product_amount"];
                    $p_id = $product['product_id'];
                    $p_cost = $product["product_cost"];
                    $p_total += $product["product_cost"] * $product["product_amount"];
                    $p_subtotal = $p_total * 0.88;
                    $p_vat = $p_total * 0.12;
                    $value .= "
                    <div class='cart-product-cont-whole'>
                        
                        <div class='cart-product-cont' id='product-cont-$product_cont_id' >
                            
                                <div class='cart-product-details'>
                                    <button style='background-image: url(CSS/Resources/ProductImages/" . $product["product_image_1"] . ")' class='cart-product-img' type='submit' name='product-load' value='" . $product["product_id"] . "' >

                                    </button>
                                    <div class='cart-product-name-cost'>
                                        <p> " . $product["product_name"] . "</p>
                                        <p class='price' ><span>₱</span> " . $product["product_cost"] . "</p>
                                    </div>
                                </div>
                                <div class='cart-product-amount-cont'>
                                    <div class='product-deduct' onclick='productDeduct($p_id,$current_cart_id,$product_cont_id,$p_cost);'></div>
                                    <input class='product-amount-class' onblur='RestrictInput($p_id)' type='number' value='" . $product["product_amount"] . "' id='" . $p_id . "-amount-id'>
                                    <div class='product-add' onclick='productAdd($p_id,$current_cart_id,$product_cont_id,$p_cost)'></div>
                                </div>
                                <div class='cart-product-cost'>
                                    <p id='cart-product-total-$product_cont_id'><span>₱</span><input class='product-value-class' type='number' disabled value='" . ($product["product_cost"] * $product["product_amount"]) . "'> </p>
                                </div>
                                    <div class='cart-product-delete' onclick='productDelete($p_id,$current_cart_id,$product_cont_id);'>
                                </div>
                        
                        </div>
                        <div class='cart-product-placeholder' id='product-placeholder-$product_cont_id'>
                           
                        </div>
                        <div class='cart-product-placeholder-solid' id='product-placeholder-solid-$product_cont_id'>
                        </div>
                    </div>
                    ";
                    $product_cont_id++;
                }
            }
            $button_disable = "onclick='ConfirmCheckout($c);'";

            if ($is_empty) {
                $button_disable = "style='cursor:not-allowed;user-select:none;opacity:0.5;' title='Your Cart Is Empty'";

                $value .= "<div class='cart-empty' id='re-center-empty'>
                <p> Oh no! Your pet's wishlist is empty. Time to fill it with pawsome accessories they'll adore!</p>
                <a href='main_products.php'>Explore Now </a>
                </div> ";
            }

            $value .=
                "
            </div>
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
                        <div class='order-checkout-button' $button_disable >
                            <p>Checkout</p>
                        </div>
                        <button id='order-confirmed-checkout' type ='submit' name='checkout'>
                        </button
                    </div>
                </div>
            <div class='action-cont'>
                <textarea id='user-action-query-id' name='action-query'></textarea>
                <input type='submit' id='user-action-submit' name='action-submit'>
            </div>
            ";
        } else {
        }
    } else {
        $value .= "<div class='cart-empty'>
        <p> Oh no! Your pet's wishlist is empty. Time to fill it with pawsome accessories they'll adore!</p>
        <a href='main_products.php'>Explore Now </a>
        </div> ";
    }
    return $value;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>furrpection</title>
    <link rel="stylesheet" href="CSS/main_products.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="CSS/mobile_navbar.css">
    
    <link rel="stylesheet" href="CSS/main_footer.css">
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
    <div class="product-user-cart">
        <div class="user-location">
            <a href="index.html">Home</a>
            <p>></p>
            <a href="main_products.php">Products</a>
            <p>></p>
            <a id="current-dir" href="#">My Cart</a>

        </div>
        <div class="products-cont">

            <?php

            $logged_display = " <form method='GET' id='list-cart' >";
            $logged_display_end = "
            
            </form>";
            $display = Display_Products($con);
            echo $logged_display . $display . $logged_display_end;

            ?>

        </div>
        <footer class="footer">
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

    <script type="text/javascript" src="JS/main.js"></script>
    
    <script type="text/javascript" src="JS/user_nav_toggler.js"></script>
    <script>
        ResetAction();
    </script>
        <script src="https://kit.fontawesome.com/a1ba985915.js"></script>

</body>

</html>