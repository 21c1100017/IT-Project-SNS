<?php

try{
    $db = new PDO(
        "mysql:dbname=it_project_sns;host=melon-jp.net",
        "21c1100017",
        "21c1100017"
    );
}catch(PDOException $e){
    header("Location: ./error_db.php?error=".$e->getMessage());
    exit();
}

?>