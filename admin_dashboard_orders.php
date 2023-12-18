<?php
include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
}

$contents_per_page = 15;

$current_page = 1;
$max_page = 1;

if (isset($_GET['admin-orders-search-submit'])) {
  

    $_SESSION['search-orders-value'] = $_GET['admin-orders-search'];

  
}
if (isset($_SESSION['max-page'])) {
  $max_page = $_SESSION['max-page'];
}
if (isset($_SESSION['main-current-page'])) {
  $current_page = $_SESSION['main-current-page'];
}

if (isset($_GET['prev-page'])) {
  unset($_GET['prev-page']);
  if ($current_page <= 1) {
    header("Location: admin_dashboard_orders.php");
    die;
  }
  $_SESSION['main-current-page'] -= 1;
  header("Location: admin_dashboard_orders.php");
}


if (isset($_GET['next-page'])) {
  unset($_GET['next-page']);
  if ($current_page > $max_page) {
    header("Location: admin_dashboard_orders.php");
    die;
  }
  $_SESSION['main-current-page'] += 1;
  header("Location: admin_dashboard_orders.php");
}

$notify_value = '';
if (isset($_SESSION['action-notify'])) {

  $notify_value = $_SESSION['action-notify'];

  unset($_SESSION['action-notify']);
}


if (isset($_GET['page'])) {
  $_SESSION['main-current-page'] = $_GET['page'];
  unset($_GET['page']);
  header("Location: admin_dashboard_orders.php");
}


if (isset($_GET['view-orders'])) {
  $_SESSION['view-order-id'] = $_GET['view-orders'];

  unset($_GET['view-orders']);
  header("Location: admin_dashboard_orders.php");
  die;
}


if (isset($_GET['sort-submit'])) {


  if (isset($_SESSION['admin-orders-sort'])) {
    $_SESSION['admin-orders-sort'] = ($_SESSION['admin-orders-sort'] == "ASC") ? "DESC" : "ASC";
  } else {
    $_SESSION['admin-orders-sort'] = "DESC";
  }

  header("Location: admin_dashboard_orders.php");
}

if (isset($_POST['approve-order'])) {
  $p_id = $_POST['approve-order'];
  unset($_POST['approve-order']);


  $sql = "UPDATE fp_users_transaction SET transaction_status='success' WHERE transaction_id = $p_id";

  $result = $con->query($sql);
  if ($result) {
    $_SESSION['action-notify'] = "Approved Order";
  } else {
    $_SESSION['action-notify'] = "An Error Occured";
  }
  header("Location: admin_dashboard_orders.php");
}


if (isset($_POST['reject-order'])) {
  $p_id = $_POST['reject-order'];
  unset($_POST['reject-order']);


  $sql = "UPDATE fp_users_transaction SET transaction_status='rejected' WHERE transaction_id = $p_id";

  $result = $con->query($sql);
  if ($result) {
    $_SESSION['action-notify'] = "Rejected Order";
  } else {
    $_SESSION['action-notify'] = "An Error Occured";
  }
  header("Location: admin_dashboard_orders.php");
}





