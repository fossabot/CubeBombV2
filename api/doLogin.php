<?php
require($_SERVER["DOCUMENT_ROOT"] . "/api/api.php");

sendHeaders();

if (!isset($_POST["username"]) || 
    !isset($_POST["password"]) || 
    strlen(trim($_POST["username"])) <= 2 || 
    strlen(trim($_POST["password"])) == 0){
    
    die("x");
}

// Non-alphanumeric characters are fine for logging in old accounts.
// New accounts cannot register with non-alphas.

$token = getToken($_POST["username"], $_POST["password"]);

if ($token != ""){
    die("@setcookie! " . $token);
}else{
    die("Incorrect password.");
}
?>