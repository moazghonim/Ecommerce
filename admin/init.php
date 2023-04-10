

<?php


include "connect.php";

// routes 

$tpl    = "includes/templates/"; //Template Directory
$lang   = "includes/languages/"; // Language Directory
$func   = "includes/functions/"; // Functions directory
$js     = "layout/js/"; // Js Directory
$css    = "layout/css/"; // Css Directory


// icludes The Important Files
include $func  . "functions.php";
include  $tpl   . "header.php";
include $lang   . "english.php";


// Include Navbar On All Pages expect The One with $NoNavbar Varible

if (!isset($NoNavbar)) {
    include  $tpl . "navbar.php";
}
