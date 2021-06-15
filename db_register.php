<?php

require_once("./config.php");
require_once("db_connect.php");
date_default_timezone_set("Asia/Tokyo");

$hashed_password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
$time = date("Y-m-d H:i:s");

try{
    $stmt = $db->prepare(
                "INSERT INTO `users` (`user_id`, `user_name`, `encrypted_password`, `email`, `profile_icon_path`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, NULL, ?, ?)"
    );
    $stmt->execute([
        $_POST["username"],
        $hashed_password,
        $email,
        $time,
        $time
    ]);
    header("Location: ./register_success.php");
    exit;
}catch(\Exception $e){
    $error_email = "このメールアドレスは既に使われています。";
}

$db = null;

?>