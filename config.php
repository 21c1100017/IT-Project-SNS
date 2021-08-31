<?php

if(!defined("allow_access_config")){
    header("Location: ./index.php");
}

//ini_set('display_errors', 0);
session_start();
define("allow_access_db_init", true);
require_once("./db_init.php");

$main_title = "簡単なSNS";

function create_html(string $filename, array $blocks) : string {

    global $main_title;
    $layout = file_get_contents("./template/layout.html");
    $html = file_get_contents("./template/".$filename);
    $html = str_replace("{{content}}", $html, $layout);

    if(isset($blocks["title"])){
        if($blocks["title"] == ""){
            $title = $main_title;
        }else{
            $title = $main_title." | ".$blocks["title"];
        }
        $html = str_replace("{{title}}", $title, $html);
    }

    if(isset($blocks["head"])){
        $html = str_replace("{{head}}", $blocks["head"], $html);
    }

    $html = str_replace("{{main_title}}", $main_title, $html);

    foreach($blocks as $block_name => $block_value){
        if($block_name == "title" || $block_name == "head"){
            continue;
        }
        $html = str_replace("{{".$block_name."}}", $block_value, $html);
    }

    if(strpos($html, "{{csrf_token}}") != false){
        $html = str_replace("{{csrf_token}}", "<input type=\"hidden\" name=\"csrf_token\" value=".generate_csrf_token().">", $html);
    }

    return $html;

}

function generate_csrf_token() : string {
    $token_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($token_byte);
    $_SESSION["csrf_token"] = $csrf_token;
    return $csrf_token;
}
