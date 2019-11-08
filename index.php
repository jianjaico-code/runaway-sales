<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: login.php");
}
$conn = require "php/connection.php";
$orders = $conn->query("
  SELECT 
    orders.OrderId,
    orders.CustomerId,
    orders.OrderDate,
    orders.Amount Total,
    customer.CFirstname,
    customer.CLastname,
    customerdelivery.DeliveryStatus
  FROM ((orders
  INNER JOIN customer ON orders.CustomerId = customer.CustomerId)
  INNER JOIN customerdelivery ON orders.OrderId = customerdelivery.OrderId)
  WHERE (OrderDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW())
")->fetch_all(MYSQLI_ASSOC);

if($conn->error) {
  var_dump($conn->error);
  exit;
}


$cards = $conn->query("
  SELECT 
      orders.Amount AS Total,
      (SELECT 
              COUNT(*)
          FROM
              orders
          WHERE
              (orders.OrderDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW())) AS ordercount,
      (SELECT 
              COUNT(*)
          FROM
              orders
                  INNER JOIN
              customerdelivery ON orders.OrderId = customerdelivery.OrderId
          WHERE
              (OrderDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW())
                  AND customerdelivery.deliverystatus = 'delivered') AS delivereditems
  FROM
      orders
  WHERE (orders.OrderDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW())
")->fetch_all(MYSQLI_ASSOC);

if ($conn->error) {
  var_dump($conn->error);
}

$total = $ordereditems = $delivereditems  = 0;

$returns = $conn->query("
  SELECT COUNT(*) as count
  FROM returns
  WHERE (returns.ReturnDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW())
")->fetch_assoc();

foreach ($cards as $card) {
  $total += doubleval($card["Total"]);
  $delivereditems = $card["delivereditems"];
  $ordereditems = $card["ordercount"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Runway Direct Sales</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark sticky-top bg-primary">

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <a class="navbar-brand mr-1" href="index.php">Runway</a>

    <!-- Haxk -->
    <span class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></span>

    <!-- Navbar -->
    <?php include "php/components/header.admin.php"?>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav bg-secondary">
      <!-- dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
 <!-- orders -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="ordersDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-truck"></i>
          <span>Orders</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="ordersDropdown">
          <a class="dropdown-item" href="orders.php">All Orders</a>
          <a class="dropdown-item" href="ordersadd.php">Add Order</a>
        </div>
      </li>

      <!-- products -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="ordersDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-tshirt"></i>
          <span>Products</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="ordersDropdown">
          <a class="dropdown-item" href="products.php">All Products</a>
          <a class="dropdown-item" href="product.php">Add Product</a>
          <a class="dropdown-item" href="inventory.php">Inventory</a>
        </div>
      </li>

          <!-- customer -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="ordersDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-tshirt"></i>
          <span>Customer</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="ordersDropdown">
          <a class="dropdown-item" href="customers.php">All Customer</a>
          <a class="dropdown-item" href="addcustomer.php">Add Customer</a>
        </div>
      </li>

      <!-- supplier -->
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="suppliersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <i class="fas fa-fw fa-box"></i>
          <span>Supplier</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="suppliersDropdown">
          <a class="dropdown-item" href="supplier.php">All Supplier</a>
          <a class="dropdown-item" href="requestsupply.php">Request Supply</a>
        </div>
      </li>

      <!-- reports -->
      <li class="nav-item">
        <a href="reports.php" class="nav-link">
          <i class="fas fa-fw fa-file"></i>
          Reports
        </a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container">

        <h1 class="h1">Dashboard</h1>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white border border-1 border-grey small">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Page Content -->
        <div class="row">
          <!-- sales -->
          <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
            <div class="card h-100">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                  <h4 class="h4 m-0 text-uppercase font-weight-bold">Sales</h4>
                </div>
                <h1 class="h3"><?php echo $total ?> PHP</h1>
                <p class="card-subtitle text-uppercase text-muted small m-0">Daily gross sales</p>
              </div>

            </div>
          </div>
          <!-- orders -->
          <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
            <div class="card h-100">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                  <h4 class="h4 m-0 text-uppercase font-weight-bold">Orders</h4>
                </div>
                <h1 class="h3"><?php echo $ordereditems ?></h1>
                <p class="card-subtitle text-uppercase text-muted small m-0">Daily Orders Count</p>
              </div>
            </div>
          </div>
          <!-- delivered -->
          <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
            <div class="card h-100">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                  <h4 class="h4 m-0 text-uppercase font-weight-bold">Delivery</h4>
                </div>
                <h1 class="h3"><?php echo $delivereditems ?></h1>
                <p class="card-subtitle text-uppercase text-muted small m-0">Daily items delivered</p>
              </div>
            </div>
          </div>

          <!-- returns -->
          <div class="col-sm-12 col-md-6 col-lg-3 mb-2">
          <?php
          $bgcolor = $returns > 0 ? "accent" : "white";
          $fgcolor = $returns > 0 ? "white" : "dark";
          echo
            "
          <div class='card h-100 border border-1 border-light bg-$bgcolor'>
            <div class='card-body'>
              <div class='card-title d-flex justify-content-between align-items-center'>
                <h4 class='h4 m-0 text-uppercase font-weight-bold text-$fgcolor'>Returns</h4>
              </div>
                <h1 class='h3 text-$fgcolor'>$returns[count]</h1>
                <p class='card-subtitle text-uppercase m-0 small text-$fgcolor'>daily returned items</p>
              </div>
            </div>
          </div>
          ";


          ?>
        </div>


        <div class="row mb-5">
          <div class="col">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                  <h3 class="h4">Recent Orders</h3>
                  <a href="orders.php" class="btn btn-primary">View Orders</a>
                </div>
                <div class="table-responsive">
                  <table class="table table-borderless" id="recentOrders" width="100%">
                    <thead>
                      <tr>
                        <th scope="col">Order Id</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($orders as $order) {
                        $date = new DateTime($order["OrderDate"]);
                        $orderdate = $date->format("F j, Y, g:i a"); //format orderdate
                        $customerfullname = ucfirst($order["CFirstname"]) . " " . ucfirst($order["CLastname"]);
                        $badgecolor = ($order["DeliveryStatus"] == "pending") ? "danger" : (($order["DeliveryStatus"] == "delivered") ? "success" : "info");
                        $status = ucfirst($order["DeliveryStatus"]);
                        $deliverystatus = "<span class='badge badge-pill badge-$badgecolor'>$status</span>";
                        echo
                          "
                        <tr scope='row' data-id='$order[OrderId]'>
                          <td>$order[OrderId]</td>
                          <td>$orderdate</td>
                          <td>$customerfullname</td>
                          <td>$deliverystatus</td>
                          <td>$order[Total]</td>
                        </tr>
                        ";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto text-muted text-uppercase small">
              <span>Copyright © Runway Direct Sales 2018</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- datatables extensions -->
    <script src="vendor/datatables/dataTables.select.min.js"></script>
    <script src="vendor/datatables/dataTables.buttons.min.js"></script>
    <script src="vendor/datatables/buttons.print.min.js"></script>
    <script src="vendor/datatables/buttons.html5.min.js"></script>

    <script src="vendor/moment/moment.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/plugins/modal.js"></script>
    <script src="js/sb-admin.min.js"></script>
</body>
<script>
  $(function () {
    $("body").createModal({
      id: "mymodal"
    })

    $("#recentOrders").DataTable({
      order: [[0, "DESC"]],
    })
  })
</script>
</html>