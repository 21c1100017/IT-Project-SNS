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
    if(!preg_match("/^[a-z][a-z0-9]*$/i", $_POST["user_name"])){
        $error["user_name"] = "半角英数字のみ使用できます。(先頭数字不可)";
    }
    if(userIdDuplicationCheck($_POST["user_name"])){
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
    if(emailDuplicationCheck($_POST["email"])){
        $error["email"] = "既に登録されているメールアドレスです。";
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
$html = str_replace("{{user_name}}", htmlspecialchars($post_user_name, ENT_QUOTES, 'UTF-8'), $html);
$html = str_replace("{{nick_name}}", htmlspecialchars($post_nick_name, ENT_QUOTES, 'UTF-8'), $html);
$html = str_replace("{{email}}", htmlspecialchars($post_email, ENT_QUOTES, 'UTF-8'), $html);
$html = str_replace("{{error_user_name}}", $error["user_name"], $html);
$html = str_replace("{{error_email}}", $error["email"], $html);
$html = str_replace("{{error_password1}}", $error["password1"], $html);
$html = str_replace("{{error_password2}}", $error["password2"], $html);
print($html);