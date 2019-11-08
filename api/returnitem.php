<?php
session_start();
$conn = require __DIR__ . "/../php/connection.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request method"]);
  exit;
}

$orderid = $_POST["orderid"];
$productid = $_POST["productid"];
$count = $_POST["count"];
$reason = $_POST["reason"];


var_dump($_POST);

$returns = $conn->query("
  INSERT INTO returns (
    OrderId,
    ProductId,
    ItemCount,
    Reason
  )
  VALUES (
    $orderid,
    $productid,
    $count,
    '$reason'
  )
");

echo json_encode(["response" => $returns]);