<?php

/*
===================================================
== category Page
== 
===================================================
*/


    session_start();

    $pageTitle = "Categories";

    if (isset($_SESSION["Username"])) {

         include "init.php";

         $action = isset($_GET["action"]) ? $_GET["action"] : "Manage";
        
         if ($action == "Manage") { 

                $sort = "ASC";

                $sort_array = ["ASC","DESC"];

                if (isset($_GET["sort"]) && in_array($_GET["sort"], $sort_array)) {

                    $sort = $_GET["sort"];
                }
              
                $stmt2 = $db->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

                $stmt2->execute();

                $cats = $stmt2->fetchAll(); 

                if (!empty($cats)) {
                
                ?>

                <h1 class="text-center">Manage Categories</h1>
                <div class="container categories">
                    <div class="card">
                        <div class="card-header">
                            Manage Categories
                            <div class="ordering pull-right">
                              <i class="fa fa-sort"></i> Ordering: [ 
                               <a class="<?php if ($sort == "ASC")  {echo "active";} ?>" href="?sort=ASC">ASC</a> |
                               <a class="<?php if ($sort == "DESC") {echo "active";} ?>"  href="?sort=DESC">DESC</a> ]
                            </div>
                        </div>
                        <div class="card-body">
                        <?php  
                            
                            foreach ($cats as $cat) {
                                
                                echo "<div class='cat'>";
                                    echo "<div class='hidden-buttons'>";
                                         echo "<a href='categories.php?action=Edit&&catid=". $cat['iD'] ."'  
                                         class='btn btn-xs btn-primary'>
                                         <i class='fa fa-edit'></i>Edit</a>";

                                         echo "<a href='categories.php?action=Delete&&catid=". $cat["iD"] ."' 
                                         class='btn btn-xs btn-danger'>
                                         <i class='fa fa-close'></i>Delete</a>";
                                    echo "</div>";

                                    echo "<h3>". $cat["namee"]."</h3>";

                                    echo "<p>"; if($cat["Descriptions"] == "") { 
                                        
                                        echo "This Category Has No Description"; 
                                    
                                     } else { echo $cat["Descriptions"]; } echo "</p>";

                                    if ($cat["Visibility"] == 1) { 
                                    
                                        echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>'; 
                                    }

                                    if ($cat["Allow_Comment"] == 1) { 

                                      echo '<span class="commenting"><i class="fa fa-close"></i> Comment Disabled</span>'; 
                                    }

                                    if ($cat["Allow_Ads"] == 1) { 
                                        echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disabled</span>';
                                     }

                                echo "</div>";
                                 
                                echo "<hr>";
                            }
                        ?>
                        
                        </div>           
                    </div>
                    <?php  } else {

                        echo "<div class='container'>";

                              echo "<div class='alert alert-info'>There's No Categories To Show</div>";
                              echo '<a class="add-category btn btn-primary" href="categories.php?action=Add">
                                    <i class="fa fa-plus"></i>Add New Category</a>';

                        echo "</div>";
                    } ?> 

                     <?php
                     
                         echo '<a class="add-category btn btn-primary" href="categories.php?action=Add">
                               <i class="fa fa-plus"></i>Add New Category</a>';
                      ?> 
                </div>
         <?php

         } elseif ($action == "Add") { ?>


            <h1 class="text-center">Add New Category</h1>
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
                                required="requierd"  
                                autocomplete="off" 
                                placeholder="Name Of The Category" />
                        </div>
                    </div>
                    <!-- End name field -->
                    <!-- start Description field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input 
                                type="text" 
                                name="description" 
                                class="form-control" 
                                placeholder="Describe The Category" />
                        </div>
                    </div>
                    <!-- End Description field -->
                    <!-- Start Ordering field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input 
                                type="text" 
                                name="ordering" 
                                class="form-control" 
                                placeholder="Number To Arrange The Categories" />
                        </div>
                    </div>
                    <!-- End Ordering field -->
                    <!-- Start Visibility field -->
                    <div class=" form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input 
                                    id="vis-yes" 
                                    type="radio" 
                                    name="visibility" 
                                    value="0" checked/>
                                    <label for="vis-yes">Yes</label> 
                            </div>
                            <div>
                                <input 
                                    id="vis-no"
                                    type="radio" 
                                    name="visibility" 
                                    value="1"/>
                                    <label for="vis-no">No</label> 
                            </div>
                        </div>
                    </div>
                    <!-- End Visibility field -->
                    <!-- Start Commenting field -->
                    <div class=" form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input 
                                    id="com-yes" 
                                    type="radio" 
                                    name="commenting" 
                                    value="0" checked/>
                                    <label for="com-yes">Yes</label> 
                            </div>
                            <div>
                                <input 
                                    id="com-no" 
                                    type="radio" 
                                    name="commenting"
                                    value="1"/>
                                    <label for="com-no">No</label> 
                            </div>
                        </div>
                    </div>
                    <!-- End Commenting field -->
                     <!-- Start Ads field -->
                    <div class=" form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input 
                                    id="ads-yes" 
                                    type="radio" 
                                    name="ads" 
                                    value="0" checked/>
                                    <label for="ads-yes">Yes</label> 
                            </div>
                            <div>
                                <input 
                                    id="ads-no" 
                                    type="radio" 
                                    name="ads" 
                                    value="1"/>
                                    <label for="ads-no">No</label> 
                            </div>
                        </div>
                    </div>
                    <!-- End Ads field -->
                    <!-- Start  Submits field -->
                    <br>
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="col-sm-10">
                                <input 
                                type="submit" 
                                value="Add Category" 
                                class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                    <!-- End Submit field -->
                </form>
            </div>

            <?php

         } elseif ($action == "Insert") {

             if ($_SERVER["REQUEST_METHOD"] == "POST") {

                echo "<h1 class='text-center'>Insert Category</h1>"; 
                echo "<div class='container'>";

                // Get Varibales From The Form

                $name        = $_POST["name"];
                $desc        = $_POST["description"];
                $order       = $_POST["ordering"];
                $visible     = $_POST["visibility"];
                $comment     = $_POST["commenting"];
                $ads         = $_POST["ads"];

                // Validate The Form

                if (!empty($name)) {

                    // Check If Category In Database

                    $check = checkitem("namee","categories",$name);

                    if ($check == 1) {

                    $theMsg =  "<div class='alert alert-danger'> Sorry This Category Is Exist</div>";

                    redirectHome($theMsg,"back");

                } else {

                    //  Insert Category Info 

                    $stmt = $db->prepare("INSERT INTO 

                            categories(namee, Descriptions, Ordering, Visibility, Allow_Comment, Allow_Ads)

                    VALUES(:znamee, :zdesc, :zorder, :zvisible, :zcomment,:zads)");
                    
                    $stmt->execute([

                        "znamee"    =>   $name,
                        "zdesc"     =>   $desc,
                        "zorder"    =>   $order,
                        "zvisible"  =>   $visible,
                        "zcomment"  =>   $comment,
                        "zads"      =>   $ads

                    ]);

                     $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

                     redirectHome($theMsg,"back");

                 }

             } else {

                    $theMsg = "<div class='alert alert-danger'>Category Cant Be Empty</div>";

                    redirectHome($theMsg,"back");
             }


             } else {

                echo "<div class='container'>";
                 
                    $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";

                    redirectHome($theMsg);

                echo "</div>";
             }

             echo "</div>";
          

         } elseif ($action == "Edit") {
           
            //  Check if Get Request Catid is Numerc & Get The integer Value of it

            $catid = isset($_GET["catid"]) && is_numeric($_GET["catid"]) ?  intval($_GET["catid"]) :  0;

            //  Select All Data Depend On This Id

            $stmt = $db->prepare("SELECT * From categories Where iD = ?");

            // Execute Query

            $stmt->execute([$catid]);

            //  Fetch The Data 

            $cat = $stmt->fetch();

            // The Row Count 

            $count = $stmt->rowCount();

            // Theres Such Id Show The Data

            if ($count > 0) { ?>


                <h1 class="text-center">Edit Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?action=Update" method="POST">
                        <input type="hidden" name="catid" value="<?php echo $catid ?>">
                        <!-- start name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control"  
                                    autocomplete="off" 
                                    placeholder="Name Of The Category" 
                                    value="<?php echo $cat["namee"] ?>"  />
                            </div>
                        </div>
                        <!-- End name field -->
                        <!-- start Description field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input 
                                    type="text" 
                                    name="description" 
                                    class="form-control"  
                                    placeholder="Describe The Category" 
                                    value="<?php echo $cat["Descriptions"] ?>" />
                            </div>
                        </div>
                        <!-- End Description field -->
                        <!-- Start Ordering field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-md-6">
                                <input 
                                    type="text" 
                                    name="ordering" 
                                    class="form-control" 
                                    placeholder="Number To Arrange The Categories"  
                                    value="<?php echo $cat["Ordering"] ?>"/>
                            </div>
                        </div>
                        <!-- End Ordering field -->
                        <!-- Start Visibility field -->
                        <div class=" form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input 
                                        id="vis-yes" 
                                        type="radio" 
                                        name="visibility" 
                                        value="0" <?php if($cat["Visibility"] == 0 ) {echo "checked";} ?>/>
                                        <label for="vis-yes">Yes</label> 
                                </div>
                                <div>
                                    <input 
                                        id="vis-no" 
                                        type="radio" 
                                        name="visibility" 
                                        value="1" <?php if($cat["Visibility"] == 1 ) {echo "checked";} ?>/>
                                        <label for="vis-no">No</label> 
                                </div>
                            </div>
                        </div>
                        <!-- End Visibility field -->
                        <!-- Start Commenting field -->
                        <div class=" form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input 
                                        id="com-yes" 
                                        type="radio" 
                                        name="commenting" 
                                        value="0" <?php if($cat["Allow_Comment"] == 0 ) {echo "checked";} ?>/>
                                        <label for="com-yes">Yes</label> 
                                </div>
                                <div>
                                    <input 
                                        id="com-no" 
                                        type="radio" 
                                        name="commenting" 
                                        value="1"  <?php if($cat["Allow_Comment"] == 1 ) {echo "checked";} ?>/>
                                        <label for="com-no">No</label> 
                                </div>
                            </div>
                        </div>
                        <!-- End Commenting field -->
                        <!-- Start Ads field -->
                        <div class=" form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input 
                                        id="ads-yes" 
                                        type="radio" 
                                        name="ads" 
                                        value="0" <?php if($cat["Allow_Ads"] == 0 ) {echo "checked";} ?> />
                                        <label for="ads-yes">Yes</label> 
                                </div>
                                <div>
                                    <input 
                                        id="ads-no" 
                                        type="radio" 
                                        name="ads" 
                                        value="1"  <?php if($cat["Allow_Ads"] == 1 ) {echo "checked";} ?>/>
                                        <label for="ads-no">No</label> 
                                </div>
                            </div>
                        </div>
                        <!-- End Ads field -->
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


                echo "<div class='container'>";

                    $theMsg = "<div class= 'alert alert-danger'>Theres No Such ID</div>";

                    redirectHome($theMsg);

                echo "</div>";
            }

         } elseif ($action == "Update") {
            
                echo "<h1 class='text-center'>Update Category</h1>";
                echo "<div class='container'>";


                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Get Varibrles From The Form

                    $id          = $_POST["catid"];
                    $name        = $_POST["name"];
                    $desc        = $_POST["description"];
                    $order       = $_POST["ordering"];
                    $visible     = $_POST["visibility"];
                    $comment     = $_POST["commenting"];
                    $ads         = $_POST["ads"];
                

                    // Check if name not empty

                    if (!empty($name)) {

                        // Update The database with This Info

                        $stmt = $db->prepare("UPDATE categories 
                                                  SET 
                                                     namee = ?,
                                                     Descriptions = ?, 
                                                     Ordering = ?, 
                                                     Visibility = ?,
                                                     ALLOW_Comment = ?,
                                                     Allow_Ads = ? 

                                                  WHERE iD = ?");

                        $stmt->execute([$name, $desc, $order, $visible,$comment,$ads,$id]);

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

            echo "<h1 class='text-center'>Delete Member</h1>";
            echo "<div class='container'>";

            //  Check if Get Request Id is Numerc & Get The integer Value of it

            $catid = isset($_GET["catid"]) && is_numeric($_GET["catid"]) ?  intval($_GET["catid"]) :  0;

            //  Select All Data Depend On This Id

            $check = checkitem("iD", "categories", $catid);

            if ($check > 0) {

                $stmt = $db->prepare("DELETE FROM categories WHERE iD = ?");

                $stmt->execute([$catid]);

                $theMsg =  "<div class = 'alert alert-success'>" . $stmt->rowCount()  . " recourd Deleted</div>";

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
