<?php
# /index.php

define("allow_access_config", true);
require_once("./config.php");

if(isset($_SESSION["user_data"])){
    header("Location: ./home/");
}else{
    header("Location: ./login/");
}
