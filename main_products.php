<?php



include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();

$contents_per_page = 20;
$sql_categ = "SELECT DISTINCT product_category FROM fp_products WHERE product_status='available' ";
$result_categ = $con->query($sql_categ);

$notify_value = '';
if (isset($_SESSION['action-notify'])) {

    $notify_value = $_SESSION['action-notify'];

    unset($_SESSION['action-notify']);
}
if (isset($_GET['page'])) {
    $_SESSION['main-current-page'] = $_GET['page'];
    unset($_GET['page']);
    header("Location: main_products.php");
}


$current_page = 1;
$max_page = 1;
if (isset($_SESSION['max-page'])) {
    $max_page = $_SESSION['max-page'];
}
if (isset($_SESSION['main-current-page'])) {
    $current_page = $_SESSION['main-current-page'];
}

if (isset($_GET['prev-page'])) {
    unset($_GET['prev-page']);
    if ($current_page <= 1) {
        header("Location: main_products.php");
        die;
    }
    $_SESSION['main-current-page'] -= 1;
    header("Location: main_products.php");
}


if (isset($_GET['next-page'])) {
    unset($_GET['next-page']);
    if ($current_page > $max_page) {
        header("Location: main_products.php");
        die;
    }
    $_SESSION['main-current-page'] += 1;
    header("Location: main_products.php");
}











$search_results = 0;
function Display_Products($con)
{
    $c_p_page = $GLOBALS['contents_per_page'];
    $page_amount = 1;

    $selected_categories = '';
    if (isset($_SESSION['selected-category'])) {
        $selected_categories = $_SESSION['selected-category'];
    }
    $current_page = $GLOBALS['current_page'];
    $sort = "ASC";
    if (isset($_SESSION['sort'])) {
        $sort = $_SESSION['sort'];
    }

    if (isset($_SESSION['search'])) {
  

        $search_value = $_SESSION['search'];
        if (empty($selected_categories)) {
            $sql = "SELECT * FROM fp_products WHERE product_name LIKE '%$search_value%' AND product_status='available'  ORDER BY product_id $sort";
        } else {
            
            $current_page = 1;
            $_SESSION['main-current-page'] = 1;
            $sql = "SELECT * FROM fp_products WHERE product_category = '$selected_categories' AND product_name LIKE '%$search_value%' AND product_status='available' ORDER BY product_id $sort";
        }
    } else {

        if (empty($selected_categories)) {
            $sql = "SELECT * FROM fp_products WHERE product_status='available' ORDER BY product_id $sort";
        } else {
            $_SESSION['main-current-page'] = 1;
            $sql = "SELECT * FROM fp_products WHERE product_category = '$selected_categories' AND product_status='available' ORDER BY product_id $sort";
        }
    }

    $result = $con->query($sql);
    $product_amount = 0;
    if ($result && $result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
            $product_amount++;
        }
        $GLOBALS['search_results'] = $result->num_rows;
    }


    $sql .= " LIMIT $c_p_page OFFSET " . ($c_p_page * ($current_page - 1));
    $result = $con->query($sql);



    $value = '';
    if ($result === false) {
        $value = "Error: " . $con->error;
    } else {
        if (isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            $query_id = "SELECT product_id FROM `fp_user_likes` WHERE user_id=$id";
            $user_likes = array();
            $result_id = mysqli_query($con, $query_id);
            if ($result_id && mysqli_num_rows($result_id) > 0) {
                while ($likes = mysqli_fetch_assoc($result_id)) {
                    $user_likes[] = $likes['product_id'];
                }
            }
        }
        if ($result->num_rows > 0) {
            $logged_in = false;
            if (isset($_SESSION['user_logged_in'])) {
                if ($_SESSION['user_logged_in']) {
                    $logged_in = true;
                }
            }


            while ($product = $result->fetch_assoc()) {

                if ($product["product_ratings"] == 0 && $product["product_ratings_total"] == 0) {
                    $width_value = "0px";
                } else {
                    $width_value = strval(intval(15 * ($product["product_ratings_total"] / $product["product_ratings"]))) . "px";
                }

                $value .=
                    "
                        <div class='product-cont'>
                            <button class='product-img' type='submit' name='product-load' value='" . $product["product_id"] . "' >
                                <div class='product-hover'><p>Click To View More</p></div>
                                <img src='CSS/Resources/ProductImages/" . $product["product_image_1"] . "'>
                            </button>

                            <p>" . $product["product_name"] . " </p>

                            <div class='product-rating-placeholder'>
                                <div class='product-rating' style='width:" . $width_value . "'></div>
                            </div>
                            
                            <div class='product-detail'>
                                <p><span>₱</span>" . $product["product_cost"] . "</p>
                                <div class='product-options'>
                    ";
                if ($logged_in) {
                    $value .=
                        "
                                    <button type='submit' class='product-like'  name='user-like' value='" . $product["product_id"] . "'>
                        ";
                    if (in_array($product["product_id"], $user_likes)) {
                        $value .= " <img id='liked' src='CSS/Resources/Images/icon-liked.png'>    ";
                    } else {
                        $value .= " <img src='CSS/Resources/Images/icon-like.png'>    ";
                    }

                    $value .=    "  </button>
                                    <button type='submit' class='product-cart'  name='user-cart' value='" . $product["product_id"] . "'>
                                        <img src='CSS/Resources/Images/icon-cart.png'>       
                                    </button>
                    ";
                } else {
                    $value .=
                        "
                                    <div class='product-like' onclick='Login();' >
                                        <img src='CSS/Resources/Images/icon-like.png'>                           
                                    </div>
                                    <div class='product-cart' onclick='Login();' >
                                        <img src='CSS/Resources/Images/icon-cart.png'>       
                                    </div>
                    ";
                }

                $value .=
                    "
                                </div>
                            </div>
                        </div>

                    ";
            }
        }
        $value .= "</form>";
        $page_amount =  floor($product_amount / $c_p_page);
        $_SESSION['max-page'] = $page_amount;
        $value .=

            "
            <form method='GET'>
            <div class='page-section-cont'>
           
                <button type='submit' name='prev-page' id='page-prev' class='page-action'><button>";
        $button_limit = 0;
        for ($i = 1; $i <= $page_amount + 1; $i++) {
            if ($button_limit >= 5) {
                break;
            }
            $button_limit++;
            if ($i == $current_page) {
                $value .= "<button type='submit' value='$i' id='highlighted' name='page' class='page-button'><p>$i</p></button>";
            } else {
                $value .= "<button class='unhighlighted' type='submit' value='$i' name='page' class='page-button'><p>$i</p><div class='un-h-bg'></div></button>";
            }
        }

        $value  .= "
                <button type='submit' name='next-page' id='page-next' class='page-action'></button>
            </div>
            </form>";
    }
    return $value;
}


