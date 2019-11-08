<?php

$connection = require __DIR__ . "/../../php/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request method"]);
  exit;
}
$date = new DateTime();
$supplierid = $date->getTimestamp();
$company = $_POST["addSupplierCompanyName"];
$contactno = $_POST["addSupplierContactNo"];
$password = $_POST["addSupplierPassword"];
$address = $_POST["addSupplierAddress"];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$createSupplier = $connection->prepare("INSERT INTO supplier VALUES (?,?,?,?,?)");
$createSupplier->bind_param("isiss", $supplierid, $company, $contactno,  $address, $hashedPassword);
$createSupplierResponse = $createSupplier->execute();

if($connection->error) {
  echo json_encode(["error" => $connection->error]);
  exit;
}

echo json_encode(["response" => $createSupplierResponse]);