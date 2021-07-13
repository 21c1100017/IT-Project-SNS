<?php

require_once("./config.php");

$error = [
    "user_name" => "",
    "password1" => "",
    "password2" => "",
    "email" => ""
];
$post_user_name = "";
$post_nick_name = "";
$post_email = "";

if(isset($_POST["user_name"]) and isset($_POST["nick_name"]) and isset($_POST["email"]) and isset($_POST["password1"]) and isset($_POST["password2"])){
    if(!preg_match("/^[a-z][a-z0-9_]*$/i", $_POST["user_name"])){
        $error["user_name"] = "使用できる文字は、アルファベット・数字・アンダーバー(先頭使用不可)のみです。";
    }
    if(!preg_match("/^[a-z][a-z0-9_]*$/i", $_POST["password1"])){
        $error["password1"] = "使用できる文字は、アルファベット・数字・アンダーバー(先頭使用不可)のみです。";
    }
    if($_POST["password1"] != $_POST["password2"]){
        $error["password2"] = "パスワードが一致しません。";
    }
    if(!$email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $error["email"] = "メールアドレスの形式が不正です。";
    }
    if($error["user_name"] == "" && $error["password1"] == "" && $error["password2"] == "" && $error["email"] == ""){
        register($_POST["user_name"], $_POST["nick_name"], $_POST["password1"], $_POST["email"]);
        header("Location: ./register_success.php");
        exit;
    }
}

if(isset($_POST["user_name"])){
    $post_user_name = $_POST["user_name"];
}
if(isset($_POST["nick_name"])){
    $post_nick_name = $_POST["nick_name"];
}
if(isset($_POST["email"])){
    $post_email = $_POST["email"];
}

$html = file_get_contents("template/register.html");
$html = str_replace("{{user_name}}", $post_user_name, $html);
$html = str_replace("{{nick_name}}", $post_nick_name, $html);
$html = str_replace("{{email}}", $post_email, $html);
$html = str_replace("{{error_email}}", $error["email"], $html);
$html = str_replace("{{error_password1}}", $error["password1"], $html);
$html = str_replace("{{error_password2}}", $error["password2"], $html);
print($html);