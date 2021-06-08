<?php

session_start();
require_once("./db_connect.php");

if(isset($_SESSION["email"])){
    header("Location: ./home.php");
    exit;
}

if(isset($_POST["email"]) and isset($_POST["password"])){
    require_once("./db_login.php");
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | 簡単なSNS</title>
</head>
<body>
    <div class="login_form">
        <h1>ログイン</h1>
        <form action="./login.php" method="post">
            <p>
                メールアドレス: 
                <input type="text" name="email" required>
            </p>
            <p>
                パスワード: 
                <input type="password" name="password" required>
            </p>
            <?php
                if(isset($error_login)){
                    echo "<p style=\"color: red;\">".$error_login."</p>";
                }
            ?>
            <p>
                <input type="submit" value="ログイン">
            </p>
        </form>
        <a href="./register.php"><button>新規作成</button></a>
    </div>
</body>
</html>