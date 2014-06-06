<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");

sendHeaders();

if (!$isLoggedIn) die("x");

$start = 0;
$qbuilder = "";

if (isset($_POST["start"]) && is_numeric($_POST["start"]) && $_POST["start"] != 0){
    $start = intval(trim($_POST["start"]));
    $qbuilder = "AND `id` < '$start'";
}

$response = query("SELECT `id`,`senderId`,`system`,`timestamp`,`seen`,`subject` FROM `private_messages` WHERE `receiverId` ='" . $user["id"] . "' AND `deleted` =0 $qbuilder ORDER BY `id` DESC LIMIT 0, 20");

$json = array();

$i = 0;
while ($row = fetchRows($response)){
    $row["name"] = getUsername($row["senderId"]);
    $row["subject"] = htmlspecialchars($row["subject"]);
    $row["ago"] = ago($row["timestamp"]). " ago";
    $row["system"] = ($row["system"] == 1);

    $json[$i] = $row;

    $i++;
}

// Determine if there are more comments
if (!empty($json)){
    $more = false;

    $final = end($json)["id"];

    $remaining = getSingleValue("SELECT COUNT(`id`) FROM `private_messages` WHERE `receiverId` ='" . $user["id"] . "' AND `deleted` =0 AND `id` < '$final' ORDER BY `id` DESC LIMIT 0, 1");
    if ($remaining >= 1){
        $more = true;
    }

    $json = array_merge(array(array("more" => $more)), $json);
}

//var_dump($json);

die(json_encode($json));

?>
