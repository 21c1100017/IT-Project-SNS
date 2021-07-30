<?php

session_start();
require_once("./config.php");

if(isset($_SESSION["email"])){
    header("Location: ./home.php");
}else{
    header("Location: ./login.php");
}
