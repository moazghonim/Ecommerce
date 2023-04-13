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


// Home Redirect Function 
// This Function Accept parameters
// $theMsg = Echo The Message [Error | Success | Warning]
// $url = The Link You Want Redirect To 
// $Seconds = Seconds Before Redirecting


function redirectHome($theMsg, $url = null, $seconds = 3)
{

    if ($url === null) {

        $url  = "index.php";

        $link = "Homepage";
    } else {

        if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== "") {

            $url  = $_SERVER["HTTP_REFERER"];

            $link = "Previous Page";
        } else {

            $url  = "index.php";

            $link = "Homepage";
        }
    }
    echo $theMsg;

    echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds</div>";

    header("refresh:$seconds;url=$url");
    exit();
}



// Check Items Function 
// Function To Check Itmes In Database [ Function Accept Parameters ]
// $Select = The Item To Select [Example: user,item,category]
// $Form = The Table To Select From [Example: users, Items,Categories]
// Value = The value of select [Example : Moaz, Box, Electronics]


function checkitem($select, $from, $value)
{

    global $db;

    $statement = $db->prepare("SELECT $select FROM $from WHERE $select = ? ");

    $statement->execute([$value]);

    $count =  $statement->rowCount();

    return $count;
}
