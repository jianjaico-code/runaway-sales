<?php
$connection = require __DIR__ . "/../../php/connection.php";

$date = new DateTime();
$timestamp = $productid = $date->getTimestamp();
$name = $_POST["PName"];
$quantity = $_POST["PQuantity"];
$sizes = $_POST["PSizes"];
$colors = $_POST["PColors"];
$brand = $_POST["PBrand"];
$image = $_FILES["PImage"];
$price = $_POST["PPrice"];

$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $image["name"]);
$fileextension = end($temporary);

$targetpath = "";
//check if file is valid image type and file size not to large
if (($image["type"] == "image/png" || $image["type"] == "image/jpg" || $image["type"] == "image/jpeg") && ($image["size"] < 1500000) && in_array($fileextension, $validextensions)) {
    //check if there's error on upload
    if ($image["error"] > 0) {
        echo json_encode(["error" => true]);
        exit;
    }

    $sourcepath = $image["tmp_name"];
    $filename = $timestamp . "-" . $image["name"];
    $targetpath = __DIR__ . "/../../uploads/" . $filename;
} else {
    echo json_encode(["error" => "File too large"]);
    exit;
}

$connection->begin_transaction();

$insertProduct = $connection->prepare("
    INSERT INTO
      product(
        ProductId,
        PBrand
      )
    VALUES (
      ?,
      ?
    )
  ");
$insertProduct->bind_param("is", $timestamp, $brand);

$insertProductResponse = $insertProduct->execute();

$insertProductCategory = $connection->prepare("
    INSERT INTO
      productcategory (
          ProductId,
          PName,
          PQuantity,
          PPrice,
          PSizes,
          PColors,
          PImage
      )
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$insertProductCategory->bind_param("isidsss", $productid, $name, $quantity, $price, $sizes, $colors, $filename);

$insertProductCategoryResponse = $insertProductCategory->execute();

if ($insertProductResponse && $insertProductCategoryResponse) {
    $moved = move_uploaded_file($sourcepath, $targetpath);

    if (!$moved) {
        echo json_encode(["error" => "Internal server error"]);
        exit;
    }

    echo json_encode(["response" => $connection->commit()]);
    exit;
} else {
    echo json_encode(["response" => !$connection->rollback()]);
}