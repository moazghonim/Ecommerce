<?php 


/*

===================================================
== Items Page
== 
===================================================
*/


    session_start();

    $pageTitle = "items";

    if (isset($_SESSION["Username"])) {

         include "init.php";

         $action = isset($_GET["action"]) ? $_GET["action"] : "Manage";
        
         if ($action == "Manage") {

                $stmt = $db->prepare("SELECT 
                                           items.*,
                                           categories.namee AS category_name,users.Username 
                                      FROM 
                                           items 

                                      INNER JOIN 

                                           categories 
                                      
                                      ON categories.ID = items.Cat_ID
                                       
                                      INNER JOIN

                                            users 
                                           
                                      ON users.UserID = items.Member_ID
                                      ORDER BY Item_ID DESC");

                // Execute The Statmante

                $stmt->execute();

                // Assign To Variable

                $items = $stmt->fetchAll();

                if (!empty($items)) {
        ?>
                <h1 class="text-center">Manage Items</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>ID</td>
                                <td>Item Name</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Adding Date</td>
                                <td>Category</td>
                                <td>Username</td>
                                <td>Control</td>
                            </tr>

                            <?php

                            foreach ($items as $item) {

                                echo "<tr>";
                                    echo "<td>" . $item["Item_ID"]       . "</td>";
                                    echo "<td>" . $item["Namee"]         . "</td>";
                                    echo "<td>" . $item["Descriptions"]  . "</td>";
                                    echo "<td>" . $item["Price"]         . "</td>";
                                    echo "<td>" . $item["Add_Date"]      . "</td>";
                                    echo "<td>" . $item["category_name"] . "</td>";
                                    echo "<td>" . $item["Username"]      . "</td>";
                                    echo "<td>

                                        <a href='items.php?action=Edit&itemid=" . $item['Item_ID'] . "' 
                                        class='btn btn-success'>
                                        <i class='fa fa-edit'></i> Edit </a>

                                        <a href='items.php?action=Delete&itemid=" . $item['Item_ID'] . "' 
                                        class='btn btn-danger'>
                                        <i class='fa fa-close'></i> Delete </a>";

                                        if ($item["Approve"] == 0) {

                                            echo "<a href='items.php?action=Approve&itemid=" . $item['Item_ID'] . "' 
                                            class='btn btn-info activate'>
                                            <i class='fa fa-check'></i>Approve</a>";
                                        }

                                    echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <a href="items.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
                    <?php  } else {

                        echo "<div class='container'>";

                              echo "<div class='alert alert-info'>There's No Items To Show</div>";
                              echo '<a href="items.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>';

                        echo "</div>";
                    
                    } ?>
                </div>
        <?php

         } elseif ($action == "Add") { ?>
             
            <h1 class="text-center">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Insert" method="POST">
                    <!-- start name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control" 
                                placeholder="Name Of The Item" 
                                required="required"
                             />
                        </div>
                    </div>
                    <!-- End name field -->
                    <!-- Start Desc field -->
                      <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input 
                                type="text" 
                                name="description" 
                                class="form-control"  
                                placeholder="Descripe Of The Item" 
                                required="required"
                                />
                        </div>
                    </div>
                      <!-- End Desc field -->
                      <!-- Start Price field -->
                     <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input 
                                type="text" 
                                name="price" 
                                class="form-control"  
                                placeholder="Price Of The Item" 
                                required="required"
                                />
                        </div>
                    </div>
                    <!-- End Price field -->
                    <!-- Start Country field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                            <input 
                                type="text" 
                                name="country" 
                                class="form-control"  
                                placeholder="Country Of Made" />
                        </div>
                    </div>
                    <!-- End Country field -->
                    <!-- Start Status field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                           <select class="form-control" name="status">
                               <option value="0">...</option>
                               <option value="1">New</option>
                               <option value="2">Like New</option>
                               <option value="3">Used</option>
                               <option value="4">Old</option>
                           </select>
                        </div>
                    </div>
                    <!-- End Status field -->
                    <!-- Start Members field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-6">
                           <select class="form-control" name="member">
                               <option value="0">...</option>
                              <?php 
                               
                                    $stmt = $db->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();

                                    foreach ($users as $user) {

                                        echo "<option value=' " . $user["UserID"] . " '>" . $user['Username'] . "</option>";
                                    }
                              ?>
                           </select>
                        </div>
                    </div>
                    <!-- End Members field -->
                    <!-- Start Category field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-6">
                           <select class="form-control" name="category">
                               <option value="0">...</option>
                                <?php 

                                   $stmt2 = $db->prepare("SELECT * FROM categories");
                                   $stmt2->execute();
                                   $categories = $stmt2->fetchAll();

                                   foreach ($categories as $category) {
                                        
                                       echo "<option value='" . $category["iD"] . "'> " . $category["namee"] . "</option>";
                                    }
                                 ?> 
                           </select>
                        </div>
                    </div>
                    <!-- Start  Submits field -->
                    <br>
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="col-sm-10">
                                <input 
                                    type="submit" 
                                    value="Add Item" 
                                    class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    </div>
                    <!-- End Submit field -->
                </form>
            </div>
        <?php

         } elseif ($action == "Insert") {
            
              if ($_SERVER['REQUEST_METHOD'] == 'POST') {


                    echo "<h1 class='text-center'>Insert Item</h1>";
                    echo "<div class='container'>";

                    // Get Varibrles From The Form

                    $name        = $_POST['name'];
                    $desc        = $_POST['description'];
                    $price       = $_POST['price'];
                    $country     = $_POST['country'];
                    $status      = $_POST['status'];
                    $cat         = $_POST['category'];
                    $member      = $_POST['member'];

                
                   

                    // validate The Form

                    $formErrors = [];

                    if (empty($name)) {

                        $formErrors[] =  "Name Cant Be Empty";
                    }

                    if (empty($desc)) {

                        $formErrors[] =  "Description Cant Be Empty";
                    }

                    if (empty($price)) {

                        $formErrors[] =  "Price Cant Be Empty";
                    }

                    if (empty($country)) {

                        $formErrors[] =  "Country Cant Be Empty";
                    }

                    if ($status == 0) {

                        $formErrors[] =  "You Must Choose The Status";
                    }

                    
                    if ($member == 0) {

                        $formErrors[] =  "You Must Choose The Member";
                    }

                     if ($cat == 0) {

                        $formErrors[] =  "You Must Choose The Category";
                    }


                    // Loop Into Errors Arry And Echo It

                    foreach ($formErrors as $errors) {

                        echo "<div class= 'alert alert-danger'> . $errors . </div>";
                    }

                    // Check if There's Errors Proceed The Update Operation

                    if (empty($formErrors)) {

                            // Insert UserInfo In Database

                            $stmt = $db->prepare("INSERT INTO 

                                                items(Namee, Descriptions, Price, Country_Made, Statuss, Add_Date, Cat_ID, Member_ID) 

                                            VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");

                            $stmt->execute([

                                "zname"       => $name,
                                "zdesc"       => $desc,
                                "zprice"      => $price,
                                "zcountry"    => $country,
                                "zstatus"     => $status,
                                "zcat"        => $cat,
                                "zmember"     => $member,
                            ]);

                            // Echo Success Message

                            $theMsg = "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " Recourd Inserted</div>";

                            redirectHome($theMsg, 'back');
                        
                    }
                } else {

                    echo "<div class='container'>";

                    $theMsg = "<div class= 'alert alert-danger'>Sorry You cant browse This Page Directly</div>";

                    redirectHome($theMsg);

                    echo "</div>";
                }

                echo "</div>";

         } elseif ($action == "Edit") {


             //  Check if Get Request ItemId is Numerc & Get The integer Value of it

                $itemid = isset($_GET["itemid"]) && is_numeric($_GET["itemid"]) ?  intval($_GET["itemid"]) :  0;

                //  Select All Data Depend On This Id

                $stmt = $db->prepare("SELECT * From items Where Item_ID = ?");

                // Execute Query

                $stmt->execute([$itemid]);

                //  Fetch The Data 

                $item = $stmt->fetch();

                // The Row Count 

                $count = $stmt->rowCount();

                // Theres Such Id Show The Data

                if ($count > 0) { ?>

                    <h1 class="text-center">Edit Item</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?action=Update" method="POST">
                        <input type="hidden" name="itemid" value="<?php echo $itemid ?>">    
                            <!-- start name field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        class="form-control" 
                                        placeholder="Name Of The Item" 
                                        required="required"
                                        value="<?php echo $item["Namee"]; ?>"
                                    />
                                </div>
                            </div>
                            <!-- End name field -->
                            <!-- Start Desc field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-md-6">
                                    <input 
                                        type="text" 
                                        name="description" 
                                        class="form-control"  
                                        placeholder="Descripe Of The Item" 
                                        required="required"
                                        value="<?php echo $item["Descriptions"]; ?>"
                                        />
                                </div>
                            </div>
                            <!-- End Desc field -->
                            <!-- Start Price field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-6">
                                    <input 
                                        type="text" 
                                        name="price" 
                                        class="form-control"  
                                        placeholder="Price Of The Item" 
                                        required="required"
                                        value="<?php echo $item["Price"]; ?>"
                                        />
                                </div>
                            </div>
                            <!-- End Price field -->
                            <!-- Start Country field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-10 col-md-6">
                                    <input 
                                        type="text" 
                                        name="country" 
                                        class="form-control"  
                                        placeholder="Country Of Made" 
                                        value="<?php echo $item["Country_Made"]; ?>"
                                        
                                        />
                                </div>
                            </div>
                            <!-- End Country field -->
                            <!-- Start Status field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="status"> 
                                    <option value="1" <?php if ($item["Statuss"] == 1) {echo "selected";} ?>>New</option>
                                    <option value="2" <?php if ($item["Statuss"] == 2) {echo "selected";} ?>>Like New</option>
                                    <option value="3" <?php if ($item["Statuss"] == 3) {echo "selected";} ?>>Used</option>
                                    <option value="4" <?php if ($item["Statuss"] == 4) {echo "selected";} ?>>Old</option>
                                </select>
                                </div>
                            </div>
                            <!-- End Status field -->
                            <!-- Start Members field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="member">
                                      <?php 
                                            $stmt = $db->prepare("SELECT * FROM users");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll();

                                            foreach ($users as $user) {

                                                echo "<option value='" . $user["UserID"] . "'"; 
                                                if ($item["Member_ID"] == $user["UserID"]) {echo "selected";}
                                                echo ">". $user['Username'] . "</option>";
                                            }
                                        ?>
                                </select>
                                </div>
                            </div>
                            <!-- End Members field -->
                            <!-- Start Category field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="category">
                                    <?php 
                                        $stmt2 = $db->prepare("SELECT * FROM categories");
                                        $stmt2->execute();
                                        $categories = $stmt2->fetchAll();

                                        foreach ($categories as $category) {
                                                
                                             echo "<option value='" . $category["iD"] . "'";
                                             if ($item["Cat_ID"] == $category["iD"]) {echo "selected";}
                                             echo ">" . $category["namee"] . "</option>";
                                           }
                                      ?>
                                </select>
                                </div>
                            </div>
                            <!-- Start  Submits field -->
                            <br>
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="col-sm-10">
                                        <input 
                                            type="submit" 
                                            value="Add Item" 
                                            class="btn btn-primary btn-sm" />
                                    </div>
                                </div>
                            </div>
                            <!-- End Submit field -->
                        </form>
                <?php

                       $stmt = $db->prepare("SELECT 
                                                  comments.*,users.Username 
                                                FROM 
                                                   comments 

                                                INNER JOIN 
                                                    users 
                                                ON users.UserID = comments.user_id
                                                
                                                WHERE Item_id = ?");

                    // Execute The Statmante

                    $stmt->execute([$itemid]);

                    // Assign To Variable

                    $rows = $stmt->fetchAll();

                    if (!empty($rows)) {
                ?>
                        <h1 class="text-center">Manage [ <?php echo $item["Namee"]; ?> ] Comments</h1>
                        <div class="table-responsive">
                            <table class="main-table text-center table table-bordered">
                                <tr>
                                    <td>Comment</td>
                                    <td>User Name</td>
                                    <td>Added Date</td>
                                    <td>Control</td>
                                </tr>

                        <?php

                                foreach ($rows as $row) {

                                    echo "<tr>";
                                        echo "<td>" . $row["Comment"] . "</td>";
                                        echo "<td>" . $row["Username"] . "</td>";
                                        echo "<td>" . $row["Comment_Date"]    . "</td>";
                                        echo "<td>
                                            
                                            <a href='comments.php?action=Edit&comid="   . $row['C_id'] . "' 
                                            class='btn btn-success'>
                                            <i class='fa fa-edit'></i> Edit </a>

                                            <a href='comments.php?action=Delete&comid=" . $row['C_id'] . "' 
                                            class='btn btn-danger'>
                                            <i class='fa fa-close'></i> Delete </a>";

                                            if ($row["Status"] == 0) {

                                                echo "<a href='comments.php?action=Approve&&comid=" . $row['C_id'] . "' 
                                                class='btn btn-info activate'>
                                                <i class='fa fa-check'></i> Approve </a>";
                                            }

                                        echo "</td>";
                                    echo "</tr>";
                                }
                        ?>
                            </table>
                        </div> 
                     <?php } ?>
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
             
            echo "<h1 class='text-center'>Update Item</h1>";
            echo "<div class='container'>";


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Get Varibrles From The Form

                    $id          = $_POST['itemid'];
                    $name        = $_POST['name'];
                    $desc        = $_POST['description'];
                    $price       = $_POST['price'];
                    $country     = $_POST['country'];
                    $status      = $_POST['status'];
                    $member      = $_POST['member'];
                    $category    = $_POST['category'];
                    

                    // validate The Form

                    $formErrors = [];

                    if (empty($name)) {

                        $formErrors[] =  "Name Cant Be Empty";
                    }

                    if (empty($desc)) {

                        $formErrors[] =  "Description Cant Be Empty";
                    }

                    if (empty($price)) {

                        $formErrors[] =  "Price Cant Be Empty";
                    }

                    if (empty($country)) {

                        $formErrors[] =  "Country Cant Be Empty";
                    }

                    if ($status == 0) {

                        $formErrors[] =  "You Must Choose The Status";
                    }

                    
                    if ($member == 0) {

                        $formErrors[] =  "You Must Choose The Member";
                    }

                     if ($category == 0) {

                        $formErrors[] =  "You Must Choose The Category";
                    }


                    // Loop Into Errors Arry And Echo It

                    foreach ($formErrors as $errors) {

                        echo "<div class='alert alert-danger'> . $errors . </div>";
                    }

                    // Check if There's Errors Proceed The Update Operation

                    if (empty($formErrors)) {

                        // Update The database with This Info

                        $stmt = $db->prepare("UPDATE 
                                                items 
                                            SET 
                                                Namee = ?, 
                                                Descriptions = ?,
                                                Price = ?, 
                                                Country_Made = ?, 
                                                Statuss = ?, 
                                                Member_ID = ?, 
                                                Cat_ID = ?
                                            WHERE  
                                                Item_ID = ?");

                        $stmt->execute([$name, $desc, $price, $country, $status, $member, $category, $id]);

                        // Echo Success Message

                        $theMsg = "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " recourd Updated</div>";

                        redirectHome($theMsg, 'back');
                    }
                    
                } else {

                    $theMsg =  "<div class= 'alert alert-danger'>Sorry You cant browse This Page Direct</div>";

                    redirectHome($theMsg);
                }

                echo "</div>";

         } elseif ($action == "Delete") {
              
             echo "<h1 class='text-center'>Delete Item</h1>";
             echo "<div class='container'>";

                //  Check if Get Request Id is Numerc & Get The integer Value of it

                $itemid = isset($_GET["itemid"]) && is_numeric($_GET["itemid"]) ? intval($_GET["itemid"]) : 0;

                //  Select All Data Depend On This Id

                $check = checkitem("Item_ID","items",$itemid);
                
                if ($check > 0) {
    
                    $stmt = $db->prepare("DELETE  FROM items WHERE Item_ID = ?");

                    $stmt->execute([$itemid]);

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Recourd Deleted</div>";
                    
                    redirectHome($theMsg,"back");

                } else {

                    $theMsg = "<div class='alert alert-danger'>This Id Does Not Exist</div>";

                    redirectHome($theMsg);
                }
                
             echo "</div>";

         } elseif ($action == "Approve") {

             echo "<h1 class='text-center'>Approve Item</h1>";
             echo "<div class='container'>";


                //  Check if Get Request Id is Numerc & Get The integer Value of it

                $itemid = isset($_GET["itemid"]) && is_numeric($_GET["itemid"]) ? intval($_GET["itemid"]) : 0;

                //  Select All Data Depend On This Id

                $check = checkitem("Item_ID","items",$itemid);
                
                if ($check > 0) {

                    $stmt = $db->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                    $stmt->execute([$itemid]);

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount()  . "Recourd Approved</div>";

                    redirectHome($theMsg,"back");

                } else {

                    $theMsg = "<div class='alert alert-danger'>This Id Does Not Exist</div>";
                    
                    redirectHome($theMsg);
                }

             echo "</div>";
         }

         include  $tpl . "footer.php";

    } else {

        header("location:index.php");
        exit();
    }