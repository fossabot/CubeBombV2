<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");

sendHeaders();

if (!$isLoggedIn) die("x");

if (!isset($_GET["id"]) || !is_int(intval($_GET["id"])) || $_GET["id"] <= 0 || !canAccessMessage($_GET["id"], $user["id"])){
    die("x");
}
        
$message = getArray("SELECT * FROM `private_messages` WHERE `id` = '" . escape(intval($_GET["id"])) . "' AND `receiverId` = '" . $user["id"] . "' AND `deleted` =0");

$message["username"] = getUsername($message["senderid"]);

die(json_encode($message));
?>
