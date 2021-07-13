<?php

session_start();
require_once("./config.php");

if(!isset($_SESSION["info"])){
    header("Location: ./login.php");
    exit;
}

$html = file_get_contents("template/home.html");
$html = str_replace("{{user_nick_name}}", htmlspecialchars($_SESSION["info"]["user_nick_name"], ENT_QUOTES, 'UTF-8'), $html);

print($html);