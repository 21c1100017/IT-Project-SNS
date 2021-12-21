<?php

define("allow_access_config", true);
require_once("../config.php");

if(!isset($_SESSION["user_data"])){
    header("Location: ../login/");
    exit;
}

$_SESSION = [];
session_destroy();
header("Location: ../login/");
