<?php
$conn = require __DIR__ . "/../php/connection.php";

$supplier = $conn->query("
  SELECT 
    SupplierId,
    SCompanyName,
    SAddress,
    SContactNo
  FROM supplier
")->fetch_all(MYSQLI_ASSOC);

if(isset($_GET["supplierid"]))
{
  echo json_encode($conn->query("
  SELECT 
    SupplierId,
    SCompanyName,
    SAddress,
    SContactNo
  FROM supplier
  WHERE SupplierId = $_GET[supplierid]
")->fetch_assoc());
exit;
}

echo json_encode($supplier);