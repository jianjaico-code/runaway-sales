<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "customer")
{
  echo json_encode(["error" => "Unauthorized access"]);
  exit;
}
$connection = require __DIR__ . "/../../php/connection.php";
$orderid = isset($_GET["orderid"]) ? $_GET["orderid"] : "";

$orderDetailsResponse = $connection->query("
SELECT
  orderdetails.OrderId,
  orderdetails.ProductId,
  orderdetails.OrderQuantity,
  productcategory.PName,
  productcategory.PPrice
FROM
  orderdetails
    INNER JOIN
  productcategory ON orderdetails.ProductId = productcategory.ProductId
WHERE
  orderdetails.OrderId = $orderid
");
$orderDetails;

if($orderDetailsResponse) {
  $orderDetails = $orderDetailsResponse->fetch_all(MYSQLI_ASSOC);
}

echo json_encode(["data" => $orderDetailsResponse ? $orderDetails : "Order not found"]);
exit;