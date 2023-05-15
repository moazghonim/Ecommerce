<?php



// Get Categories Function 
// Function To Get Categories From Database




function getCat()
{

    global $db;

    $getCat = $db->prepare("SELECT * FROM categories ORDER BY ID ASC");

    $getCat->execute();

    $Cats = $getCat->fetchAll();

    return $Cats;
}




// Get Items Function 
// Function To Get Categories From Database




function getItems($CatID)
{

    global $db;

    $getitems = $db->prepare("SELECT * FROM items WHERE Cat_ID = ? ORDER BY Item_ID DESC");

    $getitems->execute([$CatID]);

    $items = $getitems->fetchAll();

    return $items;
}




// Title Function That Echo The Page Tilte 
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





// Count Number Of Items  Function 
// Function To Count Items Of Rows
// $item = The Item To Count
// $table = The Table To Choose From


function countitems($item, $table)
{


    global $db;

    $stmt2 = $db->prepare("SELECT COUNT($item) FROM $table");

    $stmt2->execute();

    return $stmt2->fetchColumn();
}



// Get Latest Records Function 
// Function To Get Latest Items From Database [users,itmes,Comments]
// $select = Field To Select
// $table  = The Table To Choose From 
// $order  = The Desc Ordering
// $limit  = Number Of Records To Get