function DisplayDetailedOrder()
{
  $con = $GLOBALS['con'];
  $value = "";
  if (isset($_SESSION['view-order-id'])) {

    $p_id = $_SESSION['view-order-id'];
    $query = "SELECT * FROM fp_users_transaction where transaction_id = $p_id";
    $result = $con->query($query);

    $t_f_name = "";
    $t_l_name = "";
    $t_email = "";
    $t_contact = "";
    $t_add_street = "";
    $t_add_zip = "";
    $t_add_city = "";
    $p_method = "";
    $p_card = "";
    $p_status = "";
    $p_transaction_date = "";
    $p_cart_id = "";
    $p_total = 0;
    $formattedDate = "";
    if ($result && mysqli_num_rows($result) > 0) {
      while ($transaction = mysqli_fetch_assoc($result)) {
        $t_f_name = RequestDecrypt($transaction["user_first_name"]);
        $t_l_name = RequestDecrypt($transaction["user_last_name"]);

        $t_add_street = RequestDecrypt($transaction["user_address_street"]);
        $t_add_zip = RequestDecrypt($transaction["user_address_zip"]);
        $t_add_city = RequestDecrypt($transaction["user_address_city"]);
        $p_method = $transaction["payment_method"];

        $p_status = $transaction["transaction_status"];
        $p_transaction_date =  $transaction["user_transaction_date"];
        $p_cart_id = $transaction["cart_id"];
        $p_total = $transaction["user_transaction_total"];

        $t_email = ObfuscateEmail(RequestDecrypt($transaction["user_email"]));
        $t_email_view = RequestDecrypt($transaction["user_email"]);
        $t_contact = ObfuscateContact(RequestDecrypt($transaction["user_contact"]));
        $t_contact_view = RequestDecrypt($transaction["user_contact"]);
        $p_card_cont = "";

        $dateTime = new DateTime($transaction["user_transaction_date"]);
        $formattedDate = $dateTime->format('M j, g:i A');

        if ($p_method != "Cash On Delivery") {
          $p_card = ObfuscateCard(RequestDecrypt($transaction["p_card_number"]));
          $p_card_cont = "
          <div class='detail-cont' style='width:40%;'>
            <label>Card Number</label>
            <p>$p_card</p>
          </div>";
        }


        if (strlen($t_f_name) > 15) {

          $t_f_name = substr($t_f_name, 0, 15);
          $t_f_name .= "...";
        }

        if (strlen($t_l_name) > 10) {

          $t_l_name = substr($t_l_name, 0, 10);
          $t_l_name .= "...";
        }
      }
    }
    $p_total_items = 0;
    if ($p_cart_id != "") {
      $query_cart = "SELECT * FROM fp_users_cart WHERE cart_id = $p_cart_id";
      $result_cart = mysqli_query($con, $query_cart);
      while ($fetch = mysqli_fetch_assoc($result_cart)) {
        $p_total_items += 1 * $fetch["product_amount"];
      }
    }

    $pending_stat = "";
    $pending_class = "";
    switch ($p_status) {
      case 'pending':
        $pending_stat = "Pending";
        $pending_class = "red";
        break;

      case 'shipping':
        $pending_stat = "Shipping";
        $pending_class = "orange";
        break;

      case 'success':
        $pending_stat = "Success";
        $pending_class = "green";
        break;

      case 'cancelled':
        $pending_stat = "Cancelled";
        $pending_class = "red";
        break;

      case 'rejected':
        $pending_stat = "Rejected";
        $pending_class = "red";
        break;

      case '':
        $pending_stat = "Pending";
        $pending_class = "red";
        break;
      default:

        $pending_stat = "Pending";
        $pending_class = "red";
        break;
    }
    $pending_action = "";
    if ($pending_stat == "Pending" || $pending_stat == "Rejected") {
      $pending_action = "   
      <div class='orders-selected-action-cont'>     
        <button class='orders-action-discard' type='submit' name='reject-order' value='$p_id'>
          <p>REJECT</p>
        </button>
        <button class='orders-action-approve' type='submit' name='approve-order' value='$p_id'>
          <p>APPROVE</p>
        </button>
      </div>";
    }
    $value .= "
      <div class='orders-view-cont'>
        <form autocomplete='off' method='post'>
            <h1> Detailed Order View </h1>
            <div class='orders-user-details-cont'>
              <div class='user-p-details'>
                <div class='user-details-1'>
                  <div class='user-name-details'>
                    <div class='detail-cont'>
                      <label>FIRST NAME</label>
                      <p>$t_f_name</p>
                    </div>
                    <div class='detail-cont'>
                      <label>LAST NAME</label>
                      <p>$t_l_name</p>
                    </div>
                  </div>
                  <div class='detail-cont'>
                      <label>ADDRESS STREET</label>
                      <p>$t_add_street</p>
                  </div>
                  <div class='user-address-details'>
                    <div class='detail-cont'>
                      <label>ZIP CODE</label>
                      <p>$t_add_zip</p>
                    </div>
                    <div class='detail-cont'>
                      <label>CITY</label>
                      <p>$t_add_city</p>
                    </div>  
                  </div>
                </div>

                <div class='user-details-2'>
                  <div class='detail-arrangement'>
                  <div class='detail-cont' id='view-email-cont'>
                    <label>EMAIL</label>
                    <p>$t_email</p>
                    <p>$t_email_view</p>
                  </div>
                  </div>
                  <div class='detail-cont' id='view-contact-cont'>
                    <label>CONTACT</label>
                    <p>$t_contact</p>
                    <p>$t_contact_view</p>
                  </div>
                  
                  <div class='detail-arrangement'>
                  <div class='detail-cont'>
                    <label>ORDER DATE</label>
                    <p  style='opacity:0.65;'>$formattedDate</p>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <div class='order-details'>
              <div class='order-payment-details'>
                <div class='detail-cont' style='width:60%;'>
                  <label>PAYMENT METHOD</label>
                  <p>$p_method</p>
                </div>

                $p_card_cont
              </div>
              <div class='order-cart-details' >
                <div class='order-detail-cart' style='width:60%;'>
                  <div class='detail-cont'>
                    <label>TOTAL ITEMS</label>
                    <p>$p_total_items</p>
                  </div>
                  <div class='detail-cont'>
                    <label>TOTAL COST</label>
                    <p><span>₱ </span>$p_total</p>
                  </div>
                </div>
                
                <div class='order-detail-session' style='width:40%;'>
                  
                  <div class='detail-cont' >
                      <label>ID</label>
                      <p>$p_id</p>
                  </div>
                  <div class='detail-cont'>
                    <label>STATUS</label>
                    <p class='status-$pending_class'>$pending_stat</p>
                  </div>
                </div>

              </div>
            </div>

         
            $pending_action
        </form>
      </div>
      
      ";
  }
  return $value;
}

