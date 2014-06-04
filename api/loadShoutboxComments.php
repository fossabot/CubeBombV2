<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");

sendHeaders();

if (!isset($_POST["id"]) || 
    !is_numeric($_POST["id"])){
    
    die("x");
}

$id = intval(trim($_POST["id"]));

$start = 0;
$qbuilder = "";

if (isset($_POST["start"]) && is_numeric($_POST["start"]) && $_POST["start"] != 0){
    $start = intval(trim($_POST["start"]));
    $qbuilder = "AND `id` < '$start'";
}

$response = query("SELECT * FROM `public_users_profiles_shoutboxes` WHERE `profile` ='" . escape($id) . "' AND `deleted` =0 $qbuilder ORDER BY `id` DESC LIMIT 0, 15");

$json = array();

$i = 0;
while ($row = fetchRows($response)){
    $row["name"] = getUsername($row["userid"]);
    $row["message"] = nl2br($row["message"]);
    $row["ago"] = ago($row["timestamp"]). " ago";
    
    if ($isLoggedIn){
        $row["colored"] = ($row["userid"] == $id);
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
    
    $remaining = getSingleValue("SELECT COUNT(`id`) FROM `public_users_profiles_shoutboxes` WHERE `profile` ='" . escape($id) . "' AND `deleted` =0 AND `id` < '$final' ORDER BY `id` DESC LIMIT 0, 1");
    if ($remaining >= 1){
        $more = true;
    }
    
    $json = array_merge(array(array("more" => $more)), $json);
}

//var_dump($json);

die(json_encode($json));

?>