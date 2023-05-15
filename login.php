
    <?php

       

       session_start();
       $pageTitle = "Login";

       if (isset($_SESSION["user"])) {

            header("location:index.php");
       }


       include "init.php";

       if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $user = $_POST["username"];
            $pass = $_POST["password"];
            $hashpass = sha1($pass);


            $stmt = $db->prepare("SELECT Username,pass FROM users WHERE Username = ? And pass = ?");

            $stmt->execute([$user,$hashpass]);

            $count = $stmt->rowCount();

            if ($count > 0) {

                $_SESSION["user"] = $user;
                print_r($_SESSION);

                header("location:index.php");
                exit();
            }
        }
        
    ?>


<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> |
        <span data-class="signup">Signup</span>
    </h1>
    <!-- start login form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input 
        class="form-control" 
        type="text" 
        name="username" 
        autocomplete="off"
        placeholder="Type Your Username"
        required>

        <input 
        class="form-control" 
        type="password" 
        name="password" 
        autocomplete="new-password"
        placeholder="Type a Complex Password"
        required>

        <input class="btn btn-primary btn-block" type="submit" value="Login">
    </form>
    <!-- End login form -->
    <!-- start signup -->
      <form class="signup">
        <input 
        class="form-control" 
        type="text" 
        name="username" 
        autocomplete="off"
        placeholder="Type Your Username">

        <input 
        class="form-control" 
        type="password" 
        name="password" 
        autocomplete="new-password"
        placeholder="Type a Complex Password">
        
        <input 
        class="form-control" 
        type="password" 
        name="password2" 
        autocomplete="new-password"
        placeholder="Type a  Password agin">

        <input 
        class="form-control" 
        type="email" 
        name="email" 
        autocomplete="new-password"
        placeholder="Type a valid email">

        <input class="btn btn-success btn-block" type="submit" value="Signup">
    </form>
    <!-- end signup -->
</div>

<?php include $tpl . "footer.php";?>