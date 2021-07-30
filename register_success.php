<?php

require_once("./config.php");

$html = CreateHTML("register_success.html", [
    "title" => "ユーザー作成完了",
    "head" => ""
]);

print($html);
