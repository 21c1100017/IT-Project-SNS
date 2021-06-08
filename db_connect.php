<?php

try{
    $db = new PDO(
        "mysql:dbname=it_project_sns;host=melon-jp.net",
        "21c1100017",
        "21c1100017"
    );
    $db_connecting = true;
}catch(PDOException $e){
    print("Error: " . $e->getMessage());
    $db_connecting = false;
    die();
}

?>