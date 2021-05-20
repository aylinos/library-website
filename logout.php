<?php

session_start();
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();
 // unset($_SESSION['logged_in']);  

 //Remove cookie remember me
 setcookie ("rememberme","", time() - (30 * 24 * 60 * 60 * 1000) );
 
header("location: index.php");
 ?>
