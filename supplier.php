<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}

$conn = require "php/connection.php";

$suppliers = $conn->query("SELECT * FROM supplier")->fetch_all(MYSQLI_ASSOC);

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
==
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
        <h1>Suppliers</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Supplier</li>
        </ol>

        <!-- Page Content -->
        <div class="row">
          <div class="col">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                <h5 class="h5 text-primary">All Suppliers</h5>
                <a href="#supplierAddSupplier" class="btn btn-primary">Add Supplier</a>
              </div>
              <div class="table-responsive">
                <table class="table table-borderless" id="allsuppliers">
                  <thead>
                    <tr>
                      <th>Supplier Id</th>
                      <th>Company Name</th>
                      <th>Contact No</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($suppliers as $supplier) {
                      echo
                        "
                      <tr>
                      <td>$supplier[SupplierId]</td>
                      <td>$supplier[SCompanyName]</td>
                      <td>$supplier[SContactNo]</td>
                      <td>$supplier[SAddress]</td>
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
"use strict";jQuery(function(){$("#allsuppliers").DataTable({dom:"Bfrtip",select:{style:"single"},buttons:[{extend:"print",text:'Print &nbsp;<i class="fa fa-print"></i>',className:"btn btn-outline-primary",title:"Runway Direct Sales Report for"+moment().format("MMMM D YYYY")},{extend:"csv",text:'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',className:"btn btn-outline-primary",title:"Runway Direct Sales Report for"+moment().format("MMMM D YYYY")},{text:"View Supplier",className:"btn btn-primary invisible"}]}),$("#allsuppliers").on("click","tbody tr",function(e){return $(e.currentTarget).hasClass("selected")?$("body").find(".dt-buttons").children(":last-child").addClass("invisible"):$("body").find(".dt-buttons").children(":last-child").removeClass("invisible")}),$("body").find(".dt-buttons").children(":last-child").on("click",function(e){location.replace("viewsupplier.php?supplierid=".concat($("#allsuppliers").find(".selected").children().first().text()))}),$("a[href='#supplierAddSupplier']").on("click",function(e){$("#runwayModal").Modal({size:"md",title:"Add Supplier",buttons:['<a href="#" class="btn btn-outline-danger" data-dismiss="modal">Cancel</a>','<a href="#" class="btn btn-primary" data-action="addsupplier">Add Supplier</a>'],body:'\n        <form id="supplierAddSupplierForm">\n          <div class="form-group">\n            <label for="addSupplierCompanyName">Company Name</label>\n            <input type="text" class="form-control" placeholder="Company Name" name="addSupplierCompanyName" id="addSupplierCompanyName" required />\n            <small class="text-muted">(e.g) Bench</small>\n          </div>\n\n          <div class="form-group">\n            <label for="addSupplierContactNo">Contact No.</label>\n            <input type="number" class="form-control" placeholder="Contact No" name="addSupplierContactNo" id="addSupplierContactNo" required />\n          </div>\n\n          <div class="form-group">\n            <label for="addSupplierPassword">Password</label>\n            <input type="password" class="form-control" placeholder="Contact No" name="addSupplierPassword" id="addSupplierPassword" required />\n          </div>\n\n          <div class="form-group">\n            <label for="addSupplierAddress">Address</label>\n            <input type="text" class="form-control" placeholder="Company Address" name="addSupplierAddress" id="addSupplierAddress" required />\n          </div>\n        </form>\n      '},function(a){var l=this;$(a).modal("show"),$(a).on("click","a[data-action='addsupplier']",function(e){$("#supplierAddSupplierForm").submit()}),$("#supplierAddSupplierForm").submit(function(e){e.preventDefault(),$.ajax("/api/employee/register.supplier.php",{method:"POST",data:new FormData(e.target),cache:!1,contentType:!1,processData:!1,dataType:"json"}).then(function(e){if(console.log(l),e.response)return $(a).modal("hide"),$("body").showAlert({type:"success",body:"Supplier added."});$(a).modal("hide"),$("body").showAlert({type:"warning",body:"Operation failed. Try again later"})}).catch(console.error)})})})});
/* jQuery(function() {
  $("#allsuppliers").DataTable({
          dom: 'Bfrtip',
      select: {
        style: "single"
      },
      buttons: [
        {
          extend: "print",
          text: 'Print &nbsp;<i class="fa fa-print"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Sales Report for" + moment().format("MMMM D YYYY")
        },
        {
          extend: "csv",
          text: 'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Sales Report for" + moment().format("MMMM D YYYY")
        },
        {
          text: "View Supplier",
          className: "btn btn-primary invisible"
        }
      ]
  })

    $("#allsuppliers").on("click", "tbody tr", function(e) {
    if($(e.currentTarget).hasClass("selected")) {
      return $("body").find(".dt-buttons").children(":last-child").addClass("invisible")
    }
    return $("body").find(".dt-buttons").children(":last-child").removeClass("invisible")
  })

  $("body").find(".dt-buttons").children(":last-child").on("click", function(e) {
    location.replace(`viewsupplier.php?supplierid=${$("#allsuppliers").find(".selected").children().first().text()}`)
  })

  //add supplier
  $("a[href='#supplierAddSupplier']").on("click", function(e) {
    $("#runwayModal").Modal({
      size: "md",
      title: "Add Supplier",
      buttons: [
        "<a href=\"#\" class=\"btn btn-outline-danger\" data-dismiss=\"modal\">Cancel</a>",
        "<a href=\"#\" class=\"btn btn-primary\" data-action=\"addsupplier\">Add Supplier</a>"
      ],
      body: `
        <form id="supplierAddSupplierForm">
          <div class="form-group">
            <label for="addSupplierCompanyName">Company Name</label>
            <input type="text" class="form-control" placeholder="Company Name" name="addSupplierCompanyName" id="addSupplierCompanyName" required />
            <small class="text-muted">(e.g) Bench</small>
          </div>

          <div class="form-group">
            <label for="addSupplierContactNo">Contact No.</label>
            <input type="number" class="form-control" placeholder="Contact No" name="addSupplierContactNo" id="addSupplierContactNo" required />
          </div>

          <div class="form-group">
            <label for="addSupplierPassword">Password</label>
            <input type="password" class="form-control" placeholder="Contact No" name="addSupplierPassword" id="addSupplierPassword" required />
          </div>

          <div class="form-group">
            <label for="addSupplierAddress">Address</label>
            <input type="text" class="form-control" placeholder="Company Address" name="addSupplierAddress" id="addSupplierAddress" required />
          </div>
        </form>
      `
    }, function(modal) {
      $(modal).modal("show")

      $(modal).on("click", "a[data-action='addsupplier']", function(e) {
        $("#supplierAddSupplierForm").submit()
      })

      $("#supplierAddSupplierForm").submit(e => {
        e.preventDefault()
        $.ajax("/api/employee/register.supplier.php", {
          method: "POST",
          data: new FormData(e.target),
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json"
        })
        .then(json => {
          console.log(this)
          if(json.response) {
            $(modal).modal("hide")
            return $("body").showAlert({
              type: "success",
              body: "Supplier added."
            })
          }
          $(modal).modal("hide")
          $("body").showAlert({
            type: "warning",
            body: "Operation failed. Try again later"
          })
        })
        .catch(console.error)
      })
    })
  })

}) */

</script>

</html>