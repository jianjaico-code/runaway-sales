<?php
session_start();
$conn = require __DIR__ . "/../php/connection.php";
if($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request method"]);
  exit;
}

//parameters
$empid = $_SESSION["user"]["EmployeeId"];
$suppid = $_POST["supplierid"];
$address = $_POST["address"];
$orders = json_decode($_POST["orders"], true);


$conn->begin_transaction();
$date = new DateTime();
$poid = $date->getTimestamp();
$purchaseOrderResponse = $conn->query("
  INSERT INTO purchaseorder (
    PurchaseOrderId,
    EmployeeId,
    SupplierId,
    PODeliveryAddress
  )
  VALUES (
    $poid,
    $empid,
    $suppid,
    '$address'
  )
");

//loop all through the values orders and insert into podetails
foreach($orders as $order) {
  $purchaseOrderDetailsResponse = $conn->query("
    INSERT INTO purchasedetails (
      PurchaseOrderId,
      ProductId,
      POQuantity
    )
    VALUES (
      $poid,
      $order[ProductId],
      $order[requestQuantity]
    )
  ");

  if(!$purchaseOrderDetailsResponse) {
    var_dump($conn->error);
    $conn->rollback();
    echo json_encode(["error" => "Uncaught error happened"]);
    exit;
  }
}


if($purchaseOrderDetailsResponse && $purchaseOrderResponse) {
  $conn->commit();
  echo json_encode(["response" => true]);
  exit;
} else {
  $conn->rollback();
  echo json_encode(["error" => false]);
  exit;
}