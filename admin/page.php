    <?php


    $action = isset($_GET["action"]) ? $action = $_GET["action"] :  "Manage";

    if ($action == "Manage") {

        echo "welocme You Are In Mange Category Page";
        echo '<a href="?action=Add">Add New Category + </a>';
    } elseif ($action == "Add") {

        echo "Welcome You Are In Add Category Page";
    } else {

        echo "Error There's No Page With This Names";
    }
