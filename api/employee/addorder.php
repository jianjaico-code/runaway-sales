<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request"]);
  exit;
}

$connection = require __DIR__ . "/../../php/connection.php";

$date = new DateTime();
$insertOrderResponse = false;
$insertOrderDetailsResponse = false;
$updateProductResponse = false;

  $connection->begin_transaction();
  $orderid = $deliveryid = $date->getTimestamp();
  $customerid = $_POST["CustomerId"];
  $amount = $_POST["TotalAmount"];
$employeeid = $_SESSION["user"]["EmployeeId"];
  $employeeid = 1540490626;
  $orderStatus = $_POST["orderStatus"];
  $insertOrderQuery = $connection->prepare("
  INSERT INTO
    orders (
      OrderId,
      CustomerId,
      Amount,
      EmployeeId
    )
  VALUES (?,?,?,?)
");

  $insertOrderQuery->bind_param("iidi", $orderid, $customerid, $amount, $employeeid);
  $insertOrderResponse = $insertOrderQuery->execute();

  foreach ($_POST["orders"] as $order) {
    $productid = $order["ProductId"];
    $selectedProduct = $connection->query("
    SELECT
      PQuantity,
      PName
    FROM productcategory
    WHERE
      ProductId = $productid
  ")->fetch_assoc();

    if ($order["orderQuantity"] > $selectedProduct["PQuantity"]) {
      $connection->rollback();
      echo json_encode(["error" => [
        "message" => "Insufficient product quantity",
        "productid" => $selectedProduct["PName"]
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

    $insertOrderDetail->bind_param("iid", $orderid, $order["ProductId"], $order["orderQuantity"]);
    $insertOrderDetailsResponse = $insertOrderDetail->execute();
    $remainingQuantity = (int)$selectedProduct["PQuantity"] - (int)$order["orderQuantity"];
    $updateProductResponse = $connection->query("
    UPDATE productcategory
    SET
      PQuantity = $remainingQuantity
    WHERE
      ProductId = $order[ProductId]
  ");
  }


  if ($insertOrderResponse && $insertOrderDetailsResponse && $updateProductResponse) {
    echo json_encode(["response" => $connection->commit()]);
  } else {
    echo json_encode(["response" => !$connection->rollback()]);
  }