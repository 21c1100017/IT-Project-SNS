<?php
# /config.php

$root = "/IT-Project-SNS/";

if(!defined("allow_access_config")){
    header("Location: ./index.php");
}

//ini_set('display_errors', 0);
session_start();
require_once(__DIR__ . "/functions.php");
require_once(__DIR__ . "/database.php");

$title = "簡単なSNS";
