<?php

define("allow_access_config", true);
require_once("./config.php");

if(!isset($_SESSION["user_data"])){
    header("Location: ./login.php");
    exit;
}

$timeline = "";

foreach(get_timeline(10) as $data){
    $user = get_user_from_id($data["user_id"]);
    if($user["profile_icon_path"] == NULL){
        $icon_path = "https://pics.prcm.jp/654b637d854c5/84936407/png/84936407.png";
    }else{
        $icon_path = $user["profile_icon_path"];
    }
    $timeline = $timeline . create_html("post_box.html", [
        "title" => "",
        "head" => "",
        "icon_path" => $icon_path,
        "nick_name" => $user["user_nick_name"],
        "user_name" => $user["user_name"],
        "created_at" => $data["created_at"],
        "content" => $data["post_content"]
    ]);
}

$html = create_html("home.html", [
    "title" => "ホーム",
    "head" => "<link rel=\"stylesheet\" href=\"./css/home.css\">",
    "user_nick_name" => htmlspecialchars($_SESSION["user_data"]["user_nick_name"], ENT_QUOTES, 'UTF-8'),
    "timeline" => $timeline
]);

print($html);
