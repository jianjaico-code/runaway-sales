<?php
$conn = require __DIR__ . "/../php/connection.php";

$customers = $conn->query("
  SELECT
    CustomerId as customerid,
    CFirstname as firstname,
    CLastname as lastname,
    CDeliveryAddress as address,
    CCellphoneNo as contact
  FROM customer
")->fetch_all(MYSQLI_ASSOC);

echo json_encode($customers);