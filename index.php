<?php

//ini_set('display_errors', 0);
session_start();
include("./db_connect.php");
$db = null;

if(isset($_SESSION["username"])){
    // header("Location: ./home.php");
}else{
    header("Location: ./login.php");
}

?>