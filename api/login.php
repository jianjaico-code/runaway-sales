<?php
session_start();
$connection = require "../php/connection.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request method"]);
  exit;
}

$username = $_POST["loginUsername"];
$unhashedPassword = $_POST["loginPassword"];

//customer
$customerQuery = $connection->prepare("
  SELECT *
  FROM customer
  WHERE
    CCellphoneNo = ?
");
$customerQuery->bind_param("i", $username);
$customerQuery->execute();
$customerQueryResponse = $customerQuery->get_result()->fetch_assoc();

if(password_verify($unhashedPassword, $customerQueryResponse["CPassword"]))
{
  $_SESSION["user"] = $customerQueryResponse;
  $_SESSION["usertype"] = "customer";
  echo json_encode(["response" => true]);
  exit;
}

//employee
$employeeQuery = $connection->prepare("
  SELECT *
  FROM employee
  WHERE
    EContactNo = ?
");
$employeeQuery->bind_param("i", $username);
$employeeQuery->execute();
$employeeQueryResponse = $employeeQuery->get_result()->fetch_assoc();

if(password_verify($unhashedPassword, $employeeQueryResponse["EPassword"]))
{
  $_SESSION["user"] = $employeeQueryResponse;
  $_SESSION["usertype"] = $employeeQueryResponse["EmployeePositionId"] ? "delivery": "admin";
  echo json_encode(["response" => true]);
  exit;
}


echo json_encode(["response" => false]);