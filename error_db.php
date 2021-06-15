<?php
require_once("./config.php");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB接続エラー | 簡単なSNS</title>
</head>
<body>
    <p>DBに接続できませんでした。</p>
    <p>エラー内容:
        <?php echo $_GET["error"]; ?>
    </p>
</body>
</html>