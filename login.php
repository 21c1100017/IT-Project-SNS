<?php

session_start();
require_once("./config.php");

if(isset($_SESSION["user_name"])){
    header("Location: ./home.php");
    exit;
}

$user_name = "";
$error_login = "";

if(isset($_POST["user_name"]) && isset($_POST["password"])){
    if(login($_POST["user_name"], $_POST["password"]) != false){
        session_regenerate_id(true);
        $_SESSION["user_name"] = $row["user_name"];
        header("Location: ./home.php");
        exit;
    }else{
        $error_login = "メールアドレス又はパスワードが間違っています";
    }
}

if(isset($_POST["user_name"])){
    $user_name = $_POST["user_name"];
}

$html = file_get_contents("template/login.html");
$html = str_replace("{{user_name}}", $user_name, $html);
$html = str_replace("{{error_login}}", $error_login, $html);
print($html);
