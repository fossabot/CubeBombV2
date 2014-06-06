<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");

sendHeaders();

if (!isset($_POST["id"]) ||
    !is_numeric($_POST["id"])){

    die("x");
}

if (!isset($_POST["page"]) ||
    !is_numeric($_POST["page"]) ||
    intval($_POST["page"]) < 0){

    $page = 0;
}else{
    $page = intval($_POST["page"]);
}

$id = intval(trim($_POST["id"]));

$start = 0;
$qbuilder = "";

$pageSize = 11;

$maxPages = ceil(getSingleValue("SELECT COUNT(`id`) FROM `private_friends` WHERE `userid` ='" . escape($id) . "' AND `deleted` ='0'")/$pageSize);
if ($page > $maxPages) $page = $maxPages;
if ($page < 0) $page = 0;

if ($maxPages == 0) die("none");

$min = $pageSize*($page-1);

$friends = query("SELECT * FROM `private_friends` A
INNER JOIN (SELECT `username`, `id` FROM `private_users`) B ON (A.`friendid` = B.`id`)
WHERE A.`userid` ='" . escape($id) . "' AND A.`deleted` ='0' LIMIT $min, $pageSize");

$json = array();
$stats = array("pages" => $maxPages, "page" => $page)

$i = 0;
while ($row = fetchRows($friends)){
    $row["name"] = getUsername($row["userid"]);
    $row["message"] = nl2br($row["message"]);
    $row["ago"] = ago($row["timestamp"]). " ago";

    if ($isLoggedIn){
        $row["colored"] = (isItemAuthor($row["userid"], $id));
    }else{
        $row["colored"] = false;
    }

    $json[$i] = $row;

    $i++;
}

// Determine if there are more comments
if (!empty($json)){
    $more = false;

    $final = end($json)["id"];

    $remaining = getSingleValue("SELECT COUNT(`id`) FROM `public_items_comments` WHERE `itemid` ='" . escape($id) . "' AND `deleted` =0 AND `id` < '$final' ORDER BY `id` DESC LIMIT 0, 1");
    if ($remaining >= 1){
        $more = true;
    }

    $json = array_merge(array(array("more" => $more)), $json);
}

//var_dump($json);

die(json_encode($json));

?>
