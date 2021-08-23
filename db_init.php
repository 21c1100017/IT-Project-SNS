<?php

if(!defined("allow_access_db_init")){
    header("Location: ./index.php");
}

$db = null;

try{
    $db = new PDO(
        "mysql:dbname=it_project_sns;host=localhost",
        "21c1100017",
        "21c1100017"
    );
}catch(PDOException $e){
    header("Location: ./error_db.php?error=".$e->getMessage());
    exit();
}

date_default_timezone_set("Asia/Tokyo");

# 通常ログイン処理
# 返り値
#   成功: ユーザー情報
#   失敗: False
function login(string $user_name, string $password) {
    global $db;
    try{
        $stmt = $db->prepare("SELECT * FROM `users` WHERE `user_name` LIKE ?");
        $stmt->execute([$user_name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(\Exception $e){
        echo $e->getMessage() . PHP_EOL;
        exit;
    }
    if(!isset($row["user_nick_name"])){
        return false;
    }
    if(!password_verify($password, $row["encrypted_password"])){
        return false;
    }
    return $row;
}

# 新規ユーザーを登録します。
# 返り値
#   成功した: True
#   失敗した: String(エラーメッセージ)
function register(string $user_name, string $nick_name, string $password, string $email) {
    global $db;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $time = date("Y-m-d H:i:s");
    try{
        $stmt = $db->prepare(
            "INSERT INTO `users` (`user_id`, `user_name`, `user_nick_name`, `encrypted_password`, `email`, `profile_icon_path`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, NULL, ?, ?);"
        );
        $stmt->execute([
            $user_name,
            $nick_name,
            $hashed_password,
            $email,
            $time,
            $time
        ]);
    }catch(\PDOException $e){
        return $e->getMessage();
    }
    return true;
}

# ユーザー名が存在するかチェックをします。
# 返り値
#   存在する: True
#   存在しない: False
function is_user_id_exists(string $name) {
    global $db;
    try{
        $stmt = $db->prepare("SELECT `user_name` FROM `users` WHERE `user_name` LIKE ?");
        $stmt->execute([$name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(\Exception $e){
        echo $e->getMessage() . PHP_EOL;
        exit;
    }
    return isset($row["user_name"]);
}

# メールアドレスの存在チェックをします。
# 返り値
#   存在する: True
#   存在しない: False
function is_email_exists(string $email) {
    global $db;
    try{
        $stmt = $db->prepare("SELECT `email` FROM `users` WHERE `email` LIKE ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(\Exception $e){
        echo $e->getMessage() . PHP_EOL;
        exit;
    }
    return isset($row["email"]);
}
