<?php



include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();


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
        <a id="current-dir" href="#">About</a>



    </div>
    <section class="page-content">
        <div class="page-type">
            <div class="image-display">

            </div>
            <div class="text-display">
                <h1> About Us </h1>
                <br>
                <p>At Furrpection, we believe that pets are not just animals; they are cherished members of our families.</p>
                <br>
                <p>
                    With a passion for promoting the well-being of our furry friends,
                    we've curated a collection of premium pet accessories, high-quality foods,
                    and essential vitamins to ensure your pets live their happiest, healthiest lives.
                </p>
            </div>

        </div>
        <div class="page-type" id="page-type-id">
            <div class="text-display" id="text-display-id">
                <h1> Frequently Asked Questions </h1>
                <div class="text-compile">
                    <div class="text-divide">

                        <h2> 1. What products do you offer? </h2>
                        <p>We offer a wide range of premium pet accessories, high-quality pet foods, and essential vitamins to ensure the well-being of your furry friends. Our products include but are not limited to collars, beds, toys, nutritious pet foods, and supplements. </p>
                        <br>
                        <h2> 2. How do I place an order? </h2>
                        <p>Placing an order is easy! Simply browse our online store, add the desired products to your cart, and proceed to checkout. Follow the on-screen instructions to enter your shipping details and payment information. Once your order is confirmed, you'll receive an email with the order details.</p>
                        <br>
                        <h2> 3. What payment methods do you accept? </h2>
                        <p>We accept a variety of payment methods, including credit/debit cards and [Other Accepted Payment Methods]. Your payment information is secure, and we do not store any sensitive details.</p>
                        <br>
                        <h2> 4. Can I modify or cancel my order? </h2>
                        <p>Unfortunately, once an order is confirmed, we cannot modify or cancel it. Please review your order carefully before completing the purchase. If you encounter any issues, please contact our customer support at [Your Contact Email] for assistance.</p>
                        <br>
                        <h2> 5. What is your shipping policy? </h2>
                        <p>For detailed information on shipping, including costs and estimated delivery times, please refer to our [Shipping Policy]. We strive to dispatch orders promptly, and you'll receive a confirmation email with tracking details once your order is on its way.</p>
                        <br>
                    </div>
                    <div class="text-divide">

                        <h2> 6. Do you ship internationally? </h2>
                        <p>Yes, we offer international shipping to selected destinations. Shipping costs and delivery times vary depending on the destination. Please check our [Shipping Policy] for more details.</p>
                        <br>
                        <h2> 7. How do returns and exchanges work? </h2>
                        <p>Our goal is your satisfaction. If you're not completely satisfied with your purchase, please refer to our [Return Policy] for detailed instructions on returns and exchanges.</p>
                        <br>
                        <h2> 8. Are your products safe for my pets? </h2>
                        <p>Absolutely. We prioritize the safety and well-being of your pets. Our products undergo rigorous quality checks, and we source from reputable suppliers. If you have specific concerns or questions about a product, feel free to reach out to our customer support team.</p>
                        <br>
                        <h2> 9. Can I track my order? </h2>
                        <p>Yes, once your order is shipped, you will receive an email with tracking information. You can use this information to track your order in real-time.</p>
                        <br>
                        <h2> 10. How can I contact customer support?</h2>
                        <p>For any further questions or assistance, our customer support team is here to help. Please email us at [Your Contact Email] or visit our [Contact Us] page for more options.</p>

                    </div>
                </div>
                <p>Thank you for choosing Furrpection for your pet's needs!</p>
            </div>


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
    </section>

    <script type="text/javascript" src="JS/user_exit_anim.js"></script>

    <script type="text/javascript" src="JS/main.js"></script>

    <script type="text/javascript" src="JS/user_nav_toggler.js"></script>

    <script type="text/javascript" src="JS/user_notif.js"></script>
    <script src="https://kit.fontawesome.com/a1ba985915.js"></script>
</body>

</html>