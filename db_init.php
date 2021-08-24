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

try{
    $db->query("CREATE TABLE IF NOT EXISTS `comments` (
        `comment_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
        `post_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL,
        `user_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL,
        `coment_content` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
        `created_at` DATETIME NOT NULL,
        `deleted_at` DATETIME NOT NULL,
        PRIMARY KEY (`comment_id`) USING BTREE
        )
        COLLATE='utf8mb4_general_ci'
        ENGINE=InnoDB;"
    );
    $db->query("CREATE TABLE IF NOT EXISTS `error_logs` (
        `id` INT(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
        `error_message` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
        `created_at` DATETIME NOT NULL,
        PRIMARY KEY (`id`) USING BTREE
        )
        COLLATE='utf8mb4_general_ci'
        ENGINE=InnoDB;"
    );
    $db->query("CREATE TABLE IF NOT EXISTS `posts` (
        `post_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
        `user_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL,
        `post_content` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
        `created_at` DATETIME NOT NULL,
        `deleted_at` DATETIME NULL DEFAULT NULL,
        PRIMARY KEY (`post_id`) USING BTREE
        )
        COLLATE='utf8mb4_general_ci'
        ENGINE=InnoDB;"
    );
    $db->query("CREATE TABLE IF NOT EXISTS `users` (
        `user_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
        `user_name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
        `user_nick_name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
        `encrypted_password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
        `email` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
        `profile_icon_path` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
        `created_at` DATETIME NOT NULL,
        `updated_at` DATETIME NOT NULL,
        PRIMARY KEY (`user_id`) USING BTREE,
        UNIQUE INDEX `UNIQUE` (`user_name`, `email`, `profile_icon_path`) USING BTREE
        )
        COLLATE='utf8mb4_general_ci'
        ENGINE=InnoDB;");
}catch(\PDOException $e){

}

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
function register_user(string $user_name, string $nick_name, string $password, string $email) {
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

# エラーログを追加します。
# 返り値
#   成功: True
#   失敗: False
function register_error(string $error_msg) : bool {
    global $db;
    $time = date("Y-m-d H:i:s");
    try{
        $stmt = $db->prepare("INSERT INTO `error_logs` (`error_message`, `created_at`) VALUES (?, ?)");
        $stmt->execute([$error_msg, $time]);
    }catch(\PDOException $e){
        return false;
    }
    return true;
}
