<?php
$conn = require __DIR__ . "/../php/connection.php";

  $sales = $conn->query("
  SELECT *
  FROM orders
  INNER JOIN orderdetails
    ON orders.OrderId = orderdetails.OrderId
")->fetch_all(MYSQLI_ASSOC);

echo json_encode($sales);