<?php
include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
}


$resp = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $pass = $_POST['password'];
    //select * from fp_admin where admin_id = '$ID' limit 1
    $stmt = $con->prepare("SELECT * FROM fp_admin WHERE admin_name = ? and admin_password = ? ");
    $stmt->bind_param("ss", $name, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

        $_SESSION['admin_logged_in'] = true;

        header("Location: admin_dashboard.php");
    }
    else{
        $resp = "Invalid Username or Password. ";
    }

}


?>
<!DOCTYPE html>
<html>

<head>
    <title>furrpection</title>
    <link rel="stylesheet" href="CSS/main_login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="login-container">
        <h1>FURRPECTION</h1>
        <form autocomplete="off" action="" method="post">
            <div class="login-details">
                <div class="login-input">
                    <img src="CSS/Resources/Icons/icon-user.svg">
                    <input type="name" id="name" name="name" placeholder="username" required>
                </div>

                <div class="login-input">
                    <img src="CSS/Resources/Icons/icon-password.svg">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <?php 
                echo "<div class='error-resp'><p>$resp</p></div>";
                
                ?>
            </div>
           
            <button class="login-button" type="submit" value="submit">
                <p>LOG IN</p>
            </button>
        </form>
    </div>
</body>

</html>