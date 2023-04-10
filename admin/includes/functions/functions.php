<?php


// Title Function That Echo The  Page Tilte 
// Has The Variable  $pageTilte And ehco Default title For Other pages


function getTitle()
{

    global $pageTitle;

    if (isset($pageTitle)) {

        echo $pageTitle;
    } else {

        echo "Default";
    }
}


// Home Redirect Function [This Function Accept parameters]
// $ErrorMsg = Echo The Error Message
// $Seconds = Seconds Before Redirecting


function redirectHome($errorMsg, $seconds = 3)
{

    echo "<div class='alert alert-danger'>$errorMsg</div>";

    echo "<div class='alert alert-info'>You Will Be Redirected To Home page After $seconds Seconds</div>";

    header("refresh:$seconds;url=dashboard.php");
    exit();
}
