<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $css; ?>front.css" />
    <title><?php getTitle(); ?></title>
</head>
  <body>
       <div class="upper-bar">
         <div class='container'>

            <?php
               
                if (isset($_SESSION["user"])) {

                     echo "Weclome " . $_SESSION["user"];
               } else {

            ?>

             <a href="login.php">
                <span class="">Login/Signup</span>
             </a>
                
             <?php } ?>
             
         </div>
       </div>
       <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Home page</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="app-nav">
                <ul class="nav navbar-nav navbar-right">
                   <?php 
                    
                    foreach (getCat() as $cat) {

                    echo "<li>
                            <a href='categories.php?pageid=". $cat['iD']."&pagename=". str_replace(" ","-",$cat['namee']) ."'>
                                ".$cat['namee']."
                             </a>
                         </li>";

                    }
                   
                   ?>
                </ul>
            </div>
        </div>
    </nav>