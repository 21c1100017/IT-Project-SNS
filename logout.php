<?php

session_start();
define("allow_access_config", true);
require_once("./config.php");

if(!isset($_SESSION["info"])){
    header("Location: ./login.php");
    exit;
}

$_SESSION = [];
session_destroy();
header("Location: ./login.php");
