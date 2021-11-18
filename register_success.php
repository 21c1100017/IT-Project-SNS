<?php

define("allow_access_config", true);
require_once("./config.php");

$html = create_html("register_success.html", "ユーザー作成完了");
print($html);
