<?php include "init.php"; ?>


<div class="container">
    <h1 class="text-center"><?php echo str_replace("-"," ",$_GET["pagename"])  ?></h1>
    <div class="row">
        <?php

            $pageid  = $_GET['pageid'];
            
            $getitem = getitems($pageid);
        
            if (!empty($getitem)) {

            foreach ($getitem as $item) {

                echo "<div class='col-sm-6 col-md-3'>";
                        echo "<div class='card item-box'>";
                            echo "<span class='price-tag'>".$item['Price']."</span>";
                            echo "<img class='img-responsive' src='img.png' alt=''/>";
                            echo "<div class='caption'>";
                                   echo "<h3>".$item['Namee']."</h3>";
                                   echo "<p>".$item['Descriptions']."</p>";
                            echo "</div>";
                        echo "</div>";
                     echo "</div>";           
            }   
    
        ?>
        <?php } else {

            echo "<div class='alert alert-danger'>This category ".str_replace("-"," ",$_GET["pagename"]) ." does not contain any Itmes</div>";
        } ?>

  </div> 
</div>

<?php include  $tpl . "footer.php" ;?>

  