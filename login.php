<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <form action="/api/login.php" method="POST">
    <input type="text" name="loginUsername" id="loginUsername">
    <input type="password" name="loginPassword" id="loginPassword">
    <input type="submit" value="Hello">
  </form>
</body>
</html>