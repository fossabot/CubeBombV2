<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");

sendHeaders();

if (!$isLoggedIn) die("Error :(");

if (!isset($_POST["id"]) || !is_int(intval($_POST["id"])) || $_POST["id"] <= 0 || !postExists($_POST["id"])){
    die("x");
}

if ($user["cubes"] < 5){
    die("x");
}

if (getSingleValue("SELECT 1 FROM `public_forums_donations` WHERE `postid` ='" . escape(intval($_POST["id"])) . "' AND `userid` ='" . $user["id"] . "'") == 1){
    die("x");
}

// Get id of the poster
$poster = getSingleValue("SELECT `userid` FROM `public_forums_posts` WHERE `id` = '" . escape(intval($_POST["id"])) . "'"); 

if ($poster == $user["id"]){ die("x"); }

// Transfer cubes and insert donation info
query("UPDATE `private_users` SET `cubes` = cubes-5 WHERE `id` = '" . $user["id"] . "';");
query("UPDATE `private_users` SET `cubes` = cubes+5 WHERE `id` = '" . $poster . "';");
query("INSERT INTO `public_forums_donations` (`postid`, `userid`, `quantity`, `timestamp`)
VALUES ('" . escape(intval($_POST["id"])) . "', '" . $user["id"] . "', '5', now());");


die("y");
?>
