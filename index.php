<?php

session_start();
require_once("./config.php");
require_once("./db_connect.php");
$db = null;

if(isset($_SESSION["email"])){
    header("Location: ./home.php");
}else{
    header("Location: ./login.php");
}

?>