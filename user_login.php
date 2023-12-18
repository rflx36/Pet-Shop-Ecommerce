<?php
include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();

if (isset($_SESSION['user_logged_in'])) {
    if ($_SESSION['user_logged_in']) {
        header("Location: main_products.php");
    }
}

$resp = '';
$resp_2 = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (isset($_POST['login-submit'])) {

        $name = $_POST['name'];
        $pass = $_POST['password'];
        
        $hashed_pass = password_hash($pass,PASSWORD_DEFAULT);

        $temp_stmt = $con->prepare("SELECT * from fp_users WHERE user_name = ?");
        $temp_stmt->bind_param("s",$name);
        $temp_stmt->execute();

        $temp_result = $temp_stmt->get_result();
        $verify_user = false;
        $user_data = array();
        if ($temp_result->num_rows > 0){
            $user_data = mysqli_fetch_assoc($temp_result);
            $hashed = $user_data['user_password'];
            $verify_user = password_verify($pass,$hashed);
       
        }
        if ($verify_user) {


            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user_data['user_id'];
            $id = $user_data['user_id'];

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
        } else {
            $resp = "Invalid Username or Password. ";
        }
    }

    if (isset($_POST['signup-submit'])) {
        $r_name = $_POST['r_name'];
        $r_pass_a = $_POST['r_password'];
        $r_pass_b = $_POST['r_re_password'];
        $r_email = SetEncrypt($_POST['r_email']);
        if ($r_pass_a != $r_pass_b) {

            $resp_2 = "Password Doesn't Match";
        }
        else if(strlen($r_pass_a) < 8){
            $resp_2 = "Password must have at least 8 characters";
        }
        else {


            $result_name_duplicate = $con->query("SELECT * FROM fp_users WHERE user_name='$r_name'");

            if ($result_name_duplicate && $result_name_duplicate->num_rows > 0) {
                $resp_2 = "Username Already Exist";
            } else {
                
                $hashed_pass = password_hash($r_pass_a,PASSWORD_DEFAULT);

                $stmt = $con->prepare("INSERT INTO fp_users ( user_name, user_email, user_password) VALUES (?,?,?)");
                $stmt->bind_param("sss", $r_name, $r_email,$hashed_pass);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {

                    
                    $stmt_log_in = $con->prepare("SELECT * FROM fp_users WHERE user_name = ? ");
                    $stmt_log_in->bind_param("s", $r_name);
                    
                    $stmt_log_in->execute();
                    $result = $stmt_log_in->get_result();
                    if ($result->num_rows > 0) {
                        $user_data = mysqli_fetch_assoc($result);
            
                        $_SESSION['user_logged_in'] = true;
                        $_SESSION['user_id'] = $user_data['user_id'];
                        $id = $user_data['user_id'];

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
                    }
                    

                    header("Location: main_products.php");
                } else {
                    $resp_2 = "Error:" . $stmt->error;
                }
            }
        }
    }
}




?>
<!DOCTYPE html>
<html>

<head>
    <title>furrpection</title>
    <link rel="stylesheet" href="CSS/main_login.css">
    
    <link rel="stylesheet" href="CSS/main_footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>  
    <div class="navbar">
        <div class="nav-logo-section">
        <h1 onclick="RedirectHome();" id='main-logo-text' >FURRPECTION</h1>
        </div>
        <div class="nav-sections">
            <a href="main_products.php">Products</a>
            <a href="main_about.php">About</a>
            <a href="#">Contacts</a>
        </div>
    </div>
    <div class="login-container">
        <div class="container-input" id="cont-input-id">
            <h1 id="h1-id">FURRPECTION</h1>
            <form autocomplete="off" action="" method="post">
                <div class="login-details">
                    <div class="login-input" id="log-input-id-a">
                        <img src="CSS/Resources/Icons/icon-user.svg">
                        <input type="name" id="name" name="name" placeholder="Username" required>
                    </div>

                    <div class="login-input" id="log-input-id-b">
                        <img src="CSS/Resources/Icons/icon-password.svg">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <?php
                    echo "<div class='error-resp'><p 'error-log-id'>$resp</p></div>";

                    ?>
                </div>

                <button id="login-button-id" class="login-button" style="top:0px;" type="submit" name="login-submit">
                    <p>LOG IN</p>
                </button>
                <p onclick="ToggleLogin();" id="login">Already have an account? Log In </p>
            </form>
            <div class="login-divider divider-enabled" id="log-div-id">
                <p id="register" onclick="ToggleRegister();">Don't have an account? Sign Up </p>
                <div class="register-details">

                    <form id="register-cont" autocomplete="off" action="" method="post">
                        <label id="label-a">Username</label>
                        <div id="reg-input-a" class="login-input" style="margin-top:0px !important; ">
                            <img src="CSS/Resources/Icons/icon-user-inverted.svg">
                            <input type="name" id="r_name" name="r_name" placeholder="Username" required>
                        </div>
                        <label id="label-b">Email </label>
                        <div id="reg-input-b" class="login-input" style="margin-top:0px !important; ">
                            <img src="CSS/Resources/Icons/icon-user-inverted.svg">
                            <input type="email" id="r_email" name="r_email" placeholder="YourName@gmail.com" required>
                        </div>
                        <label id="label-c">Password</label>
                        <div id="reg-input-c" class="login-input" style="margin-top:0px !important;">
                            <img src="CSS/Resources/Icons/icon-password-inverted.svg">
                            <input type="password" id="r_password" name="r_password" placeholder="Password" required>
                        </div>

                        <label id="label-d">Confirm Password</label>

                        <div id="reg-input-d" class="login-input" style="margin-top:0px !important;">
                            <img src="CSS/Resources/Icons/icon-password-inverted.svg">
                            <input type="password" id="r_rpassword" name="r_re_password" placeholder="Repeat Password" required>
                        </div>
                        <?php
                        echo "<div class='error-resp' ><p id='error-reg-id' >$resp_2</p></div>";

                        ?>
                        <button id="signup-button-id" class="signup-button" type="submit" name="signup-submit" disabled>
                            <p>Sign Up</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section style='height:85vh;width:10px;'></section>
    <footer class="footer" style="margin-left:10px;">
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
    <script type="text/javascript" src="JS/user_log.js"></script>
    
    <script type="text/javascript" src="JS/main.js"></script>
    <script src="https://kit.fontawesome.com/a1ba985915.js"></script>
</body>

</html>