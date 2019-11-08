<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}
$conn = require "php/connection.php";


$orderid = $_GET["orderid"];
$order = $conn->query("
  SELECT 
    orders.OrderId,
    orders.CustomerId,
    orders.Amount,
    orders.OrderDate,
    customer.CFirstname as firstn,
    customer.CLastname as lastn,
    customer.CDeliveryAddress as address,
    customer.CCellphoneNo as contact,
    customerdelivery.DeliveryStatus as status
  FROM ((orders
  INNER JOIN customer ON orders.CustomerId = customer.CustomerId)
  INNER JOIN customerdelivery ON orders.OrderId = customerdelivery.OrderId)
  WHERE
    orders.OrderId = $orderid
")->fetch_assoc();

$orderDetails = $conn->query("
  SELECT
    orderdetails.ProductId,
    orderdetails.OrderQuantity,
    orderdetails.OrderId,
    productcategory.PName as name,
    productcategory.PPrice as price
  FROM orderdetails
  INNER JOIN productcategory ON productcategory.ProductId = orderdetails.ProductId
  WHERE orderdetails.OrderId = $orderid
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

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-primary static-top">

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
        <h1>View Order</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="orders.php">Orders</a>
          </li>
          <li class="breadcrumb-item active">View Order</li>
        </ol>

        <!-- Page Content -->

        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title text-primary">Order Information</h5>
                <p class="mb-1">Order #: <?php echo $order["OrderId"];?></p>
                <p class="mb-1">Order status: <?php echo ucfirst($order["status"]); ?></p>
                <p class="mb-1">Order date: <?php
                $date = new DateTime($order["OrderDate"]);
                $orderdate = $date->format("F j, Y, g:i a");
                echo $orderdate;
                ?></p>
                <hr />
                <h5 class="card-title text-primary">Order Details</h5>
                <div id="orderdetailsview">
                  <?php
                  $total = 0;
                  foreach($orderDetails as $detail)
                  {
                    $total += $detail["OrderQuantity"] * $detail["price"];
                    $isDelivered = $order["status"] == "delivered" ? "visible" : "invisible";
                    echo
                      "
                    <div class='d-flex justify-content-between align-items-center mb-1'>
                      <span class='card-text'><a href='#' data-id='$detail[ProductId]' data-order='$detail[OrderId]' data-quantity='$detail[OrderQuantity]' data-name='$detail[name]' class='fa fa-undo card-link smaller order-return $isDelivered'></a>&nbsp;$detail[name]</span>
                      <span class='small' title='Order Quantity'>$detail[OrderQuantity]</span>
                    </div>
                    ";
                  }

                  ?>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <h4 class="card-text text-primary text-uppercase font-weight-bold">Total</4>
                  <h4 class="h4"><?php echo $total?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <div class="card">
              <div class="card-body">
                <h6 class="h6 card-title">Customer Information</h6>
                <p class="text-uppercase font-weight-bold m-0"><a href="viewcustomer.php?customerid=<?php echo $order["CustomerId"]?>" class="card-link">
                  <?php
                  echo ucfirst($order["firstn"]) . " " . ucfirst($order["lastn"]);
                  ?>
                  </a></p>
                <hr>
                <h6 class="h6 card-subtitle">Contact Information</h6>
                <p class="text-muted">+63<?php echo $order["contact"]?></p>
                <hr>
                <h6 class="h6 card-subtitle">Billing Address</h6>
                <p class="text-muted"><?php echo $order["address"] ?></p>
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

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

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

  <!-- Custom scripts for all pages-->
  <script src="js/plugins/modal.js"></script>
  <script src="js/plugins/alert.js"></script>
  <script src="js/sb-admin.min.js"></script>


</body>
<script>
"use strict";$(function(){$("body").on("click",".order-return",function(a){$("#runwayModal").Modal({size:"md",title:"Return items",buttons:['<a href="#" data-dismiss="modal" class="btn btn-outline-danger">Cancel</a>','<a href="#" data-action="markasreturned" class="btn btn-primary">Mark as returned</a>'],body:'\n          <h3 class="h5 card-title">'.concat($(a.currentTarget).data("name"),'</h5>\n          <label for="returnItemQuantity">Return item count</label>\n          <input type="number" class="form-control" min="1" value="1" max="').concat($(a.currentTarget).data("quantity"),'" id="returnItemQuantity" name="returnItemQuantity" />\n          <label for="returnItemReason" class="mt-3">Reason</label>\n          <textarea width="100%" height="150px" style="resize: noresize" id="returnItemReason" name="returnItemReason" class="form-control" placeholder="The handle is damaged."/>\n        ')},function(t){$(t).modal("show"),$(t).on("click","a[data-action='markasreturned']",function(t){if($("#returnItemQuantity").val()>$(a.currentTarget).data("quantity"))return $("#returnItemQuantity").focus();if(!$("#returnItemReason").val())return $("#returnItemReason").focus();var e=new FormData;e.append("orderid",$(a.currentTarget).data("order")),e.append("productid",$(a.currentTarget).data("id")),e.append("count",$("input[name='returnItemQuantity']").val()),e.append("reason",$("textarea[name='returnItemReason']").val()),$.ajax("/api/returnitem.php",{method:"POST",data:e,cache:!1,processData:!1,contentType:!1,dataType:"json"}).then(function(t){if(t.response)return $("body").showAlert({type:"success",body:"Operation success"});$("body").showAlert({type:"danger",body:"Operation failed. Try again later"})}).catch(console.error)})})})});

/* 
  $(function() {
    //make orderdetail reject
    $("body").on("click", ".order-return", function(event) {
      $("#runwayModal").Modal({
        size: "md",
        title: "Return items",
        buttons: [
          `<a href="#" data-dismiss="modal" class="btn btn-outline-danger">Cancel</a>`,
          `<a href="#" data-action="markasreturned" class="btn btn-primary">Mark as returned</a>`
        ],
        body: `
          <h3 class="h5 card-title">${$(event.currentTarget).data("name")}</h5>
          <label for="returnItemQuantity">Return item count</label>
          <input type="number" class="form-control" min="1" value="1" max="${$(event.currentTarget).data("quantity")}" id="returnItemQuantity" name="returnItemQuantity" />
          <label for="returnItemReason" class="mt-3">Reason</label>
          <textarea width="100%" height="150px" style="resize: noresize" id="returnItemReason" name="returnItemReason" class="form-control" placeholder="The handle is damaged."/>
        `
      }, modal => {
        $(modal).modal("show")
        $(modal).on("click", "a[data-action='markasreturned']", e => {
          if($("#returnItemQuantity").val() > $(event.currentTarget).data("quantity")) {
            return $("#returnItemQuantity").focus()
          }

          if(!$("#returnItemReason").val()) {
            return $("#returnItemReason").focus()
          }


          var fd = new FormData();
          fd.append("orderid", $(event.currentTarget).data("order"))
          fd.append("productid", $(event.currentTarget).data("id"))
          fd.append("count", $("input[name='returnItemQuantity']").val())
          fd.append("reason", $("textarea[name='returnItemReason']").val())

          $.ajax("/api/returnitem.php", {
            method: "POST",
            data: fd,
            cache: false,
            processData: false,
            contentType: false
          })
          .then(console.log)
          .catch(console.error)
        })
      })
    })
  }) */
</script>

</html>