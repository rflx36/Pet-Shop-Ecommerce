<?php



include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();


$notify_value = '';
if (isset($_SESSION['action-notify'])) {

    $notify_value = $_SESSION['action-notify'];

    unset($_SESSION['action-notify']);
}

if (isset($_SESSION['product-id'])) {

    $_SESSION['p-id'] = $_SESSION['product-id'];
    unset($_SESSION['product-id']);
}
if (isset($_SESSION['p-id'])) {

    $p_id = $_SESSION['p-id'];
    $query = "SELECT * FROM fp_products WHERE product_id ='$p_id'";


    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {

        $product = mysqli_fetch_assoc($result);
    }
} else {

    header("Location: main_products.php");
}


if (isset($_GET['user-cart'])) {

    $product_cart_id = $_GET['user-cart'];
    unset($_GET['user-cart']); //disables add to cart duplicates when refreshing
    $id = $_SESSION['user_id'];
    $quantity = 1;
    if (isset($_GET['product-quantity-in'])) {
        $quantity = $_GET['product-quantity-in'];
    }
    $get_existing_cart_id = "SELECT DISTINCT c.cart_id FROM fp_users_cart c LEFT JOIN fp_users_transaction t ON c.cart_id = t.cart_id AND c.user_id = t.user_id WHERE c.user_id = $id AND t.cart_id IS NULL";
    $result = $con->query($get_existing_cart_id);

    if ($result && mysqli_num_rows($result) > 0) {
        //current user cart session is not empty
        $temp_id_val = mysqli_fetch_assoc($result);
        $current_cart_id = $temp_id_val["cart_id"];

        //$current_cart_id = mysqli_fetch_column($result);

        $check_product_duplicates = "SELECT * FROM fp_users_cart WHERE cart_id=$current_cart_id AND user_id=$id AND product_id=$product_cart_id";
        echo $check_product_duplicates;
        $result_cart = $con->query($check_product_duplicates);

        $sql = "INSERT INTO fp_users_cart(cart_id, user_id, product_id, product_amount) VALUES ('$current_cart_id','$id','$product_cart_id',$quantity)";

        if ($result_cart && mysqli_num_rows($result_cart) > 0) {
            //product already exist in user cart
            //appends amount

            $sql = "UPDATE fp_users_cart SET product_amount = product_amount + $quantity WHERE cart_id=$current_cart_id AND user_id=$id AND product_id=$product_cart_id";
        }


        $result_add =  $con->query($sql);
        if ($result_add) {
            $_SESSION['action-notify'] = "Added to Cart";
            header("Location: main_products_selected.php");
        }
    } else {
        //current user cart session is empty
        //creates new cart id

        $sql = "INSERT INTO fp_users_cart(user_id, product_id, product_amount) VALUES ('$id','$product_cart_id',$quantity)";
        $result_add =  $con->query($sql);
        if ($result_add) {

            $_SESSION['action-notify'] = "Added to Cart";




            $get_cart_id =
                "SELECT DISTINCT c.cart_id FROM fp_users_cart c LEFT JOIN fp_users_transaction t ON c.cart_id = t.cart_id 
            AND c.user_id = t.user_id WHERE c.user_id = $id AND t.cart_id IS NULL";
            $cart_id = '';
            $result_cart_id = $con->query($get_cart_id);
            if ($result_cart_id && mysqli_num_rows($result_cart_id) > 0) {
                $temp_id_val = mysqli_fetch_assoc($result_cart_id);
                $cart_id = $temp_id_val["cart_id"];

                // $cart_id = mysqli_fetch_column($result_cart_id);
            }
            $_SESSION['user_cart_id'] = $cart_id;

            header("Location: main_products.php");
        }
    }
}
if (isset($_SESSION['update-q'])) {
    echo $_SESSION['update-q'];
    unset($_SESSION['update-q']);
}



$user_likes = array();
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $query_id = "SELECT product_id FROM `fp_user_likes` WHERE user_id=$id";

    $result_id = mysqli_query($con, $query_id);
    if ($result_id && mysqli_num_rows($result_id) > 0) {
        while ($likes = mysqli_fetch_assoc($result_id)) {
            $user_likes[] = $likes['product_id'];
        }
    }
}


