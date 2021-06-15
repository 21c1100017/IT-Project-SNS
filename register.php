<?php

require_once("./config.php");
require_once("./db_connect.php");

if(isset($_POST["username"]) and isset($_POST["email"]) and isset($_POST["password1"]) and isset($_POST["password2"])){
    if($_POST["password1"] == $_POST["password2"]){
        if($email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            require_once("./db_register.php");
        }else{
            $error_email = "メールアドレスの形式が不正です。";
        }
    }else{
        $error_password_not_match = "パスワードが一致しません。";
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規作成 | 簡単なSNS</title>
</head>
<body>
<div class="register_form">
    <h1>ユーザー新規作成</h1>
    <form action="./register.php" method="post">
        <p>
            ユーザー名: 
            <input type="text" name="username" required 
            <?php
                if(isset($_POST["username"])){
                    echo "value=\"".$_POST["username"]."\"";
                }
            ?>
            >
        </p>
        <p>
            メールアドレス: 
            <input type="text" name="email" required 
            <?php
                if(isset($_POST["email"])){
                    echo "value=\"".$_POST["email"]."\"";
                }
            ?>
            >
        </p>
        <?php
            if(isset($error_email)){
                echo "<p style=\"color: red;\">".$error_email."</p>";
            }
        ?>
        <p>
            パスワード: 
            <input type="password" name="password1" required>
        </p>
        <p>
            パスワード再入力: 
            <input type="password" name="password2" required>
        </p>
        <?php
            if(isset($error_password_not_match)){
                echo "<p style=\"color: red;\">".$error_password_not_match."</p>";
            }
        ?>
        <p>
            <input type="submit" value="新規作成">
        </p>
    </form>
</div>
</body>
</html>