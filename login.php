<?php

session_start();
require_once("./config.php");

if(isset($_SESSION["info"])){
    header("Location: ./home.php");
    exit;
}

$user_name = "";
$error_login = "";

if(isset($_POST["user_name"]) && isset($_POST["password"])){
    if(($user_data = login($_POST["user_name"], $_POST["password"])) != false){
        session_regenerate_id(true);
        $_SESSION["info"] = $user_data;
        header("Location: ./home.php");
        exit;
    }else{
        $error_login = "メールアドレス又はパスワードが間違っています";
    }
}

if(isset($_POST["user_name"])){
    $user_name = $_POST["user_name"];
}

$html = CreateHTML("login.html", [
    "title" => "ログイン",
    "head" => "",
    "user_name" => htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'),
    "erorr_login" => $error_login
]);

print($html);