if (isset($_GET['user-like'])) {
    $product_cart_id = $_GET['user-like'];

    $id = $_SESSION['user_id'];
    $check_duplicates_query = "SELECT * FROM fp_user_likes WHERE user_id = '$id' AND product_id = '$product_cart_id'";

    echo $check_duplicates_query;
    $result = $con->query($check_duplicates_query);
    if ($result && $result->num_rows > 0) {
        $unlike = "DELETE FROM fp_user_likes WHERE user_id=$id AND product_id =$product_cart_id";

        $result_unlike = $con->query($unlike);

        if ($result_unlike) {
            $_SESSION['action-notify'] = "Removed from <a href='user_likes.php'>My Likes</a>";
        } else {
            $_SESSION['action-notify'] = "An Error Occured";
        }
    } else {
        $stmt = $con->prepare("INSERT INTO fp_user_likes(user_id, product_id) VALUES (?,?)");
        $stmt->bind_param("ss", $id, $product_cart_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $_SESSION['action-notify'] = "Added to <a href='user_likes.php'>My Likes</a>";
    }

    header("Location: main_products_selected.php");
}

?>







<!DOCTYPE html>
<html>

<head>
    <title>furrpection</title>
    <link rel="stylesheet" href="CSS/main_products.css">

    <link rel="stylesheet" href="CSS/main_products_selected_over.css">

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
                <p> LOG IN </p>
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
    <div class="user-location" id="user-location-id">
        <a href="index.html">Home</a>
        <p>></p>
        <a href="main_products.php">Products</a>
        <p>></p>
        <a id="current-dir" href="#"><?php echo substr($product["product_name"], 0, 15) . "..."; ?></a>

    </div>
    <div class="main-product">
        <div class="product-image-cont">
            <?php




            $display =
                "
            <div class='image-main'>
                <div class='img' style='background-image:url(CSS/Resources/ProductImages/" . $product["product_image_1"] . ")'> </div>
            </div>
            ";

            echo $display;
            ?>
        </div>
        <div class="product-details-cont">
            <?php
            if ($product["product_ratings"] == 0 && $product["product_ratings_total"] == 0) {
                $width_value = "0px";
            } else {
                $width_value = strval(intval(15 * ($product["product_ratings_total"] / $product["product_ratings"]))) . "px";
            }

            $logged_in = false;
            if (isset($_SESSION['user_logged_in'])) {
                if ($_SESSION['user_logged_in']) {
                    $logged_in = true;
                }
            }

            $display =
                "
                <div class='selected-product-details'>
                <h1>" . $product["product_name"] . "</h1>
                <h6>" . $product["product_info"] . "</h6>
                <div class='product-rating'>
                    
                    <div class='product-rating-placeholder'>
                        <div class='product-rating' style='width:" . $width_value . "'></div>
                    </div>
                    <p >" . $product["product_ratings"] . " reviews </p>
                </div>
                <h2><span>₱</span>" . $product["product_cost"] . "</h2>
                </div>

                <div class='selected-product-order'>
                    <form method='GET' action=''>
                        <div class='product-quantity'>
                            <label>Amount</label>
                            <div class='product-deduct'  onclick='AmountDeduct();'></div>
                            <input onblur='RestrictInputSelected()'name='product-quantity-in' type='number' value='1' id='amount-id'>
                            <div class='product-add'  onclick='AmountAdd();'></div>
                        </div>
                        
                        <div class='product-action'>
                ";
            if (!$logged_in) {
                $display .= "
                <div onclick='Login();'class='add-cart' >
                    <p>ADD TO CART</p>
                    <img src='CSS/Resources/Images/icon-cart-inverted.png'>
                </div>
                <div onclick='Login();' class='add-like'>
                    <img src='CSS/Resources/Images/icon-like.png'> 
                </div>";
            } else {

                $display .= "
                            <button type='submit' class='add-cart'  name='user-cart' value='" . $product["product_id"] . "' >
                                <p>ADD TO CART</p>
                                <img src='CSS/Resources/Images/icon-cart-inverted.png'>
                            </button>
                            <button type='submit' class='add-like' onclick='ShowText();' name='user-like' value='" . $product["product_id"] . "'>
                            ";
                if (in_array($product["product_id"], $user_likes)) {
                    $display .= "  <img id='liked' src='CSS/Resources/Images/icon-liked.png'> ";
                } else {
                    $display .= "  <img src='CSS/Resources/Images/icon-like.png'> ";
                }
                $display .= "</button>";
            }

            $display .= "
                        </div>
                    </form>
                </div>
                
                ";

            echo $display;
            ?>
        </div>
    </div>

    <div class="main-products-details-cont">
        <div class="products-details-title-cont">

            <?php
            if (($product["product_details"]) != "") {
                echo "<h1>" . $product["product_name"] . " Details   </h1>";
            }
            ?>

        </div>
        <div class="product-details-cont">
            <?php
            echo processTextData($product["product_details"], true);

            ?>
        </div>

    </div>
    <footer class="footer" style="margin: 10px;transform: translateY(40px);">
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
    <script type="text/javascript" src="JS/user_notif.js"></script>

    <script type="text/javascript" src="JS/user_product_selected.js"></script>

    <script type="text/javascript" src="JS/user_exit_anim.js"></script>

    <script type="text/javascript" src="JS/main.js"></script>

    <script type="text/javascript" src="JS/user_nav_toggler.js"></script>
    <script src="https://kit.fontawesome.com/a1ba985915.js"></script>
</body>

</html>