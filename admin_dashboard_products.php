<?php
include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
}

if (isset($_POST['trigger-product-delete'])){
    $p_id = $_POST['trigger-product-delete'];
    $sql = "UPDATE fp_products SET product_status='unavailable' WHERE product_id = $p_id";
    try{
        
        mysqli_query($con, $sql);

    }
    catch(Exception $e){
        echo "err".$e;
        
    }
}

// adds product
if (isset($_POST['product-add'])) {
    sleep(0.1);
    //delays the function, also allows to execute js file
    unset($_POST["product-add"]);

    $p_name = $_POST['product-name'];
    $p_price = $_POST['product-price'];
    $p_category = $_POST['product-category'];
    $p_info = $_POST['product-info'];
    $p_details = $_POST["product-details"];
    
    
    if ($_FILES["product-image-1"]["error"] == 4){
        //err
    }else{
        $fileName = $_FILES["product-image-1"]["name"];
        $fileSize = $_FILES["product-image-1"]["size"];
        $tmpName = $_FILES["product-image-1"]["tmp_name"];
        
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>console.log('Invalid Image Extension');</script>";
        } else if ($fileSize > 1000000) {
            echo
            "<script>console.log('Image Size Is Too Large');</script>";
        } else {
            $file_directory = "CSS/Resources/ProductImages/";

            $image_name = uniqid();
            $image_name .= '.' . $imageExtension;

            move_uploaded_file($tmpName, $file_directory . $image_name);
            $query = "INSERT INTO fp_products (product_name, product_cost, product_category, product_info,  product_details, product_image_1,product_status) 
            VALUES ('$p_name','$p_price','$p_category','$p_info','$p_details','$image_name','available')";
            mysqli_query($con, $query);
        }

    }
    //header("Location :admin_dashboard_products.php");
}

// updates Product
if (isset($_POST["product-update"])) {
    sleep(0.1);
    //delays the function, also allows to execute js file
   

    $p_name = $_POST['product-name'];
    $p_price = $_POST['product-price'];
    $p_category = $_POST['product-category'];
    $p_info = $_POST['product-info'];
    $p_id = $_POST["product-update"];
    $p_details = $_POST["product-details"];
    unset($_POST["product-update"]);
    if ($_FILES["product-image-1"]["error"] == 4) {
        // image unchanged
        $query = "update  fp_products SET product_name='$p_name', product_cost='$p_price', product_details='$p_details',product_info='$p_info',product_category='$p_category' where product_id=$p_id";
        mysqli_query($con, $query);
    } else {
        // image changed
        echo "<script> alert('Image Changed'); </script>";
        $fileName = $_FILES["product-image-1"]["name"];
        $fileSize = $_FILES["product-image-1"]["size"];
        $tmpName = $_FILES["product-image-1"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>console.log('Invalid Image Extension');</script>";
        } else if ($fileSize > 1000000) {
            echo
            "<script>console.log('Image Size Is Too Large');</script>";
        } else {
            $file_directory = "CSS/Resources/ProductImages/";

            $image_name = uniqid();
            $image_name .= '.' . $imageExtension;

            move_uploaded_file($tmpName, $file_directory . $image_name);



            $query = "update  fp_products SET product_name='$p_name', product_cost='$p_price', product_details='$p_details',product_info='$p_info',product_category='$p_category', product_image_1='$image_name' where product_id=$p_id";
            mysqli_query($con, $query);
            
            
        }
        
    }
    //header("Location :admin_dashboard_products.php");

}










