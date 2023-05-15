        <?php

        session_start();

        $pageTitle = "Dashboard";


        if (isset($_SESSION["Username"])) {

            include "init.php";

            /* Start Dashboard Page */

    
            $numUsers = 5; // Number Of Latest Users

            $latestUsers = getLatest("*", "users", "UserID",$numUsers); // Latest Users Array

            $numItems = 5; // Number Of Latest Items

            $latestItem = getLatest("*","items","Item_ID",$numItems); // Latest Items Array

            $numComments = 4;

        ?>
            <div class="home-stats">
                <div class="container text-center">
                    <h1>Dashboard</h1>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat st-members">
                                <i class="fa fa-users"></i>
                                <div class="info">
                                    Total Members
                                    <span><a href="members.php"><?php echo countitems("UserID", "users"); ?></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat st-pending">
                               <i class="fa fa-user-plus"></i>
                               <div class="info">
                                    Pending Members
                                    <span><a href="members.php?action=Manage&page=Pending">
                                            <?php echo checkitem("RegStatus", "Users", 0) ?>
                                    </a></span>
                               </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat st-items">
                               <i class="fa fa-tag"></i>
                               <div class="info">
                                    Total Itmes
                                    <span><a href="items.php"> <?php echo countitems("Item_ID","items") ?></a></span>
                               </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat st-comments">
                               <i class="fa fa-comment"></i>
                               <div class="info">
                                    Total Comments
                                    <span>
                                        <a href="comments.php"> <?php echo countitems("C_id","comments") ?></a>
                                    </span>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="latest">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-users"></i> Latest <?php echo $numUsers; ?> Registerd Users
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled latest-users">
                                        <?php

                                            if (! empty($latestUsers)) {

                                            foreach ($latestUsers as $user) {

                                                echo "<li>";
                                                    echo  $user['Username'];
                                                    echo "<a href='members.php?action=Edit&&userid=" . $user["UserID"] . "'>";
                                                        echo "<span class='btn btn-success pull-right'>";
                                                            echo "<i class='fa fa-edit'></i>Edit";

                                                            if ($user["RegStatus"] == 0) {

                                                            echo "<a href='members.php?action=Activate&userid=" . $user['UserID'] . "' 
                                                            class='btn btn-info pull-right activate'>
                                                            <i class='fa fa-check'></i> Activate </a>";
                                                            }
                                                        echo "</span>";       
                                                    echo "</a>";
                                                echo "</li>";
                                            }

                                      ?>

                                      <?php } else {

                                         echo "There's No Users To Show";

                                      } 
                                      
                                      ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-tag"></i> Latest <?php echo $numItems; ?> Items
                                </div>
                                <div class="card-body">
                                      <ul class="list-unstyled latest-users">
                                        <?php
                                            
                                            if (!empty($latestItem)) {
                                            foreach ($latestItem as $item) {

                                                echo "<li>";
                                                    echo $item["Namee"];
                                                    echo "<a href='items.php?action=Edit&&itemid=" . $item["Item_ID"] . "'>";
                                                        echo "<span class='btn btn-success pull-right'>";
                                                            echo "<i class='fa fa-edit'></i>Edit";

                                                            if ($item["Approve"] == 0) {

                                                            echo "<a href='items.php?action=Approve&itemid=" . $item['Item_ID'] . "' 
                                                            class='btn btn-info pull-right activate'>
                                                            <i class='fa fa-check'></i>Approve</a>";
                                                            }
                                                        echo "</span>";       
                                                    echo "</a>";
                                                echo "</li>";
                                            }

                                        ?>
                                      <?Php } else {

                                         echo "There's No Itmes To Show";

                                      } ?>  
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- start latest comment -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-comment-o"></i> Latest <?php echo $numComments; ?> Comments
                                </div>
                                <div class="card-body">
                                 <?php 
                                       $stmt = $db->prepare("SELECT 
                                                                comments.*,users.Username 
                                                            FROM 
                                                                comments 

                                                            INNER JOIN 
                                                                 users 
                                                            ON users.UserID = comments.user_id

                                                            ORDER BY 
                                                                C_id DESC
                                                                
                                                            LIMIT $numComments");

                                        $stmt->execute();
                                        $comments = $stmt->fetchAll();  

                                        if (!empty($comments)) {
                                        foreach ($comments as $comment) {

                                            echo "<div class='comment-box'>";
                                                    echo '<span class="member-n">'; 
                                                          echo "<a href='members.php?action=Edit&&userid=
                                                          ".$comment['user_id']."'>".$comment['Username']."</a>";   
                                                    echo '</span>';

                                                    echo '<p class="member-c">' . $comment['Comment'] . '</p>';

                                                    echo '<a href="comments.php?action=Edit&&comid= '. $comment['C_id'] .'"
                                                    class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>';

                                                    echo '<a href="comments.php?action=Delete&&comid= '. $comment['C_id'] .'" 
                                                    class="btn btn-danger"><i class="fa fa-close"></i>Delete</a>';

                                                    if ($comment['Status'] == 0) {

                                                        echo "<a href='comments.php?action=Approve&&comid=".$comment['C_id']."'
                                                        class='btn btn-info'><i class='fa fa-Activate'></i>Approve</a>";
                                                    }

                                            echo "</div>";
                                        } 
                                   ?>
                                   <?Php } else {

                                         echo "There's No Comments To Show";

                                      } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End latest comment -->
                </div>
            </div>

        <?php
            /* End Dashboard Page */

            include  $tpl . "footer.php";
        } else {

            header("location:index.php");

            exit();
        }
