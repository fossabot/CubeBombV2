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

    function itemExistsNotDeleted($itemId){
        return getSingleValue("SELECT COUNT(`id`) FROM `public_items` WHERE `id` =" . escape(intval($itemId)) . " AND `deleted` =0 LIMIT 0, 1");
    }

    function isItemAuthor($userId, $itemId){
        return getSingleValue("SELECT COUNT(`id`) FROM `public_items` WHERE `id` =" . escape(intval($itemId)) . " AND `deleted` =0 AND `userid` ='" . escape(intval($userId)) . "' LIMIT 0, 1");
    }
    
    function getUsername($userId){
        return getSingleValue("SELECT `username` FROM `private_users` WHERE `id` =" . escape(intval($userId)) . " LIMIT 0, 1");
    }

    function forumExists($id, $permissions=0){
        return ((getSingleValue("SELECT COUNT(`id`) FROM `public_forums_sections` WHERE `deleted` = '0' AND `id` = '" . escape(intval($id)) . "' AND `minRank` <= '" . escape(intval($permissions)) . "'")) >= 1);
    }

    function isThreadDeleted($id){ 
        return (getSingleValue("SELECT COUNT(`id`) FROM `public_forums_threads` WHERE `deleted` = '1' AND `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    function threadExists($id){ 
        return (getSingleValue("SELECT COUNT(`id`) FROM `public_forums_threads` WHERE `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    function postExists($id){
        return (getSingleValue("SELECT COUNT(`id`) FROM `public_forums_posts` WHERE `deleted` = '0' AND `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    function messageExists($id){
        return (getSingleValue("SELECT COUNT(`id`) FROM `private_messages` WHERE `id` = '" . escape(intval($id)) . "'") >= 1);
    }

    function canAccessMessage($id, $userid){
        return (getSingleValue("SELECT COUNT(`id`) FROM `private_messages` WHERE `id` = '" . escape(intval($id)) . "' AND `receiverId` = '" . escape(intval($userid)) . "' AND `deleted` =0") >= 1);
    }

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