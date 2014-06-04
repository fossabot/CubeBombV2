<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");

sendHeaders();

if (!isset($_POST["id"]) || 
    !isset($_POST["comment"]) ||
    !is_numeric($_POST["id"]) ||
    trim($_POST["comment"]) == ""){
    
    die("x");
}

$id = intval(trim($_POST["id"]));

// Need to prevent posting and use ban lookup later.

if (!itemExistsNotDeleted($id)){
    die("Item doesn't exist.");
}

if ($isLoggedIn){
    // Check if the user is posting too frequently
    if (getSingleValue("SELECT COUNT(`id`) FROM `public_items_comments` WHERE `userid` ='" . $user["id"] . "' AND `deleted` =0 AND `timestamp` > DATE_SUB(NOW(), INTERVAL 15 SECOND)") > 0){
        die("You're posting too fast. Please try again in a moment.");
    }
    
    
    // Post comment
    query("INSERT INTO `public_items_comments` (`userid`, `itemid`, `timestamp`, `message`, `deleted`) VALUES ('" . $user["id"] . "', '" . escape(intval(trim($id))) . "', now(), '" . escape(trim($_POST["comment"])) . "', '0');");
}

die("y");

?>