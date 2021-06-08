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
    <form action="./register.php" method="post">
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
        <p>
            <input type="submit" value="ログイン">
        </p>
    </form>
</div>
</body>
</html>

<?php
    if(isset($_POST["username"]) and isset($_POST["password1"]) and isset($_POST["password2"])){
        if($_POST["password1"] == $_POST["password2"]){
            //問題なく入力された時の処理
        }else{
            echo "<p class=\"error\" style=\"color: red;\">パスワードが一致しません。</p>";
        }
    }
    $db = null;
?>