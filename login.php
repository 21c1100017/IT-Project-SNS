<?php

include("./db_connect.php");
$db = null;

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
        <form action="./db_login.php" method="post">
            <p>
                ユーザーID: 
                <input type="text" name="username" required>
            </p>
            <p>
                パスワード: 
                <input type="password" name="password" required>
            </p>
            <p>
                <input type="submit" value="ログイン">
            </p>
        </form>
        <a href="./register.php"><button>新規作成</button></a>
    </div>
</body>
</html>