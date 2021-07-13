<?php

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
# 成功: rowデータ
# 失敗: false
function login(string $username, string $password) : bool {
    global $db;
    try{
        $stmt = $db->prepare("SELECT * FROM `users` WHERE `user_name` LIKE ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(\Exception $e){
        echo $e->getMessage() . PHP_EOL;
        exit;
    }
    if(!isset($row["user_name"])){
        return false;
    }
    if(!password_verify($password, $row["encrypted_password"])){
        return false;
    }
    return $row;
}

# 新規ユーザーを登録します。
function register(string $user_name, string $nick_name, string $password, string $email) : void {
    global $db;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $time = date("Y-m-d H:i:s");
    try{
        $stmt = $db->prepare(
            "INSERT INTO `users` (`user_id`, `user_name`, `user_nick_name`, `encrypted_password`, `email`, `profile_icon_path`, `created_at`, `updated_at`) VALUES (NULL, ?, ?, ?, ?, NULL, ?, ?)"
        );
        $stmt->execute([
            $user_name,
            $nick_name,
            $hashed_password,
            $email,
            $time,
            $time
        ]);
    }catch(\Exception $e){
        echo $e->getMessage();
        exit;
    }
}

# ユーザー名が重複したときにtrueを返します。
function usernameDuplicationCheck(string $name) : bool {
    global $db;
    try{
        $stmt = $db->prepare("SELECT `user_name` FROM `users` WHERE `user_name` LIKE ?");
        $stmt->execute([$name]);
        $row = $stmt->fetch(POD::FETCH_ASSOC);
    }catch(\Exception $e){
        echo $e->getMessage() . PHP_EOL;
        exit;
    }

    var_dump($row);
    exit;
}
