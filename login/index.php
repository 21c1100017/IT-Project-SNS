<?php

define("allow_access_config", true);
require_once("./config.php");

if(isset($_SESSION["user_data"])){
    header("Location: ./home.php");
    exit;
}

$user_name = "";
$error_login = "";

if(isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["csrf_token"])){
    if($_POST["csrf_token"] === $_SESSION["csrf_token"]){
        if(($user_data = login($_POST["user_name"], $_POST["password"])) != false){
            session_regenerate_id(true);
            $_SESSION["user_data"] = $user_data;
            header("Location: ./home.php");
            exit;
        }else{
            $error_login = "メールアドレス又はパスワードが間違っています";
        }
    }else{
            $error_login = "不正なトークンです。";
    }
}

if(isset($_POST["user_name"])){
    $user_name = $_POST["user_name"];
}

$html = create_html("login.html", "ログイン", [
    "<link rel=\"stylesheet\" href=\"./css/login.css\">"
], [
    "user_name" => htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'),
    "error_login" => $error_login
]);

print($html);
