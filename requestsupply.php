<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}
$conn = require "php/connection.php";
$supplier = null;
if (isset($_GET["supplierid"])) {
  $supplier = $conn->query("
    SELECT *
    FROM supplier
    WHERE SupplierId = $_GET[supplierid]
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
        <h1>Request Supply</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="products.php">Products</a>
          </li>
          <li class="breadcrumb-item active">Request Supply</li>
        </ol>

        <!-- Page Content -->
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-8">
            <div class="card mb-3">
              <div class="card-body">
                   <div class="d-flex justify-content-between align-items-center mb-3 text-muted">
                    <h5 class="h5 text-primary mb-0 font-weight-bold">Products</h6>
                    <a href="#" class="text-uppercase small text-primary" id="requestSupplyCancelRequest">Cancel Order</a>
                  </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Search Product" aria-label="Search Product" aria-describedby="requestSupplyBrowseProduct">
                  <div class="input-group-append">
                    <a href="#requestSupplyBrowseProduct" id="requestSupplyBrowseProduct" class="btn btn-outline-primary">Browse product</a>
                  </div>
                </div>
                <div id="requestSupplyProducts" class="d-block">
                </div>
                <div class="form-group mt-5 mb-3">
                  <label for="address">Delivery Address</label>
                  <input type="text" class="form-control" placeholder="Delivery Address" required name="address" id="address">
                </div>
                <button class="btn btn-primary" id="requestSupplySendRequest">Send Request</button>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="card-title font-weight-bold text-primary mb-0">Supplier</h5>
                  <a href="#" class="text-primary text-uppercase small" onclick="removeSupplier()">Remove supplier</a>
                </div>
                <div id="requestSupplySupplierInfo">
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
var state = {
  product: {},
  supplier: JSON.parse(JSON.stringify(<?php echo $supplier ? json_encode($supplier) : "{}" ?>)) || {},
  products: [],
  suppliers: []
}

"use strict";var search=new URLSearchParams(location.search);function noSupplier(){return'<h4 class="fa fa-user d-block"></h4><small class="text-muted d-block">No supplier selected</small><a href="#requestSupplyBrowseSupplier" data-modal="#requestSupplyBrowseSupplier" class="btn btn-primary">Browse Supplier</a>'}function ListGroupTemplate(e){return'<div class="list-group" id="'.concat(e.id,'" role="tablist" style="max-height: ').concat(e.maxheight?e.maxheight:"auto","; overflow-y: ").concat(e.maxheight?"auto":"initial !important",';"></div>')}function productTemplate(e){return'<div class="d-flex align-items-center mb-3"><h5 class="text-primary">'+e.PName+'</h5><input type="number" value="'+e.requestQuantity+'" min="1" max="100" class="requestProductQuantity form-control ml-auto mr-3" placeholder="Supply Quantity" style="max-width: 100px !important"/> <span class="close" data-id="'+e.ProductId+'" id="removeRequestedProduct">&times;</span></div>'}function SupplierItem(e){return'<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-4" data-toggle="list"role="tab"href="#list-supplier" data-supplier=\''+JSON.stringify(e)+'\'> <p class="m-0">'+e.SCompanyName+'</p><div class=\text-uppercase small">'+e.SupplierId+"</div></a>"}function removeProduct(){$("#requestSupplySelectedProducts").html(noProduct()).addClass("text-center"),state.product={}}function removeSupplier(){$("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center"),state.supplier={}}search.has("supplierid")&&$.getJSON("/api/getsuppliers.php?supplierid="+search.get("supplierid")).then(function(e){state.supplier=e,$("#requestSupplySupplierInfo").html('<p class="mb-1">'+e.SCompanyName+'</p><p class="mb-1">'+e.SContactNo+'</p><p class="mb-1">'+e.SAddress+"</p>").removeClass("text-center")}),search.has("productid")&&$.getJSON("/api/getproducts.php?productid="+search.get("productid")).then(function(e){if($.isEmptyObject(e))return $("body").showAlert({type:"warning",body:"The product you're trying to search is not found."});e.requestQuantity=1,$("#requestSupplyProducts").append(productTemplate(e)),e.isInitialize=!0,state.product[e.ProductId]=e}),$.getJSON("/api/getproducts.php").then(function(e){state.products=e}).catch(function(e){$("body").showAlert({type:"danger",body:"Error occured. Please reload your browser for better experience"})}),$.getJSON("/api/getsuppliers.php").then(function(e){state.suppliers=e}).catch(function(e){$("body").showAlert({type:"danger",body:"Error occured. Please reload your browser for better experience"})}),jQuery(function(){$.isEmptyObject(state.supplier)&&$("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center"),$("body").on("click","*[data-modal='#requestSupplyBrowseSupplier']",function(e){$("#runwayModal").Modal({size:"lg",title:"Select Supplier",buttons:['<button class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>','<button class="btn btn-primary" data-action="#requestSupplySelectSupplier">Select</button>'],body:' <input type="text" class="form-control mb-4" id="requestSupplySearchSupplier" placeholder="Search product"/>'+ListGroupTemplate({id:"requestSupplySelectSupplier",maxheight:"60vh"})},function(r){state.suppliers.forEach(function(e){$("#requestSupplySelectSupplier").append(SupplierItem(e))}),$(r).modal("show"),$(r).on("keyup","#requestsupplysearchsupplier",function(t){$("#requestSupplySelectSupplier").html(""),state.suppliers.filter(function(e){if(e.SCompanyName.includes($(t.target).val())||e.SCompanyName.toLowerCase().includes($(t.target).val())||e.SAddress.toLowerCase().includes($(t.target).val())||e.SAddress.includes($(t.target).val()))return!0}).forEach(function(e){$("#requestSupplySelectSupplier").append(SupplierItem(e))})}),$(r).on("click","*[data-action='#requestSupplySelectSupplier']",function(e){var t=$(r).find(".active").data("supplier");t&&(state.supplier=t,$("#requestSupplySupplierInfo").html('<p class="mb-1">'+t.SCompanyName+'</p><p class="mb-1">'+t.SContactNo+'</p><p class="mb-1">'+t.SAddress+"</p>").removeClass("text-center"),$(r).modal("hide"))})})}),$("body").on("click","#requestSupplyBrowseProduct, *[aria-describedby='requestSupplyBrowseProduct']",function(e){$("#runwayModal").Modal({size:"lg",title:"Select Product",buttons:['<button class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>','<button class="btn btn-primary" data-action="#requestSupplySelectProduct">Select</button>'],body:'\n          <input type="text" class="form-control mb-4" id="requestSupplySearchProduct" placeholder="Search product"/>\n          '.concat(ListGroupTemplate({id:"requesSupplyModalSelectProduct",maxheight:"60vh"}))},function(r){function a(e){return'\n          <a\n          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-4"\n          data-toggle="list"\n          role="tab"\n          href="#list-product"\n          data-product=\''.concat(JSON.stringify(e),'\'\n          >\n          <p class="m-0">').concat(e.PName,'</p>\n          <div class="text-uppercase small">').concat(e.PQuantity,' in Stock <span class="ml-5">').concat(e.PPrice," PHP</span></div>\n          </a>")}state.products.forEach(function(e){$("#requesSupplyModalSelectProduct").append(0<e.PQuantity?a(e):"")}),$(r).modal("show"),$(r).on("keyup","#requestSupplySearchProduct",function(t){$("#requesSupplyModalSelectProduct").html(""),state.products.filter(function(e){if(e.PName.toLowerCase().includes($(t.currentTarget).val())||e.PBrand.toLowerCase().includes($(t.currentTarget).val()))return!0}).forEach(function(e){$("#requesSupplyModalSelectProduct").append(0<e.PQuantity?a(e):"")})}),$(r).on("click",'*[data-action="#requestSupplySelectProduct"]',function(e){var t=$(r).find(".active").data("product");t&&(t.isInitialize=!1,t.requestQuantity=1,state.product[t.ProductId]=Object.assign({},t,state.product[t.ProductId]),$(r).modal("hide"))}),$(r).on("hide.bs.modal",function(e){Object.keys(state.product).forEach(function(e){var t=state.product[e];t.isInitialize||($("#requestSupplyProducts").append(productTemplate(t)),t.isInitialize=!0)})})})}),$("#requestSupplyCancelRequest").on("click",function(e){state.supplier={},state.product={},$("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center"),$("#requestSupplyProducts").html("")}),$("body").on("click","#removeRequestedProduct",function(e){delete state.product[$(e.currentTarget).data("id")],$(e.currentTarget).parent().remove()}),$("body").on("change",".requestProductQuantity",function(e){var t=$(e.currentTarget).siblings().last().data("id");state.product[t].requestQuantity=$(e.currentTarget).val()}),$("#requestSupplySendRequest").click(function(e){if($.isEmptyObject(state.product))return $("#requestSupplyBrowseProduct").focus();if($.isEmptyObject(state.supplier))return $("a[data-modal='#requestSupplyBrowseSupplier']").focus();if($.isEmptyObject(state.supplier))return $("a[data-modal='#requestSupplyBrowseSupplier']").focus();if(!$("#address").val())return $("#address").focus();e.preventDefault();var t=new FormData;t.append("orders",JSON.stringify(state.product)),t.append("supplierid",state.supplier.SupplierId),t.append("address",$("input[name='address']").val()),$.ajax("/api/requestsupply.php",{method:"POST",data:t,cache:!1,contentType:!1,processData:!1}).then(function(e){var t=JSON.parse(e);return t.response?(state.supplier={},state.product={},$("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center"),$("#requestSupplyProducts").html(""),$("body").showAlert({type:"success",body:"Request sent."})):t.error?$("body").showAlert({type:"danger",body:"Something happened on our side. Please reload your browser to better experience"}):t.response?void 0:$("body").showAlert({type:"warning",body:"Operation failed. Try again later"})}).catch(function(e){return $("body").showAlert({type:"danger",body:"Something happened on our side. Please reload your browser to better experience"})})})});

/* var search = new URLSearchParams(location.search)

if(search.has("supplierid")) {
  $.getJSON("/api/getsuppliers.php?supplierid=" + search.get("supplierid"))
  .then(supplier => {
    state.supplier = supplier
    $("#requestSupplySupplierInfo").html('<p class="mb-1">' + supplier.SCompanyName + '</p><p class="mb-1">'+ supplier.SContactNo + '</p><p class="mb-1">' + supplier.SAddress + '</p>').removeClass("text-center")
  })
}

if(search.has("productid")) {
  $.getJSON("/api/getproducts.php?productid=" + search.get("productid"))
  .then(product => {
    if($.isEmptyObject(product)) return $("body").showAlert({type: "warning", body: "The product you're trying to search is not found."})
    product.requestQuantity = 1
    $("#requestSupplyProducts").append(productTemplate(product))
    product.isInitialize = true;
    state.product[product.ProductId] = product
  })
}

$.getJSON("/api/getproducts.php")
.then(function(products) {
  state.products = products
})
.catch(function(err) {
  $("body").showAlert({
    type: "danger",
    body: "Error occured. Please reload your browser for better experience"
  })
})


$.getJSON("/api/getsuppliers.php")
.then(function(suppliers) {
  state.suppliers = suppliers
})
.catch(function(err) {
  $("body").showAlert({
    type: "danger",
    body: "Error occured. Please reload your browser for better experience"
  })
})

function noSupplier() {
   return "<h4 class=\"fa fa-user d-block\"></h4>" +
          "<small class=\"text-muted d-block\">No supplier selected</small>" +
          "<a href=\"#requestSupplyBrowseSupplier\" "+
          "data-modal=\"#requestSupplyBrowseSupplier\" "+
          "class=\"btn btn-primary\">Browse Supplier</a>"
}



 function ListGroupTemplate(props) {
    return `<div class="list-group" id="${props.id}" role="tablist" style="max-height: ${props.maxheight ? props.maxheight : "auto"}; overflow-y: ${props.maxheight ? "auto" : "initial !important"};"></div>`
  }

  function productTemplate(props) {
     return "<div class=\"d-flex align-items-center mb-3\"><h5 class=\"text-primary\">"+ props.PName +"</h5>" +
            "<input type=\"number\" value=\""+ props.requestQuantity +"\" min=\"1\" max=\"100\" class=\"requestProductQuantity form-control ml-auto mr-3\" placeholder=\"Supply Quantity\" style=\"max-width: 100px !important\"/> " + 
            "<span class=\"close\" data-id=\""+ props.ProductId +"\" id=\"removeRequestedProduct\">&times;</span></div>"
  }

    function SupplierItem(props) {
              return "<a class=\"list-group-item list-group-item-action d-flex justify-content-between align-items-center py-4\" " +
                    "data-toggle=\"list\"role=\"tab\"href=\"#list-supplier\" data-supplier='" + JSON.stringify(props) + "'> " +
                    "<p class=\"m-0\">" + props.SCompanyName + "</p><div class=\text-uppercase small\">" + props.SupplierId + "</div></a>"
            }

  function removeProduct() {
    $("#requestSupplySelectedProducts").html(noProduct()).addClass("text-center")
    state.product = {}
  }

  function removeSupplier() {
    $("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center")
    state.supplier = {}
  }

jQuery(function() {
  if($.isEmptyObject(state.supplier)) $("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center")

    //select supplier
     $("body").on("click", "*[data-modal='#requestSupplyBrowseSupplier']", function (e) {
      $("#runwayModal")
        .Modal({
          size: "lg",
          title: "Select Supplier",
          buttons: [
            '<button class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>',
            '<button class="btn btn-primary" data-action="#requestSupplySelectSupplier">Select</button>'
          ],
          body: " <input type=\"text\" class=\"form-control mb-4\" id=\"requestSupplySearchSupplier\" placeholder=\"Search product\"/>" + 
          ListGroupTemplate({
              id: "requestSupplySelectSupplier",
              maxheight: "60vh"
            })
        },
          function (modal) {
            state.suppliers.forEach(function (supplier) {
              $("#requestSupplySelectSupplier").append(SupplierItem(supplier))
            })
            $(modal).modal("show")

            $(modal).on("keyup", "#requestsupplysearchsupplier", function (e) {
              $("#requestSupplySelectSupplier").html("")
              var filteredSupplier = state.suppliers.filter(function (supplier) {
                if (
                  supplier.SCompanyName.includes($(e.target).val()) ||
                  supplier.SCompanyName.toLowerCase().includes($(e.target).val()) ||
                  supplier.SAddress.toLowerCase().includes($(e.target).val()) ||
                  supplier.SAddress.includes($(e.target).val())) {
                  return true
                }
              })

              filteredSupplier.forEach(function (supplier) {
                $("#requestSupplySelectSupplier").append(SupplierItem(supplier))
              })
            })
            $(modal).on("click", "*[data-action='#requestSupplySelectSupplier']", function (e) {
              var selected = $(modal).find(".active").data("supplier")
              if(!selected) return
              state.supplier = selected

              $("#requestSupplySupplierInfo").html('<p class="mb-1">' + selected.SCompanyName + '</p><p class="mb-1">'+ selected.SContactNo + '</p><p class="mb-1">' + selected.SAddress + '</p>').removeClass("text-center")
              $(modal).modal("hide")
            })
          })
    }) 

   $("body").on("click", "#requestSupplyBrowseProduct, *[aria-describedby='requestSupplyBrowseProduct']", function(e) {
        $("#runwayModal")
        .Modal({
          size: "lg",
          title: "Select Product",
          buttons: [
            "<button class=\"btn btn-outline-danger\" data-dismiss=\"modal\">Cancel</button>",
            "<button class=\"btn btn-primary\" data-action=\"#requestSupplySelectProduct\">Select</button>"
          ],
          body: `
          <input type="text" class="form-control mb-4" id="requestSupplySearchProduct" placeholder="Search product"/>
          ${ListGroupTemplate({
              id: "requesSupplyModalSelectProduct",
              maxheight: "60vh"
            })}`
        },
          function (modal) {
            function ProductItem(props) {
              return `
          <a
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-4"
          data-toggle="list"
          role="tab"
          href="#list-product"
          data-product='${JSON.stringify(props)}'
          >
          <p class="m-0">${props.PName}</p>
          <div class="text-uppercase small">${props.PQuantity} in Stock <span class="ml-5">${props.PPrice} PHP</span></div>
          </a>`
            }

            state.products.forEach(function (product) {
              $("#requesSupplyModalSelectProduct").append(product.PQuantity > 0 ? ProductItem(product) : "")
            })
            $(modal).modal("show")

            $(modal).on("keyup", "#requestSupplySearchProduct", function (e) {
              $("#requesSupplyModalSelectProduct").html("")
              var filteredProduct = state.products.filter(function (product) {
                if (product.PName.toLowerCase().includes($(e.currentTarget).val()) || product.PBrand.toLowerCase().includes($(e.currentTarget).val())) {
                  return true
                }
              })

              filteredProduct.forEach(function (product) {
                $("#requesSupplyModalSelectProduct").append(product.PQuantity > 0 ? ProductItem(product) : "")
              })
            })
            $(modal).on("click", "*[data-action=\"#requestSupplySelectProduct\"]", function (e) {
              var selected = $(modal).find(".active").data("product")
              if(!selected) return
              selected.isInitialize = false
              selected.requestQuantity = 1
              state.product[selected.ProductId] = Object.assign({}, selected, state.product[selected.ProductId])
              $(modal).modal("hide")
              //orderproducts
            })

            $(modal).on("hide.bs.modal", function (e) {
              Object.keys(state.product).forEach(function (key) {
                var product = state.product[key]
                if (!product.isInitialize) {
                  $("#requestSupplyProducts").append(productTemplate(product))
                  product.isInitialize = true
                }
                return
              })
            })
          })
    })


    //cancel order
    $("#requestSupplyCancelRequest").on("click", function (e) {
      state.supplier = {}
      state.product = {}
      $("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center")
      $("#requestSupplyProducts").html("")
    })

    //remove items from orders
    $("body").on("click", "#removeRequestedProduct", function (e) {
      delete state.product[$(e.currentTarget).data("id")]
      $(e.currentTarget).parent().remove()
    })

    //add order quantity
    $("body").on("change", ".requestProductQuantity", function (e) {
      var productid = $(e.currentTarget).siblings().last().data("id")
      state.product[productid].requestQuantity = $(e.currentTarget).val()
    })

    //send request
    $("#requestSupplySendRequest").click(e => {
      if($.isEmptyObject(state.product)) return  $("#requestSupplyBrowseProduct").focus()
      if($.isEmptyObject(state.supplier)) return  $("a[data-modal='#requestSupplyBrowseSupplier']").focus()
      if($.isEmptyObject(state.supplier)) return  $("a[data-modal='#requestSupplyBrowseSupplier']").focus()
      if(!$("#address").val()) return $("#address").focus()
      e.preventDefault();
      var fd = new FormData();
      fd.append("orders", JSON.stringify(state.product))
      fd.append("supplierid", state.supplier.SupplierId)
      fd.append("address", $("input[name='address']").val())
      $.ajax("/api/requestsupply.php", {
        method: "POST",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
      })
      .then(res => {
        var json = JSON.parse(res)

        if(json.response) {
          state.supplier = {}
          state.product = {}
          $("#requestSupplySupplierInfo").html(noSupplier()).addClass("text-center")
          $("#requestSupplyProducts").html("")
          return $("body").showAlert({type: "success", body: "Request sent."})
        }
        if(json.error) return $("body").showAlert({type: "danger", body: "Something happened on our side. Please reload your browser to better experience"})
        if(!json.response) return $("body").showAlert({type: "warning", body: "Operation failed. Try again later"})
      })
      .catch(err => $("body").showAlert({type: "danger", body: "Something happened on our side. Please reload your browser to better experience"}))
    })
}) */

</script>

</html>