function OrdersDisplayProductsPage()
{

  $current_page = $GLOBALS['current_page'];
  $c_p_page = $GLOBALS['contents_per_page'];
  $value = "";

  $product_amount = 0;

  $sort = "ASC";
  if (isset($_SESSION['admin-orders-sort'])) {
    $sort = $_SESSION['admin-orders-sort'];
  }
  $con = $GLOBALS['con'];
  $query = "SELECT * from fp_users_transaction ORDER BY user_transaction_date $sort";
  if (isset($_SESSION['search-orders-value']) && !empty($_SESSION['search-orders-value'])) {

    $current_page = 1;
    $search_value = $_SESSION['search-orders-value'];
    $query = "SELECT * from fp_users_transaction WHERE transaction_status AND payment_method LIKE '%$search_value%' or user_address_street LIKE '%$search_value%' ORDER BY user_transaction_date $sort";
  }
  $result = $con->query($query);

  if ($result && mysqli_num_rows($result) > 0) {
    while (mysqli_fetch_assoc($result)) {
      $product_amount++;
    }
  }
  $page_amount =  floor($product_amount / $c_p_page);

  if ($product_amount == $c_p_page) {
    $page_amount--;
  }

  $value .=

    "
      <form method='GET'>
      <div class='page-section-cont'>
     
              <button type='submit' name='prev-page' id='page-prev' class='page-action'></button>";
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
  $_SESSION['max-page'] = $page_amount;
  $value  .= "
              <button type='submit' name='next-page' id='page-next' class='page-action'></button>
      </div>
      </form>";
  return $value;
}

