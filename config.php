<?php
# /config.php

$root = "/IT-Project-SNS/";

if(!defined("allow_access_config")){
    header("Location: ./index.php");
}

//ini_set('display_errors', 0);
session_start();
define("allow_access_functions", true);
require_once(__DIR__ . "/functions.php");
define("allow_access_db_connect", true);
require_once(__DIR__ . "/db_connect.php");

$title = "簡単なSNS";