if (isset($_POST["submit"])) {


    $p_name = $_POST['name'];
    $p_cost = $_POST['price'];
    $p_details = $_POST['details'];
    $p_category = $_POST['category'];

    if ($_FILES["image"]["error"] == 4) {
        echo
        "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo
            "
        <script>
          alert('Invalid Image Extension');
        </script>
        ";
        } else if ($fileSize > 1000000) {
            echo
            "
        <script>
          alert('Image Size Is Too Large');
        </script>
        ";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'CSS/Resources/ProductImages/' . $newImageName);
            $query = "insert into fp_products (product_name,product_cost,product_details,product_category,product_image_1) VALUES
        ('$p_name',$p_cost,'$p_details','$p_category','$newImageName');";
            mysqli_query($con, $query);
            echo
            "
        <script>
          alert('Successfully Added');
          document.location.href = 'admin_dashboard.php';
        </script>
        ";
        }
    }
}






/*
if (isset($_POST['delete'])) {
    $product = $_POST['delete'];


    $query = "delete from fp_products where product_name ='$product'";
    mysqli_query($con, $query);

    echo
    "
  <script>
    alert('Successfully Deleted');
    document.location.href = 'admin_dashboard.php';
  </script>
  ";
}
*/



//upon clicking product edit opens a form of the product
if (isset($_POST['product-update-toggle'])) {
    $_SESSION['product-update-set'] = $_POST['product-update-toggle'];
    unset($_POST['product-update-toggle']);
    header("Location: admin_dashboard_products.php");
    die;
}


//upon clicking product add opens a empty form
if (isset($_POST['product-add-toggle'])) {
    $_SESSION['product-add-set'] = true;
    unset($_POST['product-add-toggle']);
    header("Location: admin_dashboard_products.php");
    die;
}

/*

if (isset($_POST['submit'] ) ){
  
    
    $p_name = $_POST['name'];
    $p_cost = $_POST['price'];
    $p_details = $_POST['details'];
    $p_category = $_POST['category'];

    $filename = $_FILES["choosefile"]["name"];
    $tempfile = $_FILES["choosefile"]["tmp_name"];
    $folder = "image/".$filename;
    $sql =  "insert into fp_products (product_name,product_cost,product_details,product_category,product_image_1) VALUES
    ('$p_name',$p_cost,'$p_details','$p_category','$filename');";
    if($filename == "")
    {
        echo 
        "
        <div class='alert alert-danger' role='alert'>
            <h4 class='text-center'>Blank not Allowed</h4>
        </div>
        ";
    }else{
        $result = mysqli_query($con, $sql);
        move_uploaded_file($tempfile, $folder);
        echo 
        "
        <div class='alert alert-success' role='alert'>
            <h4 class='text-center'>Image uploaded</h4>
        </div>
        ";
    }

    /*
    $query = "insert into fp_products (product_name,product_cost,product_details,product_category,product_image_1) VALUES
    ('$p_name',$p_cost,'$p_details','$p_category','$filename');";
    //echo $query;
     mysqli_query($con,$query);
     if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }

}*/

/*

    $query = "SELECT * FROM fp_products WHERE 1";
    $result = mysqli_query($con,$query);
    while($fetch = mysqli_fetch_assoc($result)){
       echo  $fetch['product_id'] ;
   
       $tmp_img = $fetch['product_image_1'];
       echo "<img src ='./image/.$tmp_img.' width=100px>";
    }   

*/

