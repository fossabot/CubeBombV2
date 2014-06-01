<?php
require_once("/var/www/secure/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/functions.php");

function sendHeaders(){
    header("Content-type: text/plain");
    header("Cache-Control: no-cache, must-revalidate");
}

// Tests to see if the string provided fits the length requirements of the password field.
function isValidPassword($password){
    if (strlen(trim($password)) < 8){
        return false;
    }else if (strlen(trim($password)) > 64){
        return false;
    }
    
    return true;
}

// These two functions from http://stackoverflow.com/a/327206
// Used for URL transfers
function encrypt($str){	
    $key = "encryption key -- not very critical";
    for($i = 0; $i < strlen($str); $i++) {
        $char = substr($str, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result .= $char;
    }
    return urlencode(base64_encode($result));
}
function decrypt($str){
    $str = base64_decode(urldecode($str));
    $result = '';
    $key = "encryption key -- not very critical";
    for($i = 0; $i < strlen($str); $i++) {
        $char = substr($str, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }
    return $result;
}
?>