<?php

session_start();
require_once("./db_connect.php");
//ini_set('display_errors', 0);
$db = null;

if(isset($_SESSION["email"])){
    header("Location: ./home.php");
}else{
    header("Location: ./login.php");
}

?>