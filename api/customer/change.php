<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method"]);
    exit;
}

if (!isset($_SESSION["user"]) || $_SESSION["usertype"] !== "customer") {
    echo json_encode(["error" => "Unauthorized access"]);
    exit;

}

$connection = require __DIR__ . "/../../php/connection.php";

$hashedPassword = $_SESSION["user"]["CPassword"];
$password = $_POST["password"];
$customerid = $_SESSION["user"]["CustomerId"];
$matched = password_verify($password, $hashedPassword);

if ($matched && isset($_POST["changeContact"])) {
    $phone = $_POST["changeContact"];
    $response = $connection->query("
    UPDATE
      customer
    SET
      CCellphoneNo = $phone
    WHERE
      CustomerId = $customerid
  ");

    if ($response) {
        $_SESSION["user"]["CCellphoneNo"] = (double) $phone;
    }
    echo json_encode(["response" => $response]);
    exit;
}

if ($matched && isset($_POST["changeAddress"])) {
    $address = $_POST["changeAddress"];

    $response = $connection->query("
    UPDATE
      customer
    SET
      CDeliveryAddress = '$address'
    WHERE
      CustomerId = $customerid
    ");
    if ($response) {
        $_SESSION["user"]["CDeliveryAddress"] = $address;
    }

    echo json_encode(["response" => $response]);
    exit;
}

if ($matched && isset($_POST["changePassword"])) {
    $newPassword = $_POST["changePassword"];
    $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $response = $connection->query("
    UPDATE
      customer
    SET
      CPassword = '$newHashedPassword'
    WHERE
      CustomerId = $customerid
    ");
    if ($response) {
        session_destroy();
        session_unset();
    }
    echo json_encode(["response" => $response]);
    exit;
}


if(!$matched) {
  echo json_encode(["response" => false]);
  exit;
}