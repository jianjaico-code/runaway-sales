<?php

if($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request method"]);
  exit;
}

session_start();
$connection = require __DIR__ . "/../../php/connection.php";

$date = new DateTime();
$insertOrderResponse = false;
$insertOrderDetailsResponse = false;
$updateProductResponse = false;

$connection->begin_transaction();
$orderid = $deliveryid = $date->getTimestamp();
$customerid = $_SESSION["user"]["CustomerId"];
$amount = $_POST["TotalAmount"];

$insertOrderQuery = $connection->prepare("
  INSERT INTO
    orders (
      OrderId,
      CustomerId,
      Amount
    )
  VALUES (?,?,?)
");

$insertOrderQuery->bind_param("iid", $orderid, $customerid, $amount);
$insertOrderResponse = $insertOrderQuery->execute();

foreach($_POST["orders"] as $order)
{
  $productid = $order["ProductId"];
  $selectedProduct = $connection->query("
    SELECT
      PQuantity,
      PName
    FROM productcategory
    WHERE
      ProductId = $productid
  ")->fetch_assoc();

  if($order["OrderQuantity"] > $selectedProduct["PQuantity"])
  {
    $connection->rollback();
    echo json_encode(["error" => [
      "message" => "Insufficient product quantity",
      "productid" =>  $selectedProduct["PName"]
    ]]);

    exit;
  }

  $insertOrderDetail = $connection->prepare("
    INSERT INTO
      orderdetails (
        OrderId,
        ProductId,
        OrderQuantity
      )
    VALUES (?, ?, ?)
  ");

  $insertOrderDetail->bind_param("iid", $orderid, $order["ProductId"], $order["OrderQuantity"]);
  $insertOrderDetailsResponse = $insertOrderDetail->execute();
  $remainingQuantity = (int) $selectedProduct["PQuantity"] -  (int) $order["OrderQuantity"];
  $updateProductResponse = $connection->query("
    UPDATE productcategory
    SET
      PQuantity = $remainingQuantity
    WHERE
      ProductId = $order[ProductId]
  ");
}

if($insertOrderResponse && $insertOrderDetailsResponse && $updateProductResponse)
{
  echo json_encode(["response" => $connection->commit()]);
} else {
  echo json_encode(["response" => !$connection->rollback()]);
}