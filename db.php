<?php 
$link = mysqli_connect("localhost", "cbdbuser", "Typ5mmRx7PUKwUwd", "cubebomb2");

if (mysqli_connect_errno()){
    die("Database connection error.");
}

// Make sure the database connection is in utf8 or data could become corrupt between server and client.
mysqli_set_charset($link, "utf8");

function query($query){
    global $link;
    
    return mysqli_query($link, $query);
    
    // For debug purposes. Should not be enabled on production.
    //die(mysqli_error($link));
}

function queryGetId($query){
    global $link;
    
    mysqli_query($link, $query);
    return mysqli_insert_id($link);
}

function getArray($query){
    global $link;

    $result = mysqli_query($link, $query);
    return mysqli_fetch_assoc($result);
}

function fetchRows($result){
    global $link;
    
    return mysqli_fetch_assoc($result);
}

function getSingleValue($query){
    global $link;

    $result = mysqli_query($link, $query);
    $array = mysqli_fetch_row($result);
    return $array[0];
}

function escape($string){
    global $link;

    return mysqli_real_escape_string($link, $string);
}

function dbError(){
    global $link;
    
    return mysqli_error($link);
}

// Salts used for account password hashing. Do not change these.
// Changes will invalidate all passwords and lock everybody out of their accounts.
// DO NOT CHANGE!
$salt1 = "HJ^TNRCybbDRB N&R^UYGTffrfn%^FN56fm5 rFr76fh";
$salt2 = "&*T^H N68ht5tr%^th56rnR %^BR76WEe rtf6io7";
?>
