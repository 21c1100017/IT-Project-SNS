<?php

require_once("db_connect.php");

try{
    $stmt = $db->prepare("SELECT * FROM `users` WHERE `email` LIKE ?");
    $stmt->execute([$_POST["email"]]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(\Exception $e){
    echo $e->getMessage() . PHP_EOL;
}

if(isset($row["email"])){
    if(password_verify($_POST["password"], $row["encrypted_password"])){
        session_regenerate_id(true);
        $_SESSION["email"] = $row["email"];
        header("Location: ./home.php");
        exit;
    }else{
        $error_login = "メールアドレス又はパスワードが間違っています";
    }
}else{
    $error_login = "メールアドレス又はパスワードが間違っています";
}

$db = null;

?>