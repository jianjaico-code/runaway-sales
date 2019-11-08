<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != "admin") {
  header("location: /login.php");
}

$conn = require "php/connection.php";

if (isset($_GET["productid"])) {
  $product = $conn->query("
  SELECT *
  FROM product
  INNER JOIN productcategory ON product.ProductId = productcategory.ProductId
  WHERE product.ProductId = $_GET[productid]
")->fetch_assoc();
}
//update name
if (isset($_POST["PName"])) {
  $response = $conn->query("
    UPDATE productcategory
    SET PName = '$_POST[PName]'
    WHERE ProductId = $_POST[ProductId]
  ");

  echo json_encode(["response" => $response]);
  exit;
}

//update brand
if (isset($_POST["PBrand"])) {
  $response = $conn->query("
    UPDATE product
    SET PBrand = '$_POST[PBrand]'
    WHERE ProductId = $_POST[ProductId]
  ");

  echo json_encode(["response" => $response]);
  exit;
}

//update price
if (isset($_POST["PPrice"])) {
  $response = $conn->query("
    UPDATE productcategory
    SET PPrice = $_POST[PPrice]
    WHERE ProductId = $_POST[ProductId]
  ");

  echo json_encode(["response" => $response]);
  exit;
}

//update quantity
if (isset($_POST["PQuantity"])) {
  $response = $conn->query("
    UPDATE productcategory
    SET PQuantity = $_POST[PQuantity]
    WHERE ProductId = $_POST[ProductId]
  ");

  echo json_encode(["response" => $response]);
  exit;
}

//update sizes
if (isset($_POST["PSizes"])) {
  $response = $conn->query("
    UPDATE productcategory
    SET PSizes = '$_POST[PSizes]'
    WHERE ProductId = $_POST[ProductId]
  ");

  echo json_encode(["response" => $response]);
  exit;
}

//update name
if (isset($_POST["PColors"])) {
  $response = $conn->query("
    UPDATE productcategory
    SET PColors = '$_POST[PColors]'
    WHERE ProductId = $_POST[ProductId]
  ");

  echo json_encode(["response" => $response]);
  exit;

}

//update image
if (isset($_FILES["PImage"])) {
  $date = new DateTime();
  $timestamp = $date->getTimestamp();
  $image = $_FILES["PImage"];
  $validextensions = array("jpeg", "jpg", "png");
  $temporary = explode(".", $image["name"]);
  $fileextension = end($temporary);

  $targetpath = "";
//check if file is valid image type and file size not to large
  if (($image["type"] == "image/png" || $image["type"] == "image/jpg" || $image["type"] == "image/jpeg") && ($image["size"] < 1500000) && in_array($fileextension, $validextensions)) {
    //check if there's error on upload
    if ($image["error"] > 0) {
      echo json_encode(["error" => true]);
      exit;
    }

    $sourcepath = $image["tmp_name"];
    $filename = $timestamp . "-" . $image["name"];
    $targetpath = "uploads/" . $filename;
  } else {
    echo json_encode(["error" => "File too large"]);
    exit;
  }

  $moved = move_uploaded_file($sourcepath, $targetpath);

  if (!$moved) {
    echo json_encode(["error" => "Internal server error"]);
    exit;
  }

  $response = $conn->query("
    UPDATE productcategory
    SET PImage = '$filename'
    WHERE ProductId = $_POST[ProductId]
  ");

  echo json_encode(["response" => $response]);
  exit;
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
        <h1>Product</h1>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb bg-white small border border-1 border-grey">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="products.php">Product</a>
          </li>
          <li class="breadcrumb-item active">View Product</li>
        </ol>

        <!-- Page Content -->
        <div class="card mb-5">
          <div class="card-body">
          <h4 class="card-title">Product #<?php echo $product["ProductId"] ?></h4>
            <input type="hidden" name="productid" id="productid" value="<?php echo $product["ProductId"] ?>">
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white">Name</span>
                  </div>
                  <input type="text" class="form-control bg-white" id="viewproductname" name="viewproductname" placeholder="Product name" aria-label="Product Name" aria-describedby="productnameedit" disabled value="<?php echo $product["PName"] ?>">
                  <div class="input-group-append">
                    <a href="#" id="productnameedit" class="btn btn-primary" onclick="enableInput(this)"><i class="fa fa-edit"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white">Brand</span>
                  </div>
                  <input type="text" class="form-control bg-white" id="viewproductbrand" name="viewproductbrand" placeholder="Product Brand" aria-label="Product Brand" aria-describedby="productbrandedit" disabled value="<?php echo $product["PBrand"] ?>">
                  <div class="input-group-append">
                    <a href="#" id="productbrandedit" class="btn btn-primary" onclick="enableInput(this)"><i class="fa fa-edit"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                 <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white">Price</span>
                  </div>
                  <input type="number" class="form-control bg-white" id="viewproductprice" step=".01" name="viewproductprice" placeholder="Product price" aria-label="Product price" aria-describedby="productpriceedit" disabled value="<?php echo $product["PPrice"] ?>">
                  <div class="input-group-append">
                    <a href="#" id="productpriceedit" class="btn btn-primary" onclick="enableInput(this)"><i class="fa fa-edit"></i></a>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white">Quantity</span>
                  </div>
                  <input type="number" class="form-control bg-white" id="viewproductquantity"  name="viewproductquantity" placeholder="Product quantity" aria-label="Product quantity" aria-describedby="productquantityedit" disabled value="<?php echo $product["PQuantity"] ?>">
                  <div class="input-group-append">
                    <a href="#" id="productquantityedit" class="btn btn-primary" onclick="enableInput(this)"><i class="fa fa-edit"></i></a>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white">Sizes</span>
                  </div>
                  <input type="text" class="form-control bg-white" id="viewproductsizes" name="viewproductsizes" placeholder="Product sizes" aria-label="Product sizes" aria-describedby="productsizesedit" disabled value="<?php echo $product["PSizes"] ?>">
                  <div class="input-group-append">
                    <a href="#" id="productsizesedit" class="btn btn-primary" onclick="enableInput(this)"><i class="fa fa-edit"></i></a>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white">Colors</span>
                  </div>
                  <input type="text" class="form-control bg-white" id="viewproductcolors" name="viewproductcolors" placeholder="Product colors" aria-label="Product colors" aria-describedby="productcolorsedit" disabled value="<?php echo $product["PColors"] ?>">
                  <div class="input-group-append">
                    <a href="#" id="productcolorsedit" class="btn btn-primary" onclick="enableInput(this)"><i class="fa fa-edit"></i></a>
                  </div>
                </div>

                <input type="file" name="viewproductimage" id="viewproductimage" onchange="handleImageChange(this)" style="position: absolute">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button class="btn btn-primary" onclick="$('#viewproductimage').click()">Choose Files</button>
                  </div>
                  <input type="text" class="form-control bg-white" id="viewproductimageref" name="viewproductimageref" placeholder="Product image" aria-label="Product image" aria-describedby="productimageedit" disabled>
                  <div class="input-group-append">
                    <input type="button" disabled href="#" id="productimageedit" class="btn btn-outline-primary" value="Upload">
                  </div>
                </div>

              </div>
              <div class="col-sm-12 col-md-6">
                <h6 class="h6">Image Preview</h6>
                <img src="<?php echo "uploads/" . $product["PImage"] ?>" alt="" class="img-fluid" id="productimagepreview">
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
                                                  echo $date->format("Y"); ?></span>
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

  var _defaultvalues = {
    name: $("#viewproductname").val(),
    brand: $("#viewproductbrand").val(),
    price: $("#viewproductprice").val(),
    quantity: $("#viewproductquantity").val(),
    sizes: $("#viewproductsizes").val(),
    colors: $("#viewproductcolors").val(),
    image: $("#productimagepreview").attr("src")
  }
"use strict";function enableInput(e){$("*[aria-describedby='"+e.id+"']").attr("disabled",!1).focus()}function handleImageChange(e){$("#viewproductimageref").val(e.files[0].name);var t=new FileReader;t.onload=function(){$("#productimagepreview").attr("src",t.result)},t.readAsDataURL(e.files[0]),$("#productimageedit").attr("disabled",!1)}function updateField(e,t){$.ajax("viewproduct.php",{method:"POST",data:e}).then(function(e){t(e)}).catch(function(e){console.error(e),$("body").showAlert({type:"warning",body:"Something happened on our side. Please reload your browser for better experience"})})}jQuery(function(){$("#viewproductname").on("blur",function(t){if(!$(t.target).val())return $(t.target).val(_defaultvalues.name);$(t.target).val()!=_defaultvalues.name&&($(t.target).attr("disabled",!0),updateField({PName:$(t.target).val(),ProductId:$("#productid").val()},function(e){console.log(e),JSON.parse(e).response&&$("body").showAlert({type:"success",body:"Name updated."}),$(t.target).val(_defaultvalues.name)}))}),$("#viewproductbrand").on("blur",function(t){if(!$(t.target).val())return $(t.target).val(_defaultvalues.brand);$(t.target).val()!=_defaultvalues.brand&&($(t.target).attr("disabled",!0),updateField({PBrand:$(t.target).val(),ProductId:$("#productid").val()},function(e){if(JSON.parse(e).response)return $("body").showAlert({type:"success",body:"Brand updated."});$(t.target).val(_defaultvalues.brand)}))}),$("#viewproductquantity").on("blur",function(t){if(!$(t.target).val())return $(t.target).val(_defaultvalues.quantity);$(t.target).val()!=_defaultvalues.quantity&&($(t.target).attr("disabled",!0),updateField({PQuantity:$(t.target).val(),ProductId:$("#productid").val()},function(e){if(JSON.parse(e).response)return $("body").showAlert({type:"success",body:"Quantity updated."});$(t.target).val(_defaultvalues.brand)}))}),$("#viewproductprice").on("blur",function(t){if(!$(t.target).val())return $(t.target).val(_defaultvalues.price);$(t.target).val()!=_defaultvalues.price&&($(t.target).attr("disabled",!0),updateField({PPrice:$(t.target).val(),ProductId:$("#productid").val()},function(e){if(JSON.parse(e).response)return $("body").showAlert({type:"success",body:"Quantity updated."});$(t.target).val(_defaultvalues.brand)}))}),$("#viewproductsizes").on("blur",function(t){if(!$(t.target).val())return $(t.target).val(_defaultvalues.sizes);$(t.target).val()!=_defaultvalues.sizes&&($(t.target).attr("disabled",!0),updateField({PSizes:$(t.target).val(),ProductId:$("#productid").val()},function(e){if(JSON.parse(e).response)return $("body").showAlert({type:"success",body:"Sizes updated."});$(t.target).val(_defaultvalues.sizes)}))}),$("#viewproductcolors").on("blur",function(t){if(!$(t.target).val())return $(t.target).val(_defaultvalues.colors);$(t.target).val()!=_defaultvalues.colors&&($(t.target).attr("disabled",!0),updateField({PColors:$(t.target).val(),ProductId:$("#productid").val()},function(e){if(JSON.parse(e).response)return $("body").showAlert({type:"success",body:"Colors updated."});$(t.target).val(_defaultvalues.colors)}))}),$("#productimageedit").on("click",function(a){var e=new FormData;e.append("PImage",document.querySelector("#viewproductimage").files[0]),e.append("ProductId",$("#productid").val()),$.ajax("viewproduct.php",{method:"POST",data:e,cache:!1,processData:!1,contentType:!1}).then(function(e){var t=JSON.parse(e);return t.response?($(a.target).attr("disabled",!0),$("#viewproductimage").val(""),$("#viewproductimageref").val(""),$("body").showAlert({type:"success",body:"Image Updated."})):t.error?$("body").showAlert({type:"danger",body:"Error: ".concat(t.error)}):void 0}).catch(function(e){$("body").showAlert({type:"error",body:"Something happened on our side. Please reload the browser for better experience."})})})});

/* function enableInput(e) {
  $("*[aria-describedby='" + e.id + "']").attr("disabled", false).focus()
}

function handleImageChange(_this) {
  //set file name to texbox
  $("#viewproductimageref").val(_this.files[0].name)
  //preview image
  var reader = new FileReader();

  reader.onload = function() {
    $("#productimagepreview").attr("src",reader.result)
  }
  reader.readAsDataURL(_this.files[0])
  $("#productimageedit").attr("disabled", false)
}

function updateField(data, callback) {
  $.ajax("viewproduct.php", {
    method: "POST",
    data: data
  })
  .then(function(res) {
    callback(res)
  })
  .catch(function(err) {
    console.error(err)
    $("body").showAlert({
          type: "warning",
          body: "Something happened on our side. Please reload your browser for better experience"
    })
  })
}

jQuery(function() {

  //update productname
  $("#viewproductname").on("blur", function(e) {
    if(!$(e.target).val()) return $(e.target).val(_defaultvalues["name"])
    if($(e.target).val() == _defaultvalues["name"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PName: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function(res) {
      console.log(res)
      var json = JSON.parse(res)
      if(json.response) {
        $("body").showAlert({
          type: "success",
          body: "Name updated."
        })
      }

      $(e.target).val(_defaultvalues["name"])
    })
  })

  //update brand
  $("#viewproductbrand").on("blur", function(e) {
    if(!$(e.target).val()) return $(e.target).val(_defaultvalues["brand"])
    if($(e.target).val() == _defaultvalues["brand"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PBrand: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function(res) {
      var json = JSON.parse(res)
      if(json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Brand updated."
        })
      }

      $(e.target).val(_defaultvalues["brand"])
    })
  })

  //update quantity
  $("#viewproductquantity").on("blur", function(e) {
    if(!$(e.target).val()) return $(e.target).val(_defaultvalues["quantity"])
    if($(e.target).val() == _defaultvalues["quantity"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PQuantity: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function(res) {
      var json = JSON.parse(res)
      if(json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Quantity updated."
        })
      }

      $(e.target).val(_defaultvalues["brand"])
    })
  })


   //update quantity
  $("#viewproductprice").on("blur", function(e) {
    if(!$(e.target).val()) return $(e.target).val(_defaultvalues["price"])
    if($(e.target).val() == _defaultvalues["price"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PPrice: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function(res) {
      var json = JSON.parse(res)
      if(json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Quantity updated."
        })
      }

      $(e.target).val(_defaultvalues["brand"])
    })
  })

  //update sizes
  $("#viewproductsizes").on("blur", function(e) {
    if(!$(e.target).val()) return $(e.target).val(_defaultvalues["sizes"])
    if($(e.target).val() == _defaultvalues["sizes"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PSizes: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function(res) {
      var json = JSON.parse(res)
      if(json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Sizes updated."
        })
      }

      $(e.target).val(_defaultvalues["sizes"])
    })
  })

  //update colors
  $("#viewproductcolors").on("blur", function(e) {
    if(!$(e.target).val()) return $(e.target).val(_defaultvalues["colors"])
    if($(e.target).val() == _defaultvalues["colors"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PColors: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function(res) {
      var json = JSON.parse(res)
      if(json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Colors updated."
        })
      }

      $(e.target).val(_defaultvalues["colors"])
    })
  })

  //update image
  $("#productimageedit").on("click", function (e) {
    var formdata  = new FormData();
    formdata.append("PImage", document.querySelector("#viewproductimage").files[0])
    formdata.append("ProductId", $("#productid").val())

    $.ajax("viewproduct.php", {
      method: "POST",
      data: formdata,
      cache: false,
      processData: false,
      contentType: false
    })
    .then(function(res) {
      var json = JSON.parse(res)
      if(json.response) {
      $(e.target).attr("disabled", true)
      $("#viewproductimage").val("")
      $("#viewproductimageref").val("")
        return $("body").showAlert({
          type: "success",
          body: "Image Updated."
        })
      }

      if(json.error) {
        return $("body").showAlert({
          type: "danger",
          body: `Error: ${json.error}`
        })
      }
    })
    .catch(function(err) {
      $("body").showAlert({
        type: "error",
        body: "Something happened on our side. Please reload the browser for better experience."
      })
    })
  })
}) */

</script>

</html>