if (isset($_GET['category-submit'])) {
    //$selected_product = $_GET['category-submit'];

    if (isset($_SESSION['selected-category'])) {
        if ($_SESSION['selected-category'] == $_GET['category-submit']) {

            unset($_SESSION['selected-category']);
        } else {
            $_SESSION['selected-category'] = $_GET['category-submit'];
        }
    } else {
        $_SESSION['selected-category'] = $_GET['category-submit'];
    }
    unset($_GET['category-submit']);

    /*
    $result_categ = $con->query("SELECT DISTINCT product_category FROM fp_products");
    $i = 0;
    while ($product = $result_categ->fetch_assoc()) {
        $selected_product_categ = $product["product_category"];
        if ($selected_product_categ == $selected_product) {
            $_SESSION[$selected_product] = true;
            
            echo $selected_product_categ . "set";
        } else {
            if (isset($_SESSION[$selected_product])) {
                unset($_SESSION[$selected_product]);
                
                echo $selected_product_categ . "unseted";
            }
            
        }
        echo "[$i,$selected_product_categ]";
        $i++;
    }
    /*
    if (isset($_SESSION[$selected_product])) {
        $_SESSION[$selected_product] = ($_SESSION[$selected_product] == true) ? 0 : true;
    } else {
        $_SESSION[$selected_product] = true;
    }
    */
    header("Location: main_products.php");
}

if (isset($_GET['product-load'])) {
    $_SESSION['product-id'] = $_GET['product-load'];

    header("Location: main_products_selected.php");
}

if (isset($_GET['user-cart'])) {

    $product_cart_id = $_GET['user-cart'];
    unset($_GET['user-cart']); //disables add to cart duplicates when refreshing
    $id = $_SESSION['user_id'];

    $get_existing_cart_id = "SELECT DISTINCT c.cart_id FROM fp_users_cart c LEFT JOIN fp_users_transaction t ON c.cart_id = t.cart_id AND c.user_id = t.user_id WHERE c.user_id = $id AND t.cart_id IS NULL";
    $result = $con->query($get_existing_cart_id);

    if ($result && mysqli_num_rows($result) > 0) {
        //current user cart session is not empty
        $temp_id_val = mysqli_fetch_assoc($result);
        $current_cart_id = $temp_id_val["cart_id"];

        //$current_cart_id = mysqli_fetch_column($result);

        $check_product_duplicates = "SELECT * FROM fp_users_cart WHERE cart_id=$current_cart_id AND user_id=$id AND product_id=$product_cart_id";
        $result_cart = $con->query($check_product_duplicates);

        $sql = "INSERT INTO fp_users_cart(cart_id, user_id, product_id, product_amount) VALUES ('$current_cart_id','$id','$product_cart_id',1)";

        if ($result_cart && mysqli_num_rows($result_cart) > 0) {
            //product already exist in user cart
            //appends amount

            $sql = "UPDATE fp_users_cart SET product_amount = product_amount + 1 WHERE cart_id=$current_cart_id AND user_id=$id AND product_id=$product_cart_id";
        }


        $result_add =  $con->query($sql);
        if ($result_add) {
            $_SESSION['action-notify'] = "Added to Cart";
            header("Location: main_products.php");
        }
    } else {
        //current user cart session is empty
        //creates new cart id

        $sql = "INSERT INTO fp_users_cart(user_id, product_id, product_amount) VALUES ('$id','$product_cart_id',1)";
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

                //$cart_id = mysqli_fetch_column($result_cart_id);
            }
            $_SESSION['user_cart_id'] = $cart_id;
            header("Location: main_products.php");
        }
    }
}

