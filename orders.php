<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
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
")->fetch_all(MYSQLI_ASSOC);
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

  <!-- Bootstrap core CSS-->

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
    <ul class="navbar-nav ml-auto ml-md-0 ">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          Ryan Rafal &nbsp;<i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <div class="dropdown-divider"></div>
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
        <h1>Orders</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Orders</li>
        </ol>

        <!-- Page Content -->
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                  <h4>Orders</h4>
                  <a href="ordersadd.php" class="btn btn-primary">Add Order</a>
                </div>



                <!-- table filter -->
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white" id="filteraddon">Filter</span>
                  </div>
                  <select class="custom-select" name="filterOrders" id="filterOrders" aria-describedby="filteraddon">
                    <option value=".">All</option>
                    <option value="delivered">Delivered</option>
                    <option value="pending">Pending</option>
                    <option value="onfulfillment">Onfulfillment</option>
                  </select>
                </div>

                <div class="table-responsive">
                  <table class="table table-borderless" id="viewOrders" width="100%">
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
                        $total = round($order["Total"], 2);
                        echo
                        "
                        <tr scope='row' data-id='$order[OrderId]'>
                          <td>$order[OrderId]</td>
                          <td>$orderdate</td>
                          <td>$customerfullname</td>
                          <td>$deliverystatus</td>
                          <td>$total</td>
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

        <!-- page content end -->

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
  <!-- datatables extensions -->
  <script src="vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="vendor/datatables/dataTables.select.min.js"></script>
  <script src="vendor/datatables/buttons.print.min.js"></script>
  <script src="vendor/datatables/buttons.html5.min.js"></script>
  <script src="vendor/moment/moment.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/plugins/modal.js"></script>
  <script src="js/sb-admin.min.js"></script>

</body>
<script>
 "use strict";var search=new URLSearchParams(window.location.search||null);$(function(){var t=$("#viewOrders").DataTable({dom:"Bfrtip",order: [[0, "DESC"]],select:{style:"single"},buttons:[{extend:"print",text:'Print &nbsp;<i class="fa fa-print"></i>',className:"btn btn-outline-primary",title:"Runway Direct Sales Report for"+moment().format("MMMM D YYYY")},{extend:"csv",text:'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',className:"btn btn-outline-primary",title:"Runway Direct Sales Report for"+moment().format("MMMM D YYYY")},{text:"Manage Order",className:"btn btn-primary invisible"}]});search.get("customername")&&t.columns(2).data().search(search.get("customername"),!0,!1).draw(),$("#filterOrders").on("change",function(e){t.columns(3).data().search($(this).val(),!0,!1).draw()}),$("#viewOrders").on("click","tbody tr",function(e){return $(e.currentTarget).hasClass("selected")?$("body").find(".dt-buttons").children(":last-child").addClass("invisible"):$("body").find(".dt-buttons").children(":last-child").removeClass("invisible")}),$("body").find(".dt-buttons").children(":last-child").on("click",function(e){location.replace("vieworder.php?orderid=".concat($("#viewOrders").find(".selected").children(":first-child").text()))})});
</script>

</html>