function OrdersDisplayProducts()
{
  $value = "
  <form class='orders-products-list' method='GET' action=''>
  <div class='orders-info-cont'>
    <div class='info-cont-div' id='toggle-select-order'>  
      <input type='checkbox'>
    </div>
    <div class='info-cont-div'>  
      <p>Order ID</p>
    </div>
    <div class='info-cont-div' id='text-left'>  
      <p>Order Date</p>
    </div>
    <div class='info-cont-div' id='text-left'>  
      <p>Customer Name</p>
    </div>
    <div class='info-cont-div' id='text-left'>  
      <p>Address</p>
    </div>
    <div class='info-cont-div'>  
      <p>Payment Method </p>
    </div>
    <div class='info-cont-div' id='text-cash'>  
      <p>Total</p>
    </div>
    <div class='info-cont-div'>  
      <div class='status-sort-button' >
        <p>Status</p>
      </div>
    </div>
  </div>

  ";
  $current_page = $GLOBALS['current_page'];
  $con = $GLOBALS['con'];
  $sort = "ASC";
  if (isset($_SESSION['admin-orders-sort'])) {
    $sort = $_SESSION['admin-orders-sort'];
  }
  $query = "SELECT * from fp_users_transaction ORDER BY user_transaction_date $sort";
  if (isset($_SESSION['search-orders-value']) && !empty($_SESSION['search-orders-value'])) {

    $current_page = 1;
    $search_value = $_SESSION['search-orders-value'];
    $query = "SELECT * from fp_users_transaction WHERE transaction_status LIKE '%$search_value%' OR payment_method LIKE '%$search_value%' or user_address_street LIKE '%$search_value%' ORDER BY user_transaction_date $sort";
  }
  $c_p_page = $GLOBALS['contents_per_page'];

  $query .= " LIMIT $c_p_page OFFSET " . ($c_p_page * ($current_page - 1));

  $result = $con->query($query);
  $cont_id = 0;
  if ($result && mysqli_num_rows($result) > 0) {
    while ($transaction = mysqli_fetch_assoc($result)) {
      $pending_stat = "";
      $pending_class = "";
      $p_state = "disabled";


      $dateTime = new DateTime($transaction["user_transaction_date"]);
      $formattedDate = $dateTime->format('M j, g:i A');

      switch ($transaction["transaction_status"]) {
        case 'pending':
          $pending_stat = "Pending";
          $pending_class = "red";
          break;

        case 'shipping':
          $pending_stat = "Shipping";
          $pending_class = "orange";
          break;

        case 'success':
          $pending_stat = "Success";
          $pending_class = "green";
          break;

        case 'cancelled':
          $pending_stat = "Cancelled";
          $pending_class = "red";
          break;

        case 'rejected':
          $pending_stat = "Rejected";
          $pending_class = "black";
          break;

        case '':
          $pending_stat = "Pending";
          $pending_class = "red";
          break;
        default:

          $pending_stat = "Pending";
          $pending_class = "red";
          break;
      }

      $t_f_name = RequestDecrypt($transaction["user_first_name"]);

      //$t_l_name = RequestDecrypt($transaction["user_last_name"]);
      $t_address_street = RequestDecrypt($transaction["user_address_street"]);
      //$t_address_zip = RequestDecrypt($transaction["user_address_zip"] );
      //$t_address_city = RequestDecrypt($transaction["user_address_city"] );

      //$t_address = $t_address_street." ".$t_address_zip." ".$t_address_city;
      $t_address = $t_address_street;
      // $t_name = $t_f_name." ".$t_l_name;
      $t_name = $t_f_name;
      if ($pending_stat == "Pending") {
        $p_state = " onclick='SetProductSelection($cont_id,this);'";
      }
      $value .= "
     <div class='orders-product-cont' id='orders-product-cont-$cont_id' >
        <div class='info-cont-div' id='toggle-select-order'>  
            <input $p_state class='order-selection-class' id='$cont_id' type='checkbox'>
        </div>
        <div class='info-cont-div'>  
          <p>" . $transaction["transaction_id"] . "</p>
        </div>
        <div class='info-cont-div' id='text-left'>  
          <p>" . $formattedDate . "</p>
        </div>
        <div class='info-cont-div' id='text-left'>  
          <p>$t_name</p>
        </div>
        <div class='info-cont-div' id='text-address'>  
          <p> $t_address </p>
        </div>
        <div class='info-cont-div'>  
          <p>" . $transaction["payment_method"] . "</p>
        </div>
        <div class='info-cont-div' id='text-cash'>  
          <p><span>₱</span> " . $transaction["user_transaction_total"] . "</p>
        </div>
        <div class='info-cont-div'>  
            <div class='status-center' id='status-center-$pending_class'>
              <div class='status-ping-$pending_class'></div>
              <p class='status-$pending_class' >$pending_stat</p>
            </div>
      
        </div>
        <div class='cont-bg-overlay' id='order-cont-bg-id-$cont_id'>
        </div>
        <div class='cont-bg-select-all' onclick='RequestViewOrder(" . $transaction["transaction_id"] . ");'>
        </div>

     </div>";
      $cont_id++;
    }
  }

  $value .= "</form>";


  // value = page < 0 1 2 > contents here
  return $value;
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>furrpection</title>
  <link rel="stylesheet" href="CSS/admin_dashboard.css">
  <link rel="stylesheet" href="CSS/admin_sidebar.css">

  <link rel="stylesheet" href="CSS/main_search.css">

  <link rel="stylesheet" href="CSS/admin_dashboard_orders.css">

  <link rel="stylesheet" href="CSS/main_paging.css">
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
    <a href="admin_dashboard_products.php" class="side-bar-selection">
      <div class='sidebar-icons' id="icon-products"> </div>
      <p>Products</p>
      <div class="selection-highlight"></div>
    </a>
    <a href="admin_dashboard_orders.php" class="side-bar-selection" id="side-bar-selected">
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
    <div id="dark-bg" onclick="RequestViewCancel();">
    </div>

    <div class='notifier-cont'>
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
      <div class='action-selection' id='action-selection-id'>
        <p id='action-selection-p-id'>1 order selected</p>
        <button id='selected-orders-id' class='orders-action-approve' type='submit' name='approve-multiple-order' value=''>
          <p>APPROVE</p>
        </button>
      </div>
    </div>


    <?php
    echo DisplayDetailedOrder();
    ?>

    <div class="orders-action-cont">
      <form method="GET" action="">
        <button id='orders-action-button' name="view-orders" type='submit' value=''>
        </button>
      </form>
    </div>
    <div class="orders-search-cont">
      <h1>Pending Orders</h1>
      <form method="GET" action="">
        <div class="search-cont">
          <button class="search-sort-button" type="submit" name="sort-submit">
            <p>Sort</p>
            <?php
            if (isset($_SESSION['admin-orders-sort'])) {
              if ($_SESSION['admin-orders-sort'] == "ASC") {
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
            <input placeholder="Search" name="admin-orders-search" autocomplete="off">
          </div>
          <button class="search-button" type="submit" name="admin-orders-search-submit" id='search-button-id'>
            <img src="CSS/Resources/Icons/icon-arrow-1.svg">
            <p>SEARCH</p>
          </button>
        </div>

      </form>
    </div>
    <div class="orders-products-cont">
      <?php
      echo  OrdersDisplayProducts();
      ?>
    </div>
    <div class="orders-products-page-cont">
      <?php
      echo  OrdersDisplayProductsPage();
      ?>
    </div>
  </div>

  <script type="text/javascript" src="JS/admin_dashboard_orders.js"></script>
  
  <script type="text/javascript" src="JS/admin_dashboard_search.js"></script>
  <?php

  if (isset($_SESSION['view-order-id'])) {

    echo "<script>ToggleBG();</script>";
    unset($_SESSION['view-order-id']);
  }
  ?>
</body>

</html>