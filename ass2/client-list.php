<?php 

if ($_COOKIE['type'] != 'client') {
	header("Location:login.php");
}

echo $_COOKIE['type'];

// session_destroy();

 ?>