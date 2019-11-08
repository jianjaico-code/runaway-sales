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
          <span>Ryan Rafal</span> &nbsp;<i class="fas fa-user-circle fa-fw"></i>
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
      <li class="nav-item">
        <a class="nav-link" href="reports.php">
          <i class="fas fa-fw fa-file"></i>
          <span>Reports</span>
        </a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container">
        <h1>Add Order</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>

          <li class="breadcrumb-item">
            <a href="orders.php">Orders</a>
          </li>

          <li class="breadcrumb-item active">Add Order</li>
        </ol>

        <!-- Page Content -->
        <div class="row">
          <div class="col-md-12 col-lg-8 mb-3">

            <div class="card h-100 mb-3">
              <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                  <h5 class="h5 m-0">Order details</h5>
                  <a href="#" class="text-muted text-uppercase small addorder-cancel" data-modal="#cancelorder">Cancel
                    Order</a>
                </div>
                <button class="btn btn-primary" data-modal="#browseproduct"><i class="fa fa-search"></i>
                  Browse Product</button>

                <div id="orderproducts" class="my-3" style="min-height: 50px">
                  <!-- put some products here -->
                </div>

                <hr>
                <div id="ordersummary" class="d-flex justify-content-between align-items-center">
                  <h6 class="h6 text-uppercase font-weight-bold">Total:</h6>
                  <p><span>0.00</span>&nbsp;PHP</p>
                </div>
                 <div id="orderaction" class="d-flex justify-content-end">
              <button class="btn btn-outline-primary ml-2" data-modal="#markaspaid">Mark as paid</button>
              <button class="btn btn-primary ml-2" data-action="#markaspending">Mark as pending</button>
            </div>
              </div>
            </div>
           
          </div>
          <div class="col-md-12 col-lg-4">
            <div class="card mb-3" id="customercard">
              <div class="card-body">
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
  <!-- Custom scripts for all pages-->
  <script src="js/plugins/modal.js"></script>
  <script src="js/sb-admin.min.js"></script>
</body>

