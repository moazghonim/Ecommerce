<?php
/*

===================================================
== Manage Comments page
== You Can update | Delete Comments From Here 
===================================================
*/

session_start();

$pageTitle = "Comments";

if (isset($_SESSION["Username"])) {

    include "init.php";

    $action = isset($_GET["action"]) ? $_GET["action"] : "Manage";

    // Start Manage Page

    if ($action == "Manage") { // Manage Member page 


        // Select All User Except Admin

        $stmt = $db->prepare("SELECT 
                                   comments.*,items.Namee AS item_name,users.Username 
                              FROM 
                                   comments 
                              INNER JOIN 
                                   items 
                              ON items.Item_ID = comments.Item_id

                              INNER JOIN 
                                   users 
                              ON users.UserID = comments.user_id
                              ORDER BY C_id DESC");

        // Execute The Statmante

        $stmt->execute();

        // Assign To Variable

        $comments = $stmt->fetchAll();

        if (!empty($comments)) {

        ?>

        <h1 class="text-center">Manage Comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>id</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>User Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>

                    <?php

                        foreach ($comments as $comment) {

                            echo "<tr>";
                                echo "<td>" . $comment["C_id"]   . "</td>";
                                echo "<td>" . $comment["Comment"] . "</td>";
                                echo "<td>" . $comment["item_name"]    . "</td>";
                                echo "<td>" . $comment["Username"] . "</td>";
                                echo "<td>" . $comment["Comment_Date"]    . "</td>";
                                echo "<td>
                                    
                                    <a href='comments.php?action=Edit&comid="   . $comment['C_id'] . "' 
                                    class='btn btn-success'>
                                    <i class='fa fa-edit'></i> Edit </a>

                                    <a href='comments.php?action=Delete&comid=" . $comment['C_id'] . "' 
                                    class='btn btn-danger'>
                                    <i class='fa fa-close'></i> Delete </a>";

                                    if ($comment["Status"] == 0) {

                                        echo "<a href='comments.php?action=Approve&&comid=" . $comment['C_id'] . "' 
                                        class='btn btn-info activate'>
                                        <i class='fa fa-check'></i> Approve </a>";
                                    }

                                echo "</td>";
                            echo "</tr>";
                        }

                    ?>
                </table>
            </div>
        </div>
        <?php  } else {

             echo "<div class='container'>";

                        echo "<div class='alert alert-info'>There's No Comments To Show</div>";

              echo "</div>";
                    
        } ?>
    <?php  

    } elseif ($action == "Edit") { // edit page 

        //  Check if Get Request Id is Numerc & Get The integer Value of it

        $comid = isset($_GET["comid"]) && is_numeric($_GET["comid"]) ?  intval($_GET["comid"]) :  0;

        //  Select All Data Depend On This Id

        $stmt = $db->prepare("SELECT * From comments Where C_id = ? ");

        // Execute Query

        $stmt->execute([$comid]);

        //  Fetch The Data 

        $row = $stmt->fetch();

        // The Row Count 

        $count = $stmt->rowCount();

        // Theres Such Id Show The Data

        if ($count > 0) { ?>

            <h1 class="text-center">Edit Commetn</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Update" method="POST">
                    <input type="hidden" name="comid" value="<?php echo $comid ?>">
                    <!-- start user name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10 col-md-6">
                             <textarea class="form-control" name="comment"><?php echo $row["Comment"];?></textarea>  
                        </div>
                    </div>
                    <!-- End user name field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="col-sm-10">
                                <input 
                                    type="submit" 
                                    value="Save" 
                                    class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                    <!-- End Submit field -->
                </form>
            </div>
       <?php
            // If Theres No Such Id Show Error Message
        } else {


            echo "<div class='container'>";

            $theMsg = "<div class= 'alert alert-danger'>Theres No Such ID</div>";

            redirectHome($theMsg);

            echo "</div>";
        }
    } elseif ($action == "Update") {


        echo "<h1 class='text-center'>Update Comment</h1>";
        echo "<div class='container'>";


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Varibrles From The Form

                $comid       = $_POST['comid'];
                $comment     = $_POST['comment'];
           
                // Update The database with This Info

                $stmt = $db->prepare("UPDATE comments SET Comment = ?  WHERE C_id = ?");

                $stmt->execute([$comment,$comid]);

                // Echo Success Message

                $theMsg = "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " recourd Updated</div>";

                redirectHome($theMsg, 'back');

            } else {

            $theMsg =  "<div class= 'alert alert-danger'>Sorry You cant browse This Page Direct</div>";

            redirectHome($theMsg);
        }

        echo "</div>";
    } elseif ($action == "Delete") { // Delete page

        echo "<h1 class='text-center'>Delete Comment</h1>";
        echo "<div class='container'>";

        //  Check if Get Request Id is Numerc & Get The integer Value of it

        $comid = isset($_GET["comid"]) && is_numeric($_GET["comid"]) ?  intval($_GET["comid"]) :  0;

        //  Select All Data Depend On This Id

        $check = checkitem("C_id", "comments",$comid);

        if ($check > 0) {

            $stmt = $db->prepare("DELETE FROM comments WHERE C_id = ?");

            $stmt->execute([$comid]);

            $theMsg =  "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " recourd Deleted</div>";

            redirectHome($theMsg,"back");
        } else {

            $theMsg = "<div class='alert alert-danger'>This Id Is Not Exist</div>";

            redirectHome($theMsg);
        }

        echo "</div>";
    } elseif ($action == "Approve") {

        echo "<h1 class='text-center'>Approve comment</h1>";
        echo "<div class='container'>";

        //  Check if Get Request Id is Numerc & Get The integer Value of it

        $comid = isset($_GET["comid"]) && is_numeric($_GET["comid"]) ?  intval($_GET["comid"]) :  0;

        //  Select All Data Depend On This Id

        $check = checkitem("C_id", "comments", $comid);

        if ($check > 0) {

            $stmt = $db->prepare("UPDATE comments SET `Status` = 1 WHERE C_id = ?");

            $stmt->execute([$comid]);

            $theMsg =  "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " recourd Approved</div>";

            redirectHome($theMsg,"back");
        } else {

            $theMsg = "<div class='alert alert-danger'>This Id Is Not Exist</div>";

            redirectHome($theMsg);
        }

        echo "</div>";
    }

    include  $tpl . "footer.php";
} else {

    header("location:index.php");
    exit();
}
