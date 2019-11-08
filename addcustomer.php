<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}

$conn = require "php/connection.php";
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
        <h1>Add Customer</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
           <li class="breadcrumb-item">
            <a href="customers.php">Customers</a>
          </li>
          <li class="breadcrumb-item active">Add Customers</li>
        </ol>

        <!-- Page Content -->
        <div class="row">
          <div class="col-sm-12 col-md-8">
            <div class="card mb-3">
              <div class="card-body">
                <form id="createcustomer">
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                <label for="CFirstname">Firstname</label>
                <input type="text" name="CFirstname" id="CFirstname" class="form-control" required placeholder="Firstname">
              </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                <label for="CLastname">Lastname</label>
                <input type="text" name="CLastname" id="CLastname" class="form-control" required placeholder="Lastname">
              </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                <label for="CContact">Contact No</label>
                <input type="number" id="CContact" name="CContact" class="form-control" required placeholder="+639xxxxxxx">
                <small class="text-muted">This will serve as a username.</small>
              </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                <label for="CPassword">Password</label>
                <input type="password" class="form-control" id="CPassword" name="CPassword" required placeholder="Password">
              </div>
                </div>
              </div>
              <div class="form-group">
                <label for="CAddress">Address</label>
                <input type="text" class="form-control" id="CAddress" name="CAddress" required placeholder="Address">
              </div>
            </form>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="card mb-3">
              <div class="card-body">
                <h6 class="h6 text-primary">Summary</h6>
                <p class="mb-1">Name: <span id="summarycustomerfname"></span>&nbsp;<span id="summarycustomerlname"></span></p> 
                <p class="mb-1">Contact: <span id="summarycustomercontact"></span></p> 
                <p class="mb-1">Address: <span id="summarycustomeraddress"></span></p> 
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-12 col-md-8 d-flex justify-content-end">
            <button class="btn btn-primary" onclick="$('#createcustomer').submit()">Click me</button>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Runway Direct Sales <?php $date = new DateTime();
                                                  echo $date->format("Y") ?></span>
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
<script>
"use strict";jQuery(function(){$("#CFirstname").on("blur",function(e){$("#summarycustomerfname").text(e.target.value)}),$("#CLastname").on("blur",function(e){$("#summarycustomerlname").text(e.target.value)}),$("#CContact").on("blur",function(e){$("#summarycustomercontact").text(e.target.value)}),$("#CAddress").on("blur",function(e){$("#summarycustomeraddress").text(e.target.value)}),$("#createcustomer").submit(function(e){if(e.preventDefault(),!($("#CFirstname").val()&&$("#CLastname").val()&&$("#CAddress").val()&&$("#CContact").val()&&$("#CPassword").val()))return $("body").showAlert({type:"warning",body:"Please input information about the customer."});$.ajax("/api/employee/register.customer.php",{method:"POST",data:new FormData(e.target),cache:!1,contentType:!1,processData:!1}).then(function(e){if(JSON.parse(e).response)return $("#CFirstname").val(""),$("#CLastname").val(""),$("#CAddress").val(""),$("#CContact").val(""),$("#CPassword").val(""),$("#summarycustomerfname").text(""),$("#summarycustomerlname").text(""),$("#summarycustomeraddress").text(""),$("#summarycustomercontact").text(""),$("body").showAlert({type:"success",body:"Customer created."});$("body").showAlert({type:"warning",body:"Operation failed. Try again later."})}).catch(function(){$("body").showAlert({type:"warning",body:"Something happened on our side. Please reload the browser for better experience"})})})});
</script>

</html>