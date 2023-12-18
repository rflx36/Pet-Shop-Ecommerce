<?php
include("PHP/log_connection.php");
include("PHP/log_functions.php");
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
}

// Your database connection logic goes here

// Fetch data from the database
$query = "SELECT user_transaction_date, user_transaction_total FROM fp_users_transaction WHERE transaction_status='success'";
$result = mysqli_query($con, $query);

// Extract data for the chart
$dates = [];
$values = [];

while ($row = mysqli_fetch_assoc($result)) {
  $dates[] = $row['user_transaction_date'];
  $values[] = $row['user_transaction_total'];
}

?>


<!DOCTYPE html>
<html>

<head>
  <title>furrpection</title>
  <link rel="stylesheet" href="CSS/admin_dashboard.css">
  <link rel="stylesheet" href="CSS/admin_sidebar.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="side-bar">
    <div class="logo-icon">
      <h1>FURRPECTION</h1>
    </div>
    <a href="admin_dashboard.php" class="side-bar-selection" id="side-bar-selected">
      <div class='sidebar-icons' id="icon-dashboard"> </div>
      <p>Dashboard</p>
      <div class="selection-highlight"></div>
    </a>
    <a href="admin_dashboard_products.php" class="side-bar-selection">
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
    <div class='chart-'>
      <div class="tabs">
        <button onclick="openTab('day')">This Day</button>
        <button onclick="openTab('week')">This Week</button>
        <button onclick="openTab('month')">This Month</button>
      </div>

      <div id="day" class="tab-content">

      </div>
      <div class="chart-container">
        <canvas id="day-chart"></canvas>
      </div>
    </div>



  </div>
  <script>
    // Pass data from PHP to JavaScript

    var dates = <?php $formattedDates = array_map(function ($date) {
                  return (new DateTime($date))->format('M j, g:i A');
                }, $dates);

                echo json_encode($formattedDates); ?>;
    var values = <?php echo json_encode($values); ?>;

    function loadChart(tabName, label) {
      // Make an AJAX request or include PHP code to fetch data from the server
      // For simplicity, I'll include PHP code directly here


      // Create the chart
      var ctx = document.getElementById(tabName + '-chart').getContext('2d');
      var gradient = ctx.createLinearGradient(0, 0, 0, 400); // Adjust gradient direction and size as needed
      gradient.addColorStop(0, 'rgba(75, 192, 192, 0.2)');
      gradient.addColorStop(1, 'rgba(75, 192, 192, 0)');
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: dates,
          datasets: [{
            data: values,
            borderColor: '#EC704B', // Change to the desired color
            borderWidth: 2,
            fill: {
              target: 'origin',
              gradient: gradient // Use the gradient as the fill
            },
            pointRadius: 4,
            pointBackgroundColor: '#EC704B', // Change to the desired color
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          },
          legend: {
            display: false
          },
        
          elements: {
            line: {
              tension: 0.4, // Adjust tension to make lines curvy
            }
          },
          responsive: true, // Make the chart responsive
          maintainAspectRatio: false
        }
      });
    }
  </script>
  <script src="JS/admin_dashboard.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>