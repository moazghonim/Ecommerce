<?php


/*

===================================================
== Mange members Page
== You Can Add | update | Delete Memebrs From Here 
===================================================
*/

session_start();

$pageTitle = "Members";

if (isset($_SESSION["Username"])) {

    include "init.php";

    $action = isset($_GET["action"]) ? $_GET["action"] :  "Manage";

    // Start Manage Page

    if ($action == "Manage") { // Manage Member page 

        // Select All User Except Admin

        $stmt = $db->prepare("SELECT * FROM users WHERE GroupiD != 1");

        // Execute The Statmante

        $stmt->execute();

        // Assign To Variable

        $rows = $stmt->fetchAll();
?>
        <h1 class="text-center">Manage Members</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#id</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    foreach ($rows as $row) {

                        echo "<tr>";
                        echo "<td>" . $row["UserID"]   . "</td>";
                        echo "<td>" . $row["Username"] . "</td>";
                        echo "<td>" . $row["email"]    . "</td>";
                        echo "<td>" . $row["FullName"] . "</td>";
                        echo "<td></td>";
                        echo "<td>
                          <a href='members.php?action=Edit&&userid="   . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                          <a href='members.php?action=Delete&&userid=" . $row['UserID'] . "' class='btn btn-danger'><i class='fa fa-close'></i>Delete</a>
                        </td>";
                        echo "</tr>";
                    }

                    ?>
                    <tr>
                </table>
            </div>
            <a href="members.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
        </div>

    <?php  } elseif ($action == "Add") { // Add Members Page 
    ?>

        <h1 class="text-center">Add New Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?action=Insert" method="POST">
                <!-- start user name field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" class="form-control" required="requierd" autocomplete="off" placeholder="Username To Login Into Shop" />
                    </div>
                </div>
                <!-- End user name field -->
                <!-- start password field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="Password" name="password" class="password form-control" required="requierd" autocomplete="new-password" placeholder="password Must Be Hard & Complex" />
                    </div>
                </div>
                <!-- Start Password field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="Email" name="Email" class="form-control" required="requierd" placeholder="Email Must Be Valid" />
                    </div>
                </div>
                <!-- End Password field -->
                <!-- Start Full name field -->
                <div class=" form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" class="form-control" required="requierd" placeholder="Full Name Appear In Your Profile Page" />
                    </div>
                </div>
                <!-- End Full name field -->
                <!-- Start  Submits field -->
                <br>
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="col-sm-10">
                            <input type="submit" value="Add Member" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
                <!-- End Submit field -->
            </form>
        </div>

        <?php

    } elseif ($action == "Insert") {

        // Insert Member page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            echo "<h1 class='text-center'>Insert Member</h1>";
            echo "<div class='container'>";

            // Get Varibrles From The Form


            $user     = $_POST['username'];
            $pass     = $_POST['password'];
            $email    = $_POST['Email'];
            $name     = $_POST['full'];

            $hashpass = sha1($_POST["password"]);


            // validate The Form

            $formErrors = [];

            if (strlen($user) < 4) {

                $formErrors[] =  "Username Cant Be Less Then 4 Characters";
            }

            if (strlen($user) > 20) {

                $formErrors[] =  "Username Cant Be More Then 20 Characters";
            }

            if (empty($user)) {

                $formErrors[] =  "Username Cant Be Empty";
            }

            if (empty($pass)) {

                $formErrors[] =  "Password Cant Be Empty";
            }

            if (empty($email)) {

                $formErrors[] =  "Email Cant Be Empty";
            }

            if (empty($name)) {

                $formErrors[] =  "Full Name Cant Be Empty";
            }

            // Loop Into Errors Arry And Echo It

            foreach ($formErrors as $errors) {

                echo "<div class = 'alert alert-danger'> . $errors . </div>";
            }

            // Check if There's Errors Proceed The Update Operation

            if (empty($formErrors)) {

                // Insert UserInfo In Database

                $stmt = $db->prepare("INSERT INTO 
                                          users(Username,pass,email,FullName) 
                                      VALUES (:zuser,:zpass,:zmail,:zname)");
                $stmt->execute([

                    "zuser"  => $user,
                    "zpass"  => $hashpass,
                    "zmail"  => $email,
                    "zname"  => $name
                ]);

                // Echo Success Message

                echo "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " Recourd Inserted</div>";
            }
        } else {

            $errorMsg =  " Sorry You cant browse This Page Direct";

            redirectHome($errorMsg, 6);
        }

        echo "</div>";
    } elseif ($action == "Edit") { // edit page 

        //  Check if Get Request Id is Numerc & Get The integer Value of it

        $userid = isset($_GET["userid"]) && is_numeric($_GET["userid"]) ?  intval($_GET["userid"]) :  0;

        //  Select All Data Depend Of Id

        $stmt = $db->prepare("SELECT * From users Where UserID = ? limit 1");

        // Execute Query

        $stmt->execute([$userid]);

        //  Fetch The Data 

        $row = $stmt->fetch();

        // The Row Count 

        $count = $stmt->rowCount();

        // Theres Such Id Show The Data

        if ($count > 0) { ?>

            <h1 class="text-center">Edit Member</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Update" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                    <!-- start user name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="username" class="form-control" value="<?php echo $row["Username"]; ?>" autocomplete="off" required="required" />
                        </div>
                    </div>
                    <!-- End user name field -->
                    <!-- start password field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="hidden" name="oldpassword" value="<?php echo $row["pass"]; ?>">
                            <input type="Password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont To Want Change" />
                        </div>
                    </div>
                    <!-- Start Password field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="Email" name="Email" class="form-control" value="<?php echo $row["email"]; ?>" required="requierd" />
                        </div>
                    </div>
                    <!-- End Password field -->
                    <!-- Start Full name field -->
                    <div class=" form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="full" class="form-control" value="<?php echo $row["FullName"]; ?>" required="requierd" />
                        </div>
                    </div>
                    <!-- End Full name field -->
                    <!-- Start  Submits field -->
                    <br>
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                    <!-- End Submit field -->
                </form>
            </div>
<?php
            // If Theres No Such Id Show Error Message
        } else {

            echo "Theres No Such ID";
        }
    } elseif ($action == "Update") {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";

            // Get Varibrles From The Form

            $id       = $_POST['userid'];
            $user     = $_POST['username'];
            $email    = $_POST['Email'];
            $name     = $_POST['full'];

            // password Trick 

            $pass = empty($_POST["newpassword"]) ? $_POST["oldpassword"] : sha1($_POST["newpassword"]);

            // validate The Form

            $formErrors = [];


            if (strlen($user) < 4) {

                $formErrors[] =  "Username Cant Be Less Then 4 Characters";
            }

            if (strlen($user) > 20) {

                $formErrors[] =  "Username Cant Be More Then 20 Characters";
            }

            if (empty($user)) {

                $formErrors[] =  "Username Cant Be Empty";
            }

            if (empty($email)) {

                $formErrors[] =  "Email Cant Be Empty";
            }

            if (empty($name)) {

                $formErrors[] =  "Full Name Cant Be Empty";
            }

            // Loop Into Errors Arry And Echo It

            foreach ($formErrors as $errors) {

                echo "<div class = 'alert alert-danger'> . $errors . </div>";
            }


            // Check if There's Errors Proceed The Update Operation

            if (empty($formErrors)) {

                // Update The database with This Info

                $stmt = $db->prepare("UPDATE users SET Username = ?, email = ?, FullName = ?, pass = ? WHERE UserID = ?");

                $stmt->execute([$user, $email, $name, $pass, $id]);

                // Echo Success Message

                echo "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " recourd Updated</div>";
            }
        } else {

            echo " Sorry You cant browse This Page Direct";
        }

        echo "</div>";
    } elseif ($action == "Delete") { // Delete Member page

        echo "<h1 class='text-center'>Delete Member</h1>";
        echo "<div class='container'>";


        $userid = isset($_GET["userid"]) && is_numeric($_GET["userid"]) ?  intval($_GET["userid"]) :  0;

        //  Select All Data Depend Of Id

        $stmt = $db->prepare("SELECT * From users Where UserID = ? limit 1");

        // Execute Query

        $stmt->execute([$userid]);

        // The Row Count 

        $count = $stmt->rowCount();

        // Theres Such Id Show The Data

        if ($count > 0) {

            $stmt = $db->prepare("DELETE FROM users WHERE UserID = :zuser");

            $stmt->bindparam("zuser", $userid);

            $stmt->execute();

            echo "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " recourd Deleted</div>";
        } else {

            echo "This Id Is Not Exist";
        }

        echo "</div>";
    }

    include  $tpl . "footer.php";
} else {

    header("location:index.php");
    exit();
}
