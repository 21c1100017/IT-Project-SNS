<?php

define("allow_access_config", true);
require_once("./config.php");

if(isset($_SESSION["user_data"])){
    header("Location: ./home.php");
}else{
    header("Location: ./login.php");
}
