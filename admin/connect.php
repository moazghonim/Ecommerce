    <?php


    $dsn = "mysql:host=localhost;dbname=shop";
    $user = "root";
    $pass = "";
    $optaion = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    ];

    try {
        $db = new PDO($dsn, $user, $pass, $optaion);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Faild To connect" . $e->getMessage();
    }
