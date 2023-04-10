<?php


session_start(); // start the seesion

session_unset(); // unset the session 

session_destroy();


header("location: index.php");
exit();
