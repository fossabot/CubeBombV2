<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");

sendHeaders();

if (!$isLoggedIn) die("Error :(");

if (!isset($_POST["id"]) || !is_int(intval($_POST["id"])) || $_POST["id"] <= 0 || !postExists($_POST["id"])){
    die("Error :(");
}

if ($user["cubes"] < 5){
    die("Insufficient funds");
}

if (getSingleValue("SELECT 1 FROM `public_forums_donations` WHERE `postid` ='" . escape(intval($_POST["id"])) . "' AND `userid` ='" . $user["id"] . "'") == 1){
    die("You've already donated");
}

die("Give 5 Cubes?");

?>
