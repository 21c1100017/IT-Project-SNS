<?php

if(!defined("allow_access_db_functions")){
    header("Location: ./index.php");
}

# 通常ログイン処理
# 返り値
#   成功: ユーザー情報
#   失敗: False
function login(string $user_name, string $password) {
    global $db; //代替案を考え中・・・
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
function register_user(string $user_name, string $nick_name, string $password, string $email) {
    global $db; //代替案を考え中・・・
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $time = date("Y-m-d H:i:s");
    try{
        $stmt = $db->prepare(
            "INSERT INTO `users` (`user_name`, `user_nick_name`, `encrypted_password`, `email`) VALUES (:user_name, :user_nick_name, :encrypted_password, :email);"
        );
        $stmt->execute([
            ":user_name" => $user_name,
            ":user_nick_name" => $nick_name,
            ":encrypted_password" => $hashed_password,
            ":email" => $email
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
    global $db; //代替案を考え中・・・
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
    global $db; //代替案を考え中・・・
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

# エラーログを追加します。
# 返り値
#   成功: True
#   失敗: False
function register_error(string $error_msg) : bool {
    global $db; //代替案を考え中・・・
    try{
        $stmt = $db->prepare("INSERT INTO `error_logs` (`error_message`) VALUES (:error_message)");
        $stmt->execute([":error_message" => $error_msg]);
    }catch(\PDOException $e){
        return false;
    }
    return true;
}

# タイムラインを取得します。
function get_timeline(int $amount){
    global $db; //代替案を考え中・・・
    try{
        $stmt = $db->prepare(
            "SELECT * FROM `posts` ORDER BY `created_at` DESC LIMIT :amount;"
        );
        $stmt->bindValue(":amount", $amount, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(\PDOEXception $e){
        echo $e->getMessage() . PHP_EOL;
        exit;
    }
    return $row;
}

function get_user_from_id(int $user_id){
    global $db; //代替案を考え中・・・
    try{
        $stmt = $db->prepare(
            "SELECT * FROM `users` WHERE `user_id` = :user_id"
        );
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(\PDOEXception $e){
        echo $e->getMessage() . PHP_EOL;
        return false;
    }
    return $row;
}
