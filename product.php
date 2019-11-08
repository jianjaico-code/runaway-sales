<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}

$conn = require "php/connection.php";
$product;
if(isset($_GET["productid"])) {
  $productid = $_GET["productid"];
  $product = $conn->query("
    SELECT *
    FROM product
    INNER JOIN productcategory on product.ProductId = productcategory.ProductId
    WHERE product.ProductId = $productid
  ")->fetch_assoc();
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
        <h1>Add Product</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="products.php">Products</a>
          </li>
          <li class="breadcrumb-item active">Add Product</li>
        </ol>
        <!-- Page Content -->
       <div class="row mb-5">
          <div class="col">
              <div class="card">
                  <div class="card-body">
                      <form action="#" id="addproduct">
                          <div class="row">
                              <div class="col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label for="PName">Name</label>
                                      <input type="text" name="PName" id="PName" required placeholder="Some cool t-shirt" class="form-control" >
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label for="PBrand">Brand</label>
                                      <input type="text" name="PBrand" id="PBrand" required placeholder="Bench" class="form-control">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-12 col-md-6">
                                  <div class="form-group">
                                      <label for="PPrice">Price</label>
                                      <input type="number" class="form-control" name="PPrice" id="PPrice" step=".01" required placeholder="100" >
                                  </div>
                                  <div class="form-group">
                                      <label for="PQuantity">Stock</label>
                                      <input type="number" class="form-control" name="PQuantity" id="PQuantity" required min="1"  placeholder="20" >
                                  </div>  
                                  <div class="form-group">
                                      <label for="PSizes">Sizes</label>
                                      <input type="text" class="form-control" name="PSizes" id="PSizes" placeholder="Add sizes separated by a comma" >
                                  </div>

                                  <div class="form-group">
                                      <label for="PColors">Colors</label>
                                      <input type="text" class="form-control" name="PColors" id="PColors" placeholder="Add colors separated by a comma" >
                                  </div>


                                  <div class="form-group">
                                    <label for="PImage">Upload File</label>
                                    <input type="file" name="PImage" id="PImage" class="form-control invisible" style="margin-left: -5000px !important; position: absolute">
                                    <input type="button" class="btn btn-outline-primary" value="Choose File" id="PImageRef" onclick="$('#PImage').click()">
                                    <span class="image-name"></span>
                                    <small class="d-block text-muted">Image must be less than 1MB.</small>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-6">
                              
                                <img src="http://placehold.it/600x600/EEE/333?text=Image+Preview" id="PImagePreview" class="img-fluid rounded">
                              </div>
                          </div>

                          <input type="reset" value="reset" class="d-none">
                          <div class="d-flex justify-content-end mt-5">
                          <input type='submit' value='Add Product' class='btn btn-primary'>
                          </div>
                      </form>
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
<script>

"use strict";jQuery(function(){$("#PImage").on("change",function(e){$(".image-name").html(e.target.files[0].name);var t=new FileReader;t.onload=function(e){$("#PImagePreview").attr("src",t.result)},t.readAsDataURL(e.target.files[0])}),$("#addproduct").submit(function(e){$.ajax("/api/employee/addproduct.php",{method:"POST",data:new FormData(e.target),processData:!1,cache:!1,contentType:!1}).then(function(e){if(JSON.parse(e).response)return $("body").showAlert({type:"success",body:"Product added successfully"}),$("input[type='reset']").click(),$("#PImagePreview").attr("src","http://placehold.it/600x600/EEE/333?text=Image+Preview"),void $(".image-name").html("");$("body").showAlert({type:"info",body:"Operation failed. Try again later."})}).catch(function(){$("body").showAlert({type:"warning",body:"Something happened on our side. Please reload the browser for better experience."})}),e.preventDefault()}),$("#updateproduct").submit(function(e){$.ajax("/product.php",{method:"POST",data:new FormData(e.target),processData:!1,cache:!1,contentType:!1}).then(function(e){console.log(e),JSON.parse(e).response&&($("body").showAlert({type:"success",body:"Product added successfully"}),setTimeout(function(){window.location.replace("/product.php")},4e3)),$("body").showAlert({type:"info",body:"Operation failed. Try again later."})}).catch(function(e){console.log(e),$("body").showAlert({type:"warning",body:"Something happened on our side. Please reload the browser for better experience."})}),e.preventDefault()})});

</script>

</html>


<?php
function update($table, $update, $productid) {
  return $conn->query("UPDATE $table SET $update WHERE $table.ProductId = $productid");
}
?>