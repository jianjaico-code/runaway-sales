<?php
session_start();
$conn = require "php/connection.php";

if(!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}

$supplier = $conn->query("
  SELECT * FROM supplier WHERE SupplierId = $_GET[supplierid]
")->fetch_assoc();

$recents = $conn->query("
  SELECT *
  FROM purchaseorder
  WHERE SupplierId = $_GET[supplierid]
")->fetch_all(MYSQLI_ASSOC);
$requestcount = count($recents);
$approved = 0;
$counter = 0;
$tbody = "";
foreach ($recents as $recent) {
  if ($counter < 4) {
    $badgecolor = ($recent["POStatus"] == "pending") ? "danger" : (($recent["POStatus"] == "delivered") ? "success" : "info");
    $status = ucfirst($recent["POStatus"]);
    $postatus = "<span class='badge badge-pill badge-$badgecolor'>$status</span>";
    $date = new DateTime($recent["PODate"]);
    $orderdate = $date->format("F j, Y, g:i a");
    
      $tbody .= "
      <tr>
        <td>$recent[PurchaseOrderId]</td>
        <td>$orderdate</td>
        <td>$recent[PODeliveryAddress]</td>
        <td>$postatus</td>
      </tr>
      ";
  }
  if($recent["POStatus"] == "delivered") {
    $approved++;
  }

  $counter++;
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

  <nav class="navbar navbar-expand navbar-dark bg-primary sticky-top">

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <a class="navbar-brand mr-1" href="index.php">Runway</a>

    <!-- Haxk -->
    <span class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></span>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          Ryan Rafal &nbsp;<i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#logout">Logout</a>
        </div>
      </li>
    </ul>

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
      <li class="nav-item dropdown">
        <a class="nav-link" href="reports.php">
          <i class="fas fa-fw fa-file"></i>
          <span>Reports</span>
        </a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container">
        <h1>View Supplier</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>

          <li class="breadcrumb-item">
            <a href="supplier.php">Supplier</a>
          </li>
          <li class="breadcrumb-item active">View Supplier</li>
        </ol>

        <!-- Page Content -->

        <div class="row">
          <div class="col">
            <div class="card mb-3">
              <div class="card-body">
              <div class="d-flex align-item-center justify-content-between">
                <h4 class="card-title text-primary font-weight-bold"><?php echo ucfirst($supplier["SCompanyName"]) ?></h4>
                <a href="requestsupply.php?supplierid=<?php echo $supplier["SupplierId"]?>" class="btn btn-primary">Request supply</a>
              </div>
              <h6 class="text-muted"><?php echo $supplier["SAddress"] ?></h6>
              <h6 class="text-muted pb-4">+63<?php echo $supplier["SContactNo"] ?></h6>
              <hr>
              <div class="row mt-3">
                <div class="col-sm-12 col-md-4 text-center my-3">
                  <small class="text-muted d-block">All Request</small>
                  <span class="font-weight-bold text-primary"><?php echo $requestcount?></span>
                </div>
                <div class="col-sm-12 col-md-4 text-center my-3">
                  <small class="text-muted d-block">Approved Request</small>
                  <span class="font-weight-bold text-primary"><?php echo $approved?></span>
                </div>
                <div class="col-sm-12 col-md-4 text-center my-3">
                  <small class="text-muted d-block">Items Refunded</small>
                  <span class="font-weight-bold text-primary">50</span>
                </div>
              </div>
              </div>
            </div>
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="font-weight-bold card-title text-primary mb-0">Recent Supply Request</h5>
                  <a href="#" class="card-link text-uppercase text-primary small">All Delivered</a>
                </div>
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="row">Order Id</th>
                        <th scope="row">Date</th>
                        <th scope="row">Address</th>
                        <th scope="row">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $tbody?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
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
  <script src="node_modules/moment/min/moment.min.js"></script>

  <!-- datatables exts -->
  <script src="vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="vendor/datatables/dataTables.select.min.js"></script>
  <script src="vendor/datatables/buttons.print.min.js"></script>
  <script src="vendor/datatables/buttons.html5.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/plugins/modal.js"></script>
  <script src="js/sb-admin.min.js"></script>

</body>
</html>