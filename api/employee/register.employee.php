<?php

$connection = require __DIR__ . "/../../php/connection.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request method"]);
  exit;
}

$date = new DateTime();
$employeeid = $date->getTimestamp();
$employeepos = $_POST["position"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$contactno = $_POST["contact"];
$password = $_POST["password"];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$createUser = $connection->prepare("INSERT INTO employee VALUES (?,? ,? ,?,?,?)");
$createUser->bind_param("iisssd", $employeeid,$employeepos, $firstname, $lastname, $hashedPassword, $contactno);
$createUserResponse = $createUser->execute();

echo json_encode(["response" => $createUserResponse]);