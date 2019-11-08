<?php
session_start();
if(!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "customer")
{
  echo json_encode(["error" => "Unauthorized access"]);
  exit;
}
$connection = require __DIR__ . "/../../php/connection.php";
$customerid = $_SESSION["user"]["CustomerId"];
$orderHistory = $connection->query("
  SELECT 
    orders.OrderId OrderId,
    orders.Amount Total,
    orders.OrderDate OrderDate,
    customerdelivery.DeliveryStatus DeliveryStatus
  FROM
    orders
        INNER JOIN
    customerdelivery ON orders.OrderId = customerdelivery.OrderId
  WHERE
    orders.CustomerId = $customerid
")->fetch_all(MYSQLI_ASSOC);


echo json_encode(["data" => $orderHistory]);