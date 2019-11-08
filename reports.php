<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}
$conn = require "php/connection.php";
$sales = $conn->query("
  SELECT *
  FROM orders
  INNER JOIN orderdetails
    ON orders.OrderId = orderdetails.OrderId
  LEFT JOIN returns
    ON orderdetails.OrderId = returns.OrderId AND orderdetails.ProductId = returns.ProductId AND returns.ReturnDate BETWEEN NOW() - INTERVAL 30 DAY AND NOW() 
  INNER JOIN productcategory
    ON orderdetails.ProductId = productcategory.ProductId
  WHERE (orders.OrderDate BETWEEN NOW() - INTERVAL 30 DAY AND NOW())
")->fetch_all(MYSQLI_ASSOC);

$supply = $conn->query("
  SELECT
    purchaseorder.PurchaseOrderId,
    purchasedetails.ProductId,
    productcategory.PName,
    purchasedetails.POQuantity as OrderQuantity,
    purchaseorder.SupplierId,
    purchaseorder.PODate as OrderDate,
    purchaseorder.PODeliveryAddress as Address,
    purchaseorder.POStatus as Status
  FROM purchasedetails
  INNER JOIN purchaseorder on purchasedetails.PurchaseOrderId = purchaseorder.PurchaseOrderId
  INNER JOIN productcategory on purchasedetails.ProductId = productcategory.ProductId
")->fetch_all(MYSQLI_ASSOC);

$returns = $conn->query("
  SELECT 
	  returns.OrderId,
    returns.ProductId,
    returns.ItemCount,
    returns.ReturnDate,
    returns.Reason,
    orders.CustomerId,
    customer.CFirstname,
    customer.CLastname
  FROM returns
  INNER JOIN orders ON returns.OrderId = orders.OrderId
  INNER JOIN customer ON orders.CustomerId = customer.CustomerId
  WHERE returns.ReturnDate BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
")->fetch_all(MYSQLI_ASSOC);

$inventory = $conn->query("
  SELECT *
  FROM product
  INNER JOIN productcategory ON product.ProductId = productcategory.ProductId
")->fetch_all(MYSQLI_ASSOC);


if ($conn->error) {
  var_dump($conn->error);
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
        <h1>Reports</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white smaller border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Reports</li>
        </ol>

        <!-- Page Content -->
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-body">
                <ul class="nav nav-pills pull-right"  id="myTab" role="tablist">
                  <li class="nav-item">
                  <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#sales-content" role="tab" aria-controls="sales" aria-selected="true">Sales</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="supply-tab" data-toggle="tab" href="#supply-content" role="tab" aria-controls="supply" aria-selected="false">Supply</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="returns-tab" data-toggle="tab" href="#returns-content" role="tab" aria-controls="returns" aria-selected="false">Return</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory-content" role="tab" aria-controls="inventory" aria-selected="false">Inventory</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="sales-content" role="tabpanel">
                    <canvas class="mb-5" id="salesovertime" width="100%" height="40px"></canvas>
                    <div class="table-responsive">
                      <table class="table table-borderless" id="salesovertimetable">
                        <thead>
                          <tr>
                            <td>Date</td>
                            <td>Orders</td>
                            <td>Gross Sales</td>
                            <td>Discounts</td>
                            <td>Returns</td>
                            <td>Net Sales</td>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="supply-content" role="tabpanel">
                    <div class="table-responsive mt-3">
                      <table class="table table-borderless" id="supplyreporttable" width="100%">
                        <thead>
                          <tr>
                            <td>Supply Id</td>
                            <td>Supplier Id</td>
                            <td>Product Name</td>
                            <td>Supply Quantity</td>
                            <td>Supply Date</td>
                            <td>Supply Status</td>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="returns-content" role="tabpanel">
                    <div class="table-responsive mt-3">
                      <table class="table table-borderless" id="returnreporttable" width="100%">
                        <thead>
                          <tr>
                            <td>Order Id</td>
                            <td>Customer Name</td>
                            <td>Product Id</td>
                            <td>Return Quantity</td>
                            <td>Return Date</td>
                            <td>Reason</td>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="inventory-content" role="tabpanel">
                    <div class="table-responsive mt-3">
                      <table class="table table-borderless" id="inventoryreporttable" width="100%">
                        <thead>
                          <tr>
                            <td>Product Id</td>
                            <td>Brand</td>
                            <td>Name</td>
                            <td>Sizes</td>
                            <td>Colors</td>
                            <td>Quantity</td>
                            <td>Price</td>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                  </div>
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
  <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/plugins/modal.js"></script>
  <script src="js/sb-admin.min.js"></script>

</body>
<script>
var sales = <?php echo json_encode($sales) ?>;
var supplies = <?php echo json_encode($supply) ?>;
var returnitems = <?php echo json_encode($returns) ?>;
var inventory = <?php echo json_encode($inventory) ?>;
"use strict";var salesovertimereportchart=function(t,e,a,r){var n=sales.filter(function(t){return a(t.OrderDate).format("L")<=a().format("L")&&a(t.OrderDate).format("L")>=a().subtract(30,"days").format("L")}),o=[],s=[],i=a().format("L");do{o.push(a(i).format("MMM Do"));var u=0;n.forEach(function(t){a(i).format("L")==a(t.OrderDate).format("L")&&(u=(Number(u)+Number(t.Amount)).toFixed(2))}),s.push(u),i=a(i).subtract(1,"days").format("L")}while(i>a().subtract(30,"days").format("L"));return new e(document.querySelector("#salesovertime").getContext("2d"),{type:"bar",data:{labels:o,datasets:[{label:"Daily Gross Sales",data:s,backgroundColor:"rgba(31, 72, 126, 1)",borderColor:"rgba(31, 72, 126, 1)",borderWidth:1}]},options:{scales:{yAxes:[{ticks:{beginAtZero:!0}}]}}})}(jQuery,Chart,moment),salesovertimereporttable=function(t,e,a,r){var n=sales.filter(function(t){return a(t.OrderDate).format("L")<=a().format("L")&&a(t.OrderDate).format("L")>=a().subtract(30,"days").format("L")}),o=[],s=a().format("L");do{var i=average=gross=discount=returns=net=0;n.forEach(function(t){a(s).format("L")==a(t.OrderDate).format("L")&&(i++,gross=(Number(gross)+Number(t.Amount)).toFixed(2),returns+=Number(t.ItemCount)*t.PPrice)}),o.push({currentDate:a(s).format("l"),ordercount:i,gross:gross,discount:discount,returns:"".concat(0<returns?"-₱":"").concat(returns),net:(gross-(discount+returns)).toFixed(2)}),s=a(s).subtract(1,"days").format("L")}while(s>a().subtract(30,"days").format("L"));return o.sort(function(t,e){return new Date(t.currentDate).getTime()-new Date(e.currentDate).getTime()}),t("#salesovertimetable").DataTable({dom:"Bfrtip",data:o,lengthMenu:[[-1],["All"]],order:[[0,"DESC"]],buttons:[{extend:"print",text:'Print &nbsp;<i class="fa fa-print"></i>',className:"btn btn-outline-primary",title:"Runway Direct Sales Report for "+a().format("MMMM D YYYY")},{extend:"csv",text:'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',className:"btn btn-outline-primary",title:"Runway Direct Sales Report for "+a().format("MMMM D YYYY")}],columns:[{data:"currentDate"},{data:"ordercount"},{data:"gross"},{data:"discount"},{data:"returns"},{data:"net"}]})}(jQuery,Chart,moment),supplyreporttable=function(t,e,a){return t("#supplyreporttable").DataTable({dom:"Bfrtip",order: [[4, "DESC"]],lengthMenu:[[-1],["All"]],data:a,buttons:[{extend:"print",text:'Print &nbsp;<i class="fa fa-print"></i>',className:"btn btn-outline-primary",title:"Runway Direct Supply Report for "+e().format("MMMM D YYYY")},{extend:"csv",text:'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',className:"btn btn-outline-primary",title:"Runway Direct Supply Report for "+e().format("MMMM D YYYY")}],columns:[{data:"PurchaseOrderId"},{data:"SupplierId"},{data:"PName"},{data:"OrderQuantity"},{data:"OrderDate"},{data:"Status"}]})}(jQuery,moment,supplies),returnreporttable=function(t,e,a){var r=[];return a.forEach(function(t){r.push({OrderId:t.OrderId,CustomerName:"".concat(t.CFirstname," ").concat(t.CLastname),ProductId:t.ProductId,Quantity:t.ItemCount,ReturnDate:e(t.ReturnDate).format("MMM D YYYY"),Reason:t.Reason})}),t("#returnreporttable").DataTable({dom:"Bfrtip",order:[4, "DESC"],lengthMenu:[[-1],["All"]],data:r,buttons:[{extend:"print",text:'Print &nbsp;<i class="fa fa-print"></i>',className:"btn btn-outline-primary",title:"Runway Direct Supply Report for "+e().format("MMMM D YYYY")},{extend:"csv",text:'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',className:"btn btn-outline-primary",title:"Runway Direct Supply Report for "+e().format("MMMM D YYYY")}],columns:[{data:"OrderId"},{data:"CustomerName"},{data:"ProductId"},{data:"Quantity"},{data:"ReturnDate"},{data:"Reason"}]})}(jQuery,moment,returnitems),inventoryreporttable=function(t,e,a){var r=[];return a.forEach(function(t){r.push({pid:t.ProductId,name:t.PName,brand:t.PBrand,sizes:t.PSizes?t.PSizes:"N/A",colors:t.PColors?t.PColors:"N/A",quantity:0<t.PQuantity?t.PQuantity:"Out of stocked",price:t.PPrice})}),t("#inventoryreporttable").DataTable({dom:"Bfrtip",lengthMenu:[[-1],["All"]],data:r,buttons:[{extend:"print",text:'Print &nbsp;<i class="fa fa-print"></i>',className:"btn btn-outline-primary",title:"Runway Direct Inventory Report for "+e().format("MMMM D YYYY")},{extend:"csv",text:'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',className:"btn btn-outline-primary",title:"Runway Direct Inventory Report for "+e().format("MMMM D YYYY")}],columns:[{data:"pid"},{data:"brand"},{data:"name"},{data:"sizes"},{data:"colors"},{data:"quantity"},{data:"price"}]})}(jQuery,moment,inventory);
/*
//sales overtime chart
var salesovertimereportchart = (function($, Chart,moment, sales){
  var saleslast30days = sales.filter(sale => moment(sale.OrderDate).format("L") <= moment().format("L") && moment(sale.OrderDate).format("L") >= moment().subtract(30, "days").format("L"))

  var salesovertimelabels = []
  var salesovertimedata = []


  let currentDate = moment().format("L")

  do {
    salesovertimelabels.push(moment(currentDate).format("MMM Do"))
    var average = 0;
    saleslast30days.forEach(sale => {
      if(moment(currentDate).format("L") == moment(sale.OrderDate).format("L")) {
        average = (Number(average) + Number(sale.Amount)).toFixed(2)
      }
    })
    salesovertimedata.push(average)
    currentDate = moment(currentDate).subtract(1, "days").format("L")
  } while (currentDate  > moment().subtract(30, "days").format("L")) 


    var salesovertime = document.querySelector("#salesovertime").getContext("2d")
    return new Chart(salesovertime, {
        type: 'bar',
        data: {
            labels: salesovertimelabels,
            datasets: [{
                label: 'Daily Gross Sales',
                data: salesovertimedata,
                backgroundColor: "rgba(31, 72, 126, 1)",
                borderColor: "rgba(31, 72, 126, 1)",
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
})(jQuery, Chart, moment, sales)
//sales overtime table
var salesovertimereporttable = (function($, Chart, moment, sales){
  var filteredsales = sales.filter(sale => moment(sale.OrderDate).format("L") <= moment().format("L") && moment(sale.OrderDate).format("L") >= moment().subtract(30, "days").format("L"))
  var datatable = []
  let currentDate = moment().format("L")
  do {
    var ordercount = average = gross = discount = returns = net = 0;

    filteredsales.forEach(sale => {
      if(moment(currentDate).format("L") == moment(sale.OrderDate).format("L")) {
        ordercount++;
        gross = (Number(gross) + Number(sale.Amount)).toFixed(2)
        returns = returns + (Number(sale.ItemCount) * sale.PPrice)
      }
    })
    datatable.push({currentDate: moment(currentDate).format("l"), ordercount, gross, discount, returns: `${returns > 0 ? "-₱": ""}${returns}`, net: (gross - (discount + returns)).toFixed(2)})
    currentDate = moment(currentDate).subtract(1, "days").format("L")
  } while (currentDate  > moment().subtract(30, "days").format("L")) 
  datatable.sort((a, b) => {
    return new Date(a.currentDate).getTime() - new Date(b.currentDate).getTime()
  })
  return $("#salesovertimetable").DataTable({
    dom: 'Bfrtip',
    data: datatable,
    lengthMenu: [[-1], ["All"]],
    order: [[0, "DESC"]],
    buttons: [
       {
          extend: "print",
          text: 'Print &nbsp;<i class="fa fa-print"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Sales Report for " + moment().format("MMMM D YYYY")
        },
        {
          extend: "csv",
          text: 'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Sales Report for " + moment().format("MMMM D YYYY")
        }
    ],
    columns: [
      {data: "currentDate"},
      {data: "ordercount"},
      {data: "gross"},
      {data: "discount"},
      {data: "returns"},
      {data: "net"}
    ]
  })
})(jQuery, Chart, moment, sales)

//supply table
var supplyreporttable = (function($, moment, supplies){
  return $("#supplyreporttable").DataTable({
    dom: 'Bfrtip',
    lengthMenu: [[-1], ["All"]],
    data: supplies,
    buttons: [
       {
          extend: "print",
          text: 'Print &nbsp;<i class="fa fa-print"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Supply Report for " + moment().format("MMMM D YYYY")
        },
        {
          extend: "csv",
          text: 'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Supply Report for " + moment().format("MMMM D YYYY")
        }
    ],
    columns: [
      {data: "PurchaseOrderId"},
      {data: "SupplierId"},
      {data: "PName"},
      {data: "OrderQuantity"},
      {data: "OrderDate"},
      {data: "Status"}
    ]
  })
})(jQuery, moment, supplies)


//return table
var returnreporttable = (function($, moment, returnitems){
  var returned = []
  returnitems.forEach(item => {
    returned.push({
      OrderId: item.OrderId,
      CustomerName: `${item.CFirstname} ${item.CLastname}`,
      ProductId: item.ProductId,
      Quantity: item.ItemCount,
      ReturnDate: moment(item.ReturnDate).calendar(),
      Reason: item.Reason
    })
  })

  return $("#returnreporttable").DataTable({
    dom: 'Bfrtip',
    lengthMenu: [[-1], ["All"]],
    data: returned,
    buttons: [
       {
          extend: "print",
          text: 'Print &nbsp;<i class="fa fa-print"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Supply Report for " + moment().format("MMMM D YYYY")
        },
        {
          extend: "csv",
          text: 'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',
          className: "btn btn-outline-primary",
          title: "Runway Direct Supply Report for " + moment().format("MMMM D YYYY")
        }
    ],
    columns: [
      {data: "OrderId"},
      {data: "CustomerName"},
      {data: "ProductId"},
      {data: "Quantity"},
      {data: "ReturnDate"},
      {data: "Reason"}
    ]
  })
})(jQuery, moment, returnitems)

//inventory table
var inventoryreporttable = (function($, moment, inventory){
  var inv = []
  inventory.forEach(item => {
    inv.push({
      pid: item.ProductId,
      name: item.PName,
      brand: item.PBrand,
      sizes: item.PSizes ? item.PSizes : "N/A",
      colors: item.PColors ? item.PColors : "N/A",
      quantity: item.PQuantity > 0 ? item.PQuantity : "Out of stocked",
      price: item.PPrice
    })
  })

    return $("#inventoryreporttable").DataTable({
      dom: 'Bfrtip',
      lengthMenu: [[-1], ["All"]],
      data: inv,
      buttons: [
        {
            extend: "print",
            text: 'Print &nbsp;<i class="fa fa-print"></i>',
            className: "btn btn-outline-primary",
            title: "Runway Direct Inventory Report for " + moment().format("MMMM D YYYY")
          },
          {
            extend: "csv",
            text: 'Save as Excel &nbsp;<i class="fa fa-file-excel"></i>',
            className: "btn btn-outline-primary",
            title: "Runway Direct Inventory Report for " + moment().format("MMMM D YYYY")
          }
      ],
      columns: [
        {data: "pid"},
        {data: "brand"},
        {data: "name"},
        {data: "sizes"},
        {data: "colors"},
        {data: "quantity"},
        {data: "price"}
      ]
    })
})(jQuery, moment, inventory)
*/
</script>

</html>