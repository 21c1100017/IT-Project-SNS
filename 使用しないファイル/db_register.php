<?php

require_once("./config.php");

$hashed_password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
$time = date("Y-m-d H:i:s");

try{
    $stmt = $db->prepare(
                "INSERT INTO `users` (`user_id`, `user_name`, `user_nick_name`, `encrypted_password`, `email`, `profile_icon_path`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, NULL, ?, ?)"
    );
    $stmt->execute([
        $_POST["username"],
        $_POST["nickname"],
        $hashed_password,
        $email,
        $time,
        $time
    ]);
    header("Location: ./register_success.php");
    exit;
}catch(\Exception $e){
    echo $e->getMessage();
    exit;
}
