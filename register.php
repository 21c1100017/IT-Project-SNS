<?php

include("./db_connect.php");

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
    <form action="./db_register.php" method="post">
        <p>
            ユーザーID: 
            <input type="text" name="username" required>
        </p>
        <p>
            パスワード: 
            <input type="password" name="password1" required>
        </p>
        <p>
            パスワード再入力: 
            <input type="password" name="password2" required>
        </p>

        <?php
            if(isset($register_error)){
                echo "<p style=\"color: red;\">" . $register_error . "</p>";
            }
        ?>

        <p>
            <input type="submit" value="新規作成">
        </p>
    </form>
</div>
</body>
</html>