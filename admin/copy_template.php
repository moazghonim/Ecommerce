
 <?php



/*

===================================================
== Template Page
== 
===================================================
*/


    session_start();

    $pageTitle = "";

    if (isset($_SESSION["Username"])) {

         include "init.php";

         $action = isset($_GET["action"]) ? $_GET["action"] : "Manage";
        
         if ($action == "Manage") {


         } elseif ($action == "Add") {


         } elseif ($action == "Insert") {


         } elseif ($action == "Edit") {


         } elseif ($action == "Update") {


         } elseif ($action == "Delete") {


         } elseif ($action == "Activate") {


         }

         include  $tpl . "footer.php";

    } else {

        header("location:index.php");
        exit();
    }


