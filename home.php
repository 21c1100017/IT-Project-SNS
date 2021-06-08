<?php

session_start();

if(!isset($_SESSION["email"])){
    header("Location: ./login.php");
    exit;
}

?>

<h1>
    ようこそ！ 
    <?php
        echo $_SESSION["email"];
    ?>
</h1>
<a href="./logout.php"><button>ログアウト</button></a>