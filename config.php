<?php

if(!defined("allow_access_config")){
    header("Location: ./index.php");
}

//ini_set('display_errors', 0);
session_start();
define("allow_access_db_init", true);
require_once("./db_init.php");

$title = "簡単なSNS";

function create_html(string $file_name, string $sub_title = "", array $heads = [], array $blocks = []) : string {

    global $title;
    $base = file_get_contents("./template/base.html");
    $html = file_get_contents("./template/" . $file_name);
    $html = str_replace("{{content}}", $html, $base);
    $head_html = "";
    $sub_title = "";

    if($sub_title != ""){
        $sub_title = $sub_title . " | ";
    }

    $html = str_replace("{{title}}", $sub_title . $title, $html);

    foreach($heads as $head){
        $head_html = $head_html . $head;
    }

    $html = str_replace("{{head}}", $head_html, $html);

    foreach($blocks as $block_name => $block_content){
        $html = str_replace("{{" . $block_name . "}}", $block_content, $html);
    }

    if(strpos($html, "{{csrf_token}}") != false){
        $html = str_replace("{{csrf_token}}", "<input type=\"hidden\" name=\"csrf_token\" value=" . generate_csrf_token() . ">", $html);
    }

    return $html;

}

function create_postbox(string $filename, array $blocks) : string {
    $html = file_get_contents("./template/".$filename);
    foreach($blocks as $block_name => $block_value){
        if($block_name == "title" || $block_name == "head"){
            continue;
        }
        $html = str_replace("{{" . $block_name . "}}", $block_value, $html);
    }
    return $html;
}

function generate_csrf_token() : string {
    $token_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($token_byte);
    $_SESSION["csrf_token"] = $csrf_token;
    return $csrf_token;
}
