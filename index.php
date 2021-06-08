<?php

//ini_set('display_errors', 0);

session_start();

include("./db_connect.php");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡単なSNS</title>
</head>
<body>
    <p>
        データベース：
            <?php 
                if($db_connecting){
                    echo "<span style=\"color: blue;\">接続中</span>";
                }else{
                    echo "<span style=\"color: red;\">接続されていません</span>";
                }
            ?>
    </p>
    <?php
        if(isset($_SESSION["username"])){
            //ログイン後の処理
        }else{
            include("./login.php");
        }
    ?>
</body>
</html>

<?php

$db = null;

?>