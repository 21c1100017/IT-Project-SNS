<?php

session_start();
require_once("./config.php");

if(!isset($_SESSION["info"])){
    header("Location: ./login.php");
    exit;
}

$html = CreateHTML("home.html", [
    "title" => "ホーム",
    "head" => "",
    "user_nick_name" => htmlspecialchars($_SESSION["info"]["user_nick_name"], ENT_QUOTES, 'UTF-8')
]);

print($html);