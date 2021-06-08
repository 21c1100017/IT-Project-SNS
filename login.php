<?php

    if(isset($_POST["username"]) and isset($_POST["password"])){
        //$mysqli->prepare("SELECT ");
    }

?>

<div class="login_form">
    <form action="./login.php" method="post">
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