<?php
$conn = require __DIR__ . "/../php/connection.php";

if(isset($_GET["productid"])){
  $productid = $_GET["productid"];
  $product = $conn->query("
    SELECT *
    FROM product
    INNER JOIN productcategory ON productcategory.ProductId = product.ProductId
    WHERE product.ProductId = $productid
  ")->fetch_assoc();

  echo json_encode($product);
  exit;
}

$products = $conn->query("
  SELECT *
  FROM product
  INNER JOIN productcategory ON productcategory.ProductId = product.ProductId
")->fetch_all(MYSQLI_ASSOC);

echo json_encode($products);