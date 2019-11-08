<?php
$f = $_SESSION["user"]["EFirstname"];
$l = $_SESSION["user"]["ELastname"];
$x = $f . " " . $l;

echo
  "
<ul class='navbar-nav ml-auto ml-md-0'>
	<li class='nav-item dropdown no-arrow'>
		<a class='nav-link dropdown-toggle' href='#' id='userDropdown' role='button' data-toggle='dropdown'
			aria-haspopup='true' aria-expanded='false'>
			<i class='fas fa-user-circle fa-fw'></i>&nbsp;" . $x . "</i>
        </a>
	<div class='dropdown-menu dropdown-menu-right' aria-labelledby='userDropdown'>
		<a class='dropdown-item' href='/api/logout.php'>Logout</a>
	</div>
      </li>
    </ul>
"
;