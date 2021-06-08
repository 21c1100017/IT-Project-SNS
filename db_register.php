<?php

include("db_connect.php");

if(isset($_POST["username"]) and isset($_POST["password1"]) and isset($_POST["password2"])){
    if($_POST["password1"] == $_POST["password2"]){
        //問題なく入力された時の処理
    }else{
        $register_error = "パスワードが一致しません。";
        include("./register.php");
    }
}

$db = null;

?>