<script>

  "use strict";var selectedCustomer={},selectedProducts={},customerslist=[],productList=[];function NoUserSelectedTemplate(){return'<div class="d-flex align-items-center flex-column">\n                  <h4 class="text-center text-muted"><i class="fa fa-user"></i></h4>\n                  <span class="text-muted text-uppercase">No user selected</span>\n                  <button class="btn btn-primary" data-modal="#customerlist">Select Customer</button>\n            </div>'}function ListGroupTemplate(e){return'<div class="list-group" id="'.concat(e.id,'" role="tablist" style="max-height: ').concat(e.maxheight?e.maxheight:"auto","; overflow-y: ").concat(e.maxheight?"auto":"initial !important",';"></div>')}function NoProductSelectedTemplate(){return'<div id="noproductplaceholder" class="d-flex align-items-center flex-column">\n                  <h4 class="text-center text-muted"><i class="fa fa-tshirt"></i></h4>\n                  <span class="text-muted text-uppercase">No products selected</span>\n            </div>'}function capitalize(e){return e.charAt(0).toUpperCase()+e.slice(1)}function orderAction(e,t){$.ajax("/api/employee/addorder.php",{method:"POST",data:e}).then(function(e){t(null,e)}).catch(t)}$.getJSON("/api/getcustomers.php").then(function(e){customerslist=e}).catch(function(e){alert("Internal server error. Please reload your browser for better experience."),console.error(e)}),$.getJSON("/api/getproducts.php").then(function(e){productList=e}).catch(function(e){alert("Internal server error. Please reload your browser for better experience."),console.error(e)}),$(function(){$("#customercard").find(".card-body").html(NoUserSelectedTemplate()),$("#orderproducts").html(NoProductSelectedTemplate()),$("body").on("click","*[data-modal='#customerlist']",function(){$("#runwayModal").Modal({size:"lg",title:"Customers",buttons:['<button class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>','<button class="btn btn-primary" data-action="#selectcustomer">Select</button>'],body:'\n        <input type="text" class="form-control mb-4" placeholder="Search Customer" name="searchforcustomer" id="searchforcustomer" autofocus>\n        <div class="list-group" id="addOrderSelectCustomer" role="tablist" style="max-height: 60vh; overflow-y: auto;"></div>\n      '},function(e){function r(e){return'\n          <a\n          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-4"\n          data-toggle="list"\n          role="tab"\n          href="#list-profile"\n          data-customer=\''.concat(JSON.stringify(e),'\'\n\n          >\n          <p class="m-0">').concat(capitalize(e.firstname)," ").concat(capitalize(e.lastname),'</p>\n          <span class="text-uppercase text-muted small">').concat(e.customerid,"</span>\n          </a>")}customerslist.forEach(function(e){$("#addOrderSelectCustomer").append(r(e))}),$(e).modal("show"),$(e).find("input[name='searchforcustomer']").on("keyup",function(t){$("#addOrderSelectCustomer").html(""),customerslist.filter(function(e){if(e.firstname.includes($(t.currentTarget).val())||e.lastname.includes($(t.currentTarget).val()))return!0}).forEach(function(e){$("#addOrderSelectCustomer").append(r(e))})}),$(e).on("click","*[data-action='#selectcustomer']",function(){(selectedCustomer=$(e).find(".active").data("customer"))&&($("#customercard").removeClass("border-danger").find(".card-body").html('\n             <div class="card-title d-flex justify-content-between align-items-center">\n                <h6 class="h6 m-0">Customer</h6>\n                <a href="#clearcustomer" class="close text-primary">&times;</a>\n              </div>\n\n              <p class="text-uppercase font-weight-bold m-0">'.concat(selectedCustomer.firstname," ").concat(selectedCustomer.lastname,'</p>\n              <span class="small text-muted">+63').concat(selectedCustomer.contact,'</span>\n              <hr />\n              <p>Shipping Address</p>\n              <p style="font-size: .9rem">').concat(selectedCustomer.address,"</p>\n            ")),$(e).modal("hide"))})})}),$("body").on("click","a[href='#clearcustomer']",function(e){e.preventDefault(),selectedCustomer={},$("#customercard").find(".card-body").html(NoUserSelectedTemplate())}),$("body").on("click","*[data-modal='#browseproduct']",function(e){$("#runwayModal").Modal({size:"lg",title:"Select Product",buttons:['<button class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>','<button class="btn btn-primary" data-action="#selectproduct">Select</button>'],body:'\n          <input type="text" class="form-control mb-4" id="addOrderSearchProduct" placeholder="Search product"/>\n          '.concat(ListGroupTemplate({id:"modalSelectProduct",maxheight:"60vh"}))},function(r){function o(e){return'\n          <a\n          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-4"\n          data-toggle="list"\n          role="tab"\n          href="#list-product"\n          data-product=\''.concat(JSON.stringify(e),'\'\n          >\n          <p class="m-0">').concat(e.PName,'</p>\n          <div class="text-uppercase small">').concat(e.PQuantity,' in Stock <span class="ml-5">').concat(e.PPrice," PHP</span></div>\n          </a>")}productList.forEach(function(e){$("#modalSelectProduct").append(0<e.PQuantity?o(e):"")}),$(r).modal("show"),$(r).on("keyup","#addOrderSearchProduct",function(t){$("#modalSelectProduct").html(""),productList.filter(function(e){if(e.PName.includes($(t.currentTarget).val())||e.PBrand.includes($(t.currentTarget).val()))return!0}).forEach(function(e){$("#modalSelectProduct").append(0<e.PQuantity?o(e):"")})}),$(r).on("click","*[data-action='#selectproduct']",function(e){var t=$(r).find(".active").data("product");t.isInitialize=!1,t.orderQuantity=1,selectedProducts[t.ProductId]=Object.assign({},t,selectedProducts[t.ProductId]),$(r).modal("hide")}),$(r).on("hide.bs.modal",function(e){var r=0;Object.keys(selectedProducts).forEach(function(e){$("#noproductplaceholder").remove();var t=selectedProducts[e];t.isInitialize||($("#orderproducts").append('\n                  <div class="d-flex justify-content-between align-items-center mb-2">\n                    <div class="flex-grow-1"><h6 class="h6 text-uppercase ">'.concat(t.PName,'</h6></div>\n                    <div class="mr-2 product-price"><span>').concat(t.PPrice,'</span> <small>x</small></div>\n                    <div class="mr-5"><input required class="form-control addorderquantity" type="number" step="1" min="1" value="').concat(t.orderQuantity,'" max=').concat(t.PQuantity,' /></div>\n                    <div class="order-price"><span>').concat((t.PPrice*t.orderQuantity).toFixed(2),'</span> PHP</div>\n                    <span class="text-muted close ml-4 remove-order" title="Remove selected product" data-id="').concat(t.ProductId,'">&times;</span>\n                  </div>\n                ')),t.isInitialize=!0),r+=t.PPrice*t.orderQuantity}),$("#ordersummary").find("p span").text(r.toFixed(2))})})}),$(".addorder-cancel").on("click",function(e){selectedCustomer={},selectedProducts={},$("#customercard").find(".card-body").html(NoUserSelectedTemplate()),$("#orderproducts").html(NoProductSelectedTemplate()),$("#ordersummary").find("p span").text("0.00")}),$("body").on("click",".remove-order",function(e){delete selectedProducts[$(e.currentTarget).data("id")],$(e.currentTarget).parent().remove()}),$("body").on("change",".addorderquantity",function(e){var t=$(e.currentTarget).parent().siblings().last().data("id"),r=selectedProducts[t].PPrice;selectedProducts[t].orderQuantity=$(e.currentTarget).val(),$(e.currentTarget).parent().siblings(".order-price").text("".concat(($(e.currentTarget).val()*r).toFixed(2)," PHP"));var o=0;Object.keys(selectedProducts).forEach(function(e){o+=selectedProducts[e].PPrice*selectedProducts[e].orderQuantity}),$("#ordersummary").find("p span").text(o.toFixed(2))}),$("*[data-modal='#markaspaid']").on("click",function(e){return e.preventDefault(),$.isEmptyObject(selectedCustomer)?$("body").showAlert({type:"warning",body:"Select customer"}):$.isEmptyObject(selectedProducts)?$("body").showAlert({type:"warning",body:"No selected products"}):void $("#runwayModal").Modal({size:"md",title:"Warning",buttons:['<a href="#" data-dismiss="modal" class="btn btn-outline-danger">Cancel</a>','<a href="#" class="btn btn-primary" data-action="#markpaid">Confirm</a>'],body:"<p>Are you sure to mark this paid?</p><small>We cant undo once this operation is commited.</small>"},function(r){$(r).modal("show"),$(r).on("click","a[data-action='#markpaid']",function(){var t=0;Object.keys(selectedProducts).forEach(function(e){t+=selectedProducts[e].PPrice*selectedProducts[e].orderQuantity}),orderAction({CustomerId:selectedCustomer.customerid,TotalAmount:t.toFixed(2),orders:selectedProducts,orderStatus:"delivered"},function(e,t){return e?$("body").showAlert({type:"danger",body:"\n              <p class='m-0'>Something error happened. Try again later</p>\n              "}):(console.log(t),JSON.parse(t).response?(selectedCustomer={},selectedProducts={},$("#customercard").find(".card-body").html(NoUserSelectedTemplate()),$("#orderproducts").html(NoProductSelectedTemplate()),$("#ordersummary").find("p span").text("0.00"),$("body").showAlert({type:"success",body:"Order Success."}),$(r).modal("hide")):($(r).modal("hide"),void $("body").showAlert({type:"info",body:"Something happened on side. Please refresh the page for better experience."})))})})})}),$("*[data-action='#markaspending']").on("click",function(e){if(e.preventDefault(),$.isEmptyObject(selectedCustomer))return $("body").showAlert({type:"warning",body:"Select customer"});if($.isEmptyObject(selectedProducts))return $("body").showAlert({type:"warning",body:"No selected products"});var t=0;Object.keys(selectedProducts).forEach(function(e){t+=selectedProducts[e].PPrice*selectedProducts[e].orderQuantity}),orderAction({CustomerId:selectedCustomer.customerid,TotalAmount:t.toFixed(2),orders:selectedProducts,orderStatus:"pending"},function(e,t){return e?$("body").showAlert({type:"danger",body:"\n              <p class='m-0'>Something error happened. Try again later</p>\n              "}):JSON.parse(t).response?(selectedCustomer={},selectedProducts={},$("#customercard").find(".card-body").html(NoUserSelectedTemplate()),$("#orderproducts").html(NoProductSelectedTemplate()),$("#ordersummary").find("p span").text("0.00"),$("body").showAlert({type:"success",body:"<p>Order Success.</p>"})):void $("body").showAlert({type:"info",body:"Something happened on side. Please refresh the page for better experience."})})})});

    
</script>

</html>