function DisplayProducts()
{
    $con = $GLOBALS['con'];
    $products = mysqli_query($con, "SELECT * FROM fp_products WHERE product_status='available' ORDER BY product_id ASC");
    $value = '';
    foreach ($products as $product) {
        $p_img =  $product['product_image_1'];
        $value .= "
        
        <div class='product-item-container'>
            <div class='product-image' style='background-image:url(CSS/Resources/ProductImages/$p_img);'>
            </div>
            <p>" . $product['product_name'] . "</p>
            <div class='product-divider'>
                <p><span>₱</span> " . $product['product_cost'] . "</p>
                <div class='product-modify-actions'>
                    <div title='Edit Product' class='product-edit' onclick='ProductRequestUpdate(" . $product["product_id"] . ");'></div>
                    <div title='Remove Product'class='product-delete' onclick='ProductDelete(`" . $p_img . "`,`" . $product['product_name'] . "`,`". $product['product_id'] ."`);' ></div>
                </div>
            </div>
        </div>
        ";
    }
    return $value;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>furrpection</title>
    <link rel="stylesheet" href="CSS/admin_dashboard.css">

    <link rel="stylesheet" href="CSS/admin_dashboard_products.css">
    <link rel="stylesheet" href="CSS/admin_sidebar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="side-bar">
        <div class="logo-icon">
            <h1>FURRPECTION</h1>
        </div>
        <a href="admin_dashboard.php" class="side-bar-selection">
            <div class='sidebar-icons' id="icon-dashboard"> </div>
            <p>Dashboard</p>
            <div class="selection-highlight"></div>
        </a>
        <a href="admin_dashboard_products.php" class="side-bar-selection" id="side-bar-selected">
            <div class='sidebar-icons' id="icon-products"> </div>
            <p>Products</p>
            <div class="selection-highlight"></div>
        </a>
        <a href="admin_dashboard_orders.php" class="side-bar-selection">
            <div class='sidebar-icons' id="icon-orders"> </div>
            <p>Orders</p>
            <div class="selection-highlight"></div>
        </a>
        <a href="admin_dashboard_transactions.php" class="side-bar-selection">
            <div class='sidebar-icons' id="icon-transactions"> </div>
            <p>Transactions</p>
            <div class="selection-highlight"></div>
        </a>
        <a id='log-out' href="admin_logout.php">log out</a>
    </div>

    <div class="main-content">
        <div id="dark-bg">

        </div>
        <div id="modify-cont">
            <div id="product-action-cont">
                <form method="POST">
                    <button type="submit" name="product-update-toggle" id="product-action-cont-button-id" value="">a</button>
                </form>
            </div>
            <div id="product-add-cont">

            </div>
            <div id="product-delete-cont">
                <p id="product-delete-info"></p>
                <div id="product-delete-img-id"></div>
                <div class="product-delete-buttons">
                    <div class="product-confirm" id="confirm-false" onclick="CloseProduct();">
                        <p>Cancel</p>
                    </div>
                    <form method="POST" >
                    <button class="product-confirm"  type="submit"  name="trigger-product-delete" id="confirm-true" value="">
                        <p>Delete Product</p>
                    </button>
                    </form> 
                </div>
            </div>
            <div id="product-update-cont">
                <form autocomplete="off" action="" method="POST" enctype="multipart/form-data">
                    <div class="product-input-flex">
                        <div class="product-input-main">
                            <?php
                            $p_name = '';
                            $p_price = 0;
                            $p_categ = '';
                            $p_info = '';
                            $p_image_1 = '';
                            $p_image_set = 'Add Image';
                            $t_data = '';
                            $IsRequired = 'required';
                            if (isset($_SESSION['product-update-set'])) {
                                $product_temp_id = $_SESSION['product-update-set'];

                                $query = "Select * from fp_products where product_id = $product_temp_id";
                                $rows = mysqli_query($con, $query);

                                foreach ($rows as $row) {
                                    $p_name = $row["product_name"];
                                    $p_price = $row["product_cost"];
                                    $p_categ = $row["product_category"];
                                    $p_info = $row["product_info"];
                                    $p_image_1 = $row["product_image_1"];
                                    $p_image_set = 'Change Image';
                                    $t_data = $row["product_details"];
                                }

                                $IsRequired = '';
                            }
                            $p_image_ = "CSS/Resources/ProductImages/" . $p_image_1;

                            if ($p_image_1 == "") {
                                $p_image_  = "CSS/Resources/Icons/icon-image.svg";
                            }
                            echo '
                            <div class="product-input">
                                <label>PRODUCT NAME</label>
                                <textarea maxlength="50"  onfocus="SetUpdateNameFocus();" oninput="SetUpdateNameFocus();" onblur="SetUpdateNameBlur();" id="product-name-id" type="text" name="product-name" required>' . $p_name . '</textarea>
                            </div>
                            <div class="product-input">
                                <label>PRODUCT PRICE</label>
                                <p id="p-id-cost">₱</p>
                                <input id="product-price-id" value="' . $p_price . '" type="number" name="product-price" required>
                            </div>
                            <div class="product-input">
                                <label>PRODUCT CATEGORY</label>
                                <input maxlength="50" value="' . $p_categ . '" id="product-category-id" type="text" name="product-category" required>
                            </div>
                            <div class="product-input">
                                <label>PRODUCT INFO</label>
                                <textarea maxlength="175" onfocus="SetUpdateInfoFocus();" oninput="SetUpdateInfoFocus();" onblur="SetUpdateInfoBlur();" id="product-info-id" type="text" name="product-info" required>' . $p_info . '</textarea>
                            </div>
                            <div class="product-input-image">
                                <label>PRODUCT IMAGE</label>
                                <div id="product-image-button-id" onclick="SetImage();" style="background-image:url(' . $p_image_ . ')">
                                    <p id="product-image-name-id">' . $p_image_set . '</p>
                                    <input type="file" name="product-image-1" value="" id="product-image-input-id" accept=".jpg, .jpeg, .png"  ' . $IsRequired . '>
                                    <div class="product-image-bg" ></div>
                                </div>

                            </div>';

                            ?>
                        </div>
                        <div class="product-input-detail" id="product-input-detail-id">
                            <label>PRODUCT DETAILS</label>
                            <?php
                            echo processTextData($t_data, false);

                            ?>
                            <div class="product-add-detail-cont" onclick="AddDetailCont();" id="product-add-id">
                            </div>
                        </div>
                    </div>
                    <div class="product-action">
                        <textarea id="product-details-id" name="product-details"></textarea>
                        <div class="product-cancel-button" onclick="CloseProduct();">
                            <p>Cancel</p>
                        </div>
                        <?php
                        $user_action_case = '';
                        if (isset($_SESSION['product-update-set'])) {
                            $user_action_case .=
                                "<button id='product-update-button-id' value='' class='product-update-button' type='submit' name='product-update' onclick='SetUpdateProduct();'>
                            <p> UPDATE PRODUCT </p>
                            <img src='CSS/Resources/Icons/icon-update.svg'>
                            </button>";
                        } else {
                            $user_action_case .=
                                "<button id='product-update-button-id' value='' class='product-update-button' type='submit' name='product-add' onclick='SetUpdateProduct();'>
                            <p> ADD PRODUCT </p>
                            <img src='CSS/Resources/Icons/icon-plus-inverted.svg'>
                            </button>";
                        }

                        echo $user_action_case;
                        ?>
                    </div>

                </form>
            </div>

        </div>
        <div class="product-tab-cont">
            <form method="POST">
                <div class="button-categories-product">
                    <p> CATEGORIES </p>
                    <img src="CSS/Resources/Icons/icon-arrow-down.svg">
                </div>
                <button class="button-add-product" type="submit" name="product-add-toggle">
                    <p> ADD PRODUCT </p>

                    <img src="CSS/Resources/Icons/icon-plus-inverted.svg">
                </button>
            </form>
        </div>
        <div class="product-container">
            <form autocomplete="off" method="GET">
                <?php

                echo DisplayProducts();
                ?>
            </form>
        </div>
    </div>


    <script type="text/javascript" src="JS/admin_dashboard_products.js"></script>
    <?php
    if (isset($_SESSION['product-update-set'])) {
        $id = $_SESSION['product-update-set'];
        echo  "<script>ProductUpdate($id);</script>";
        unset($_SESSION['product-update-set']);
    } else {
    }
    if (isset($_SESSION['product-add-set'])) {
        unset($_SESSION['product-add-set']);
        echo "<script>AddProduct();</script>";
    }


    ?>
</body>

</html>