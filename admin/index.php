    <?php

    session_start();

    $NoNavbar = "";
    $pageTitle = "Login";

    if (isset($_SESSION["username"])) {

        header("location: dashboard.php"); // Redirect To Dashbord Page
    }

    include "init.php";


    // Check If User Coming HTTP Post Request

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST["user"];
        $password = $_POST['pass'];
        $hashedpass = sha1($password);

        // Check If The User Exist In  Databse

        $stmt = $db->prepare("SELECT UserID,Username,Pass
                              From
                                    users 
                              Where
                                    Username = ? 
                              And 
                                    Pass = ?   
                              And 
                                    GroupiD = 1
                              limit 1");
        $stmt->execute([$username, $hashedpass]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // if count > 0 This maen The Database Contain Record This About Username

        if ($count > 0) {

            $_SESSION['Username'] = $username; // Register Session Name
            $_SESSION['ID'] = $row["UserID"];  // Register Session Id
            header("location: dashboard.php"); // Redirect To Dashbord Page
            exit();
        }
    }

    ?>

    <form class="login" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">

        <h4 class="text-center">Admin Login</h4>
        <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
        <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
        <div class="d-grid gap-2">
            <input class="btn btn-primary btn-block" type="submit" value="Login" />
        </div>

    </form>

    <?php
    include  $tpl . "footer.php";
    ?>