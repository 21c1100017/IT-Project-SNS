<?php
# /db_connect.php

if(!defined("allow_access_db_connect")){
    header("Location: ./index.php");
}

$db = null; //代替案を考え中・・・

try{
    $db = new PDO(
        "mysql:dbname=it_project_sns;host=localhost",
        "21c1100017",
        "21c1100017",
        [
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
        ]
    );
}catch(\PDOException $e){
    $html = create_html("error_db.html", "DB接続エラー" , [], [
        "error" => $e->getMessage()
    ]);
    print($html);
    exit();
}

date_default_timezone_set("Asia/Tokyo");
