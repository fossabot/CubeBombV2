<?php
    // Useful functions for CubeBomb development
    require_once("/var/www/secure/db.php");

    // Get permissions number for specified user id
	function getUserPermissions($userId) {
        return getSingleValue("SELECT `permissions` FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " LIMIT 0, 1");
    }

    // Determine whether user exists with the given id. Does not discriminate between deleted users.
    function userExists($userId) {
        return getSingleValue("SELECT COUNT(`id`) FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " LIMIT 0, 1");
    }

    // Determine whether user with given id exists and is not deleted
    function userExistsNotDeleted($userId) {
        return getSingleValue("SELECT COUNT(`id`) FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " AND `deleted` =0 LIMIT 0, 1");
    }

    // Determine whether user with given id is deleted (May return 0 for nonexistent users)
    function userDeleted($userId) {
        return getSingleValue("SELECT COUNT(`id`) FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " AND `deleted` =1 LIMIT 0, 1");
    }

    // Get cookie for user with given username and password
    function getToken($username, $password) {
        // Make sure global salts are accessable
        global $salt1, $salt2;

        return getSingleValue("SELECT `cookie` FROM `private_users` WHERE LOWER(`username`) =LOWER('" . escape(trim($username)) . "') AND `firetruck` =MD5(CONCAT('$salt1', '" . escape($password) . "', '$salt2')) LIMIT 0, 1");
    }

    // Determine whether item with given id exists and is not deleted
    function itemExistsNotDeleted($itemId){
        return getSingleValue("SELECT COUNT(`id`) FROM `public_items` WHERE `id` =" . escape(intval($itemId)) . " AND `deleted` =0 LIMIT 0, 1");
    }

    // Determine whether user with the given id is the author of the given item
    function isItemAuthor($userId, $itemId){
        return getSingleValue("SELECT COUNT(`id`) FROM `public_items` WHERE `id` =" . escape(intval($itemId)) . " AND `userid` ='" . escape(intval($userId)) . "' LIMIT 0, 1");
    }

    // Get the username of a user given their id
    function getUsername($userId){
        return getSingleValue("SELECT `username` FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " LIMIT 0, 1");
    }

    // Determines whether forum exists for a certain user (with the second and optional permissions argument, which is 0 by default for normal users)
    function forumExists($id, $permissions=0){
        return ((getSingleValue("SELECT COUNT(`id`) FROM `public_forums_sections` WHERE `deleted` = '0' AND `id` = '" . escape(intval($id)) . "' AND `minRank` <= '" . escape(intval($permissions)) . "'")) >= 1);
    }

    // Determine whether a thread is deleted or not given its id
    function isThreadDeleted($id){
        return (getSingleValue("SELECT COUNT(`id`) FROM `public_forums_threads` WHERE `deleted` = '1' AND `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    // Determine whether a thread exists, even if it is deleted
    function threadExists($id){
        return (getSingleValue("SELECT COUNT(`id`) FROM `public_forums_threads` WHERE `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    // Determine whether a post exists and is not deleted, given id
    function postExists($id){
        return (getSingleValue("SELECT COUNT(`id`) FROM `public_forums_posts` WHERE `deleted` = '0' AND `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    // Determine whether PM exists given id, even if it is deleted
    function messageExists($id){
        return (getSingleValue("SELECT COUNT(`id`) FROM `private_messages` WHERE `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    // Determine whether user can read a message (the user can't if they are not the recipient or if it is deleted)
    function canAccessMessage($id, $userid){
        return (getSingleValue("SELECT COUNT(`id`) FROM `private_messages` WHERE `id` = '" . escape(intval($id)) . "' AND `receiverId` = '" . escape(intval($userid)) . "' AND `deleted` =0") >= 1);
    }

    // Parse cbbbc 
    function cbbbc($text){
        $find = array('["', '"]', '[&quot;', '&quot;]', "[i]", "[/i]", "[b]", "[/b]", "[bold]", "[/bold]", "[italic]", "[/italic]", "[red]", "[purple]", "[green]", "[black]", "[yellow]", "[pink]", "[orange]", "[blue]", "[/color]", "[under]", "[/under]", "[u]", "[/u]");
        $replace = array("<blockquote>", "</blockquote>", "<blockquote>", "</blockquote>", "<em>", "</em>", "<strong>", "</strong>", "<strong>", "</strong>", "<em>", "</em>");

        return str_replace($find, $replace, $text);
    }


    // http://css-tricks.com/snippets/php/time-ago-function/
    function ago($time) {
        $time = strtotime($time);

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $now = time();

        $difference     = $now - $time;
        $tense          = "ago";

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j]";
    }

?>
