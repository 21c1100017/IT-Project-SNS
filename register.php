<?php

define("allow_access_config", true);
require_once("./config.php");

$error = [
    "csrf_token" => "",
    "user_name" => "",
    "password1" => "",
    "password2" => "",
    "email" => ""
];
$post_user_name = "";
$post_nick_name = "";
$post_email = "";

if(isset($_POST["user_name"]) and isset($_POST["nick_name"]) and isset($_POST["email"]) and isset($_POST["password1"]) and isset($_POST["password2"]) and isset($_POST["csrf_token"])){
    if($_POST["csrf_token"] !== $_SESSION["csrf_token"]){
        $error["csrf_token"] = "不正なトークンです。";
    }
    if(!preg_match("/^[a-z][a-z0-9]*$/i", $_POST["user_name"])){
        $error["user_name"] = "半角英数字のみ使用できます。(先頭数字不可)";
    }
    if(is_user_id_exists($_POST["user_name"])){
        $error["user_name"] = "既に使用されているユーザーIDです。";
    }
    if(!preg_match("/^[a-z][a-z0-9]*$/i", $_POST["password1"])){
        $error["password1"] = "半角英数字のみ使用できます。(先頭数字不可)";
    }
    if($_POST["password1"] != $_POST["password2"]){
        $error["password2"] = "パスワードが一致しません。";
    }
    if(!$email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $error["email"] = "メールアドレスの形式が不正です。";
    }
    if(is_email_exists($_POST["email"])){
        $error["email"] = "既に登録されているメールアドレスです。";
    }
    if($error["csrf_token"] == "" && $error["user_name"] == "" && $error["password1"] == "" && $error["password2"] == "" && $error["email"] == ""){
        register_user($_POST["user_name"], $_POST["nick_name"], $_POST["password1"], $_POST["email"]);
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

$html = create_html("register.html", "ユーザー新規作成", [
    "<link rel=\"stylesheet\" href=\"./css/register.css\">"
], [
    "user_name" => htmlspecialchars($post_user_name, ENT_QUOTES, 'UTF-8'),
    "nick_name" => htmlspecialchars($post_nick_name, ENT_QUOTES, 'UTF-8'),
    "email" => htmlspecialchars($post_email, ENT_QUOTES, 'UTF-8'),
    "error_csrf_token" => $error["csrf_token"],
    "error_user_name" => $error["user_name"],
    "error_email" => $error["email"],
    "error_password1" => $error["password1"],
    "error_password2" => $error["password2"]
]);

print($html);
