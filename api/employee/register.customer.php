<?php

$connection = require __DIR__ . "/../../php/connection.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["error" => "Invalid request method"]);
  exit;
}
$date = new DateTime();
$customerid = $date->getTimestamp();
$firstname = $_POST["CFirstname"];
$lastname = $_POST["CLastname"];
$contactno = $_POST["CContact"];
$password = $_POST["CPassword"];
$address = $_POST["CAddress"];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$createUser = $connection->prepare("INSERT INTO customer VALUES (?,?,?,?,?,?)");
$createUser->bind_param("isssds", $customerid, $firstname, $lastname, $hashedPassword, $contactno, $address);
$createUserResponse = $createUser->execute();

echo json_encode(["response" => $createUserResponse]);