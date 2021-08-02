<?php

session_start();
define("allow_access_config", true);
require_once("./config.php");

if(isset($_SESSION["email"])){
    header("Location: ./home.php");
}else{
    header("Location: ./login.php");
}
