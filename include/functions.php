<?php
    require_once("/var/www/secure/db.php");

	function getUserPermissions($userId) {
        return getSingleValue("SELECT `permissions` FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " LIMIT 0, 1"); 
    }

    function userExists($userId) {
        return getSingleValue("SELECT COUNT(`id`) FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " LIMIT 0, 1");
    }

    function userExistsNotDeleted($userId) {
        return getSingleValue("SELECT COUNT(`id`) FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " AND `deleted` =0 LIMIT 0, 1");
    }

    function userDeleted($userId) {
        return getSingleValue("SELECT COUNT(`id`) FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " AND `deleted` =1 LIMIT 0, 1");
    }

    function getToken($username, $password) {
        global $salt1, $salt2;
        
        return getSingleValue("SELECT `cookie` FROM `private_users` WHERE LOWER(`username`) =LOWER('" . escape(trim($username)) . "') AND `firetruck` =MD5(CONCAT('$salt1', '" . escape($password) . "', '$salt2')) LIMIT 0, 1");
    }
?>