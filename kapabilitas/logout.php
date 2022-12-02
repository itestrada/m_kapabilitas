<?php
	include 'inc.common.php';
   session_start();
   session_unset();
   session_destroy();
   $m="Logged Out.";
   header("Location: index$env?m=$m");
?>