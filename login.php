<?php

session_start();
define("allow_access_config", true);
require_once("./config.php");

if(isset($_SESSION["info"])){
    header("Location: ./home.php");
    exit;
}

$token_byte = openssl_random_pseudo_bytes(16);
$csrf_token = bin2hex($token_byte);
$_SESSION["csrf_token"] = $csrf_token;
$user_name = "";
$error_login = "";

if(isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["csrf_token"])){
    if($_POST["csrf_token"] === $_SESSION["csrf_token"]){
        if(($user_data = login($_POST["user_name"], $_POST["password"])) != false){
            session_regenerate_id(true);
            $_SESSION["info"] = $user_data;
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

$html = CreateHTML("login.html", [
    "title" => "ログイン",
    "head" => "",
    "csrf_token" => $csrf_token,
    "user_name" => htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'),
    "error_login" => $error_login
]);

print($html);
