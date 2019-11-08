<?php

$firstname = isset($_SESSION["user"]) ? ucfirst($_SESSION["user"]["CFirstname"]) : "";
$lastname = isset($_SESSION["user"]) ? ucfirst($_SESSION["user"]["CLastname"]) : "";
$user=  '
<div class="header-top">
  <div class="container">
  <ul>
  <li><a href="account.php">Account</a></li>
  <li><a href="api/logout.php">Logout</a></li>
  </ul>
  <a href="#user">';
$user .= "$firstname $lastname";
$user .=  '</a>
  </div>
</div>';

$nouser = '
<div class="header-top">
  <div class="container">
    <a href="#login" data-modal="login">Login</a>
  </div>
</div>
';

$header = "
<nav class='navbar navbar-expand-lg  navbar-light bg-light sticky-top'>
<div class='container'>
  <a class='navbar-brand' href='/'>Runway Sales</a>
  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
    <span class='navbar-toggler-icon'></span>
  </button>

  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item active'>
        <a class='nav-link' href='/'>Shop <span class='sr-only'>(current)</span></a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='#cart'>Cart</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='/#contact'>Contact</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='/#about'>About</a>
      </li>
    </ul>
    <form class='form-inline my-2 my-lg-0 d-flex justify-content-between'>
      <input class='form-control mr-sm-2 border-0 bg-ligthen flex-grow-1' type='search' placeholder='Search product' aria-label='Search'>
      <button class='btn-theme my-2 my-sm-0' type='submit'>Search</button>
    </form>
  </div>
  </div>
</nav>
";
echo isset($_SESSION["user"]) ? $user . $header : $nouser . $header;