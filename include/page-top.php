<?php
    // All includes are done previously on the pages themselves through page-utils.php

    if (!isset($pageScript)){
        $pageScript = "";
    }
    if (!isset($additionalScripts)){
        $additionalScripts = "";
    }
    if (!isset($pageCss)){
        $pageCss = "";
    }
    if (!isset($additionalCss)){
        $additionalCss = "";
    }
    if (!isset($public)){
        $public = true;
    }
    if (!isset($publicOnly)){
        $publicOnly = false;
    }
    if (!isset($breadcrumb)){
        $breadcrumb = false;
    }
    
    if (!$isLoggedIn){
        header("Location:/");
        exit;
    }

    // Start compressing output
    //ob_start("ob_gzhandler");
?>
<!doctype html>
<html>
    <head>
        <script src="/js/analytics.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="/js/jquery.color-2.1.2.min.js"></script>
        <script src="/js/jquery.tipsy.js"></script>
        <script src="/js/page.js"></script>
        <?php 
            if ($pageScript != "") { 
        ?>
        <script src="<?php echo $pageScript; ?>"></script>
        <?php 
            }

            if ($additionalScripts) {
                echo $additionalScripts;
            }
        ?>
        
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <?php 
            if ($pageCss != "") { 
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $pageCss; ?>">
        <?php 
            }

            if ($additionalCss) {
                echo $additionalCss;
            }
        ?>
        <!--<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>-->
        
        <title><?php echo htmlspecialchars($title); ?> | CubeBomb</title>
    </head>
    
    <body>
        <div id="logo"></div>
        <div id="wrapper">
            <div id="nav" class="shadow">
                <div class="account">
                    <?php 
                    if ($isLoggedIn){
                        echo htmlspecialchars($user["username"]);
                    }else{
                        echo "";
                    }?>
                </div>
                <?php 
                    if ($isLoggedIn){
                        echo "<a href=\"/profile.php?id=" . $user["id"] . "\">Profile</a>";
                    }
                ?>
                <a href="/shop.php">Shop</a>
                <a href="/members.php">Members</a>
                <a href="#">Forum</a>
                <a href="#">Dropoff</a>
                <a href="#">Help</a>
                <div class="time" title="CubeBomb Time is UTC"><?php echo date("H:i"); ?></div>
                <?php if ($isLoggedIn){ ?>
                <a href="#" style="float: right;">Log out</a>
                <?php } ?>
            </div>
            <div id="sidebar" class="shadow">
                <?php 
                    if ($isLoggedIn){
                        include($_SERVER["DOCUMENT_ROOT"] . "/include/sidebar/default.php");
                    }else{
                        include($_SERVER["DOCUMENT_ROOT"] . "/include/sidebar/login.php");
                    }
                ?>
            </div>
            <div style="clear: both;"></div>
            <div id="content">