if (isset($_GET['user-like'])) {
    $product_cart_id = $_GET['user-like'];

    $id = $_SESSION['user_id'];
    $check_duplicates_query = "SELECT * FROM fp_user_likes WHERE user_id = '$id' AND product_id = '$product_cart_id'";


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

    header("Location: main_products.php");
}


if (isset($_GET['sort-submit'])) {


    if (isset($_SESSION['sort'])) {
        $_SESSION['sort'] = ($_SESSION['sort'] == "ASC") ? "DESC" : "ASC";
    } else {
        $_SESSION['sort'] = "DESC";
    }

    header("Location: main_products.php");
}


if (isset($_GET['search-submit'])) {
    $_SESSION['search'] = $_GET['search'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>furrpection</title>
    <link rel="stylesheet" href="CSS/main_products.css">
    <link rel="stylesheet" href="CSS/main_search.css">

    <link rel="stylesheet" href="CSS/main_paging.css">

    <link rel="stylesheet" href="CSS/main_footer.css">
    <link rel="stylesheet" href="CSS/mobile_navbar.css">
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
            <a href="main_redirect_products.php">Products</a>
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
    </div>

    <div class='section-bg'></div>
    <section>
        <form method="GET" action="" id="search-form-cont">
            <div class="search-cont">

                <button class="search-sort-button" type="submit" name="sort-submit">

                    <p>Sort</p>
                    <?php
                    if (isset($_SESSION['sort'])) {
                        if ($_SESSION['sort'] == "ASC") {
                            echo "<img src='CSS/Resources/Icons/icon-sort-asc.svg'>";
                        } else {

                            echo "<img src='CSS/Resources/Icons/icon-sort-desc.svg'>";
                        }
                    } else {

                        echo "<img src='CSS/Resources/Icons/icon-sort-asc.svg'>";
                    }

                    ?>
                </button>
                <div class="search-input">
                    <img src="CSS/Resources/Icons/icon-search.svg">
                    <input placeholder="Search" name="search" autocomplete="off">
                </div>
                <button class="search-button" type="submit" name="search-submit" id='search-button-id'>
                    <img src="CSS/Resources/Icons/icon-arrow-1.svg">
                    <p>SEARCH</p>
                </button>
            </div>
        </form>
        <div class="category-cont">

            <?php


            if ($result_categ->num_rows > 0) {
                echo " <form method='GET' action=''>";
                $result_categ = $con->query($sql_categ);
                while ($product = $result_categ->fetch_assoc()) {
                    $selected_product_categ = $product["product_category"];
                    if (isset($_SESSION['selected-category'])) {

                        if ($_SESSION['selected-category'] == $selected_product_categ) {

                            echo "<button type='submit' class='category-button-highlighted' name='category-submit' value='" . $product["product_category"] . "'>";
                        } else {
                            echo "<button type='submit' class='category-button' name='category-submit' value='" . $product["product_category"] . "'>";
                        }
                    } else {
                        echo "<button type='submit' class='category-button' name='category-submit' value='" . $product["product_category"] . "'>";
                    }


                    echo "<p>" . $product["product_category"] . "</p> </button>";
                }
                echo " </form>";
            } else {
                echo "<div id='no-categ'> No Categories Available. </div>";
            }
            ?>

        </div>
        <div class="search-response-result-cont">
            <?php
            if (isset($_SESSION['search'])) {
                $search_value = $_SESSION['search'];
                if ($search_value != '') {
                    echo "<p id='search-results-id' > Search results for '$search_value' </p>";
                }
            }

            ?>

        </div>
        <div class="products-cont">

            <?php
            /*
            $logged_display = '<div id="form">';
            $logged_display_end = '</div>';
            if (isset($_SESSION['user_logged_in'])) {
                if ($_SESSION['user_logged_in']) {
                    $logged_display = " <form method='POST' action=''>";
                    $logged_display_end = " </form>";
                }
            }*/
            $logged_display = " <form method='GET' action=''>";

            $display = Display_Products($con);
            echo $logged_display . $display;
            echo "<script>
            var s_results = document.getElementById('search-results-id');
            if (s_results != null){
            s_results.innerHTML = s_results.innerHTML+', ' +$search_results +' found';
            }</script>";
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
    </section>
    <script type="text/javascript" src="JS/user_notif.js"></script>

    <script type="text/javascript" src="JS/user_main_search.js"></script>

    <script type="text/javascript" src="JS/main.js"></script>

    <script type="text/javascript" src="JS/user_nav_toggler.js"></script>

    <script src="https://kit.fontawesome.com/a1ba985915.js"></script>

</body>

</html>