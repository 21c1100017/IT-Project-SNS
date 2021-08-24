<?php

define("allow_access_config", true);
require_once("./config.php");

if(!isset($_SESSION["user_data"])){
    header("Location: ./login.php");
    exit;
}

$html = create_html("home.html", [
    "title" => "ホーム",
    "head" => "",
    "user_nick_name" => htmlspecialchars($_SESSION["user_data"]["user_nick_name"], ENT_QUOTES, 'UTF-8')
]);

print($html);
