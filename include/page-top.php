<?php
    // Include db info from outside of the document root
    require("/var/www/secure/db.php");
    require($_SERVER["DOCUMENT_ROOT"] . "/include/cubebomb.php");
    
    // Start compressing output
    //ob_start("ob_gzhandler");
?>
<!doctype html>
<html>
    <head>
        <script src="/js/analytics.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="/js/jquery.color-2.1.2.min.js"></script>
        <script src="/js/jquery.tipsy.js"></script>
        <script src="/js/page.js"></script>
        <?php 
            if ($pageScript != "") { 
        ?>
        <script src="<?php echo $pageScript; ?>"></script>
        <?php 
            } 
        ?>
        
        <link rel="stylesheet" type="text/css" href="/css/pages/profile.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/tipsy.css">
        <?php 
            if ($pageCss != "") { 
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $pageCss; ?>">
        <?php 
            } 
        ?>
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        
        <title><?php echo htmlspecialchars($title); ?> | CubeBomb</title>
    </head>
    
    <body>
        <div id="logo"></div>
        <div id="wrapper">
            <div id="nav" class="shadow">
                <div class="account"><?php echo htmlspecialchars($user["username"]); ?></div>
                <a href="#">Shop</a>
                <a href="#">Members</a>
                <a href="#">Forum</a>
                <a href="#">Dropoff</a>
                <a href="#">Help</a>
                <div class="time" title="CubeBomb Time is UTC"><?php echo date("H:i"); ?></div>
                <a href="#" style="float: right;">Log out</a>
            </div>
            <div id="sidebar-wrapper">
                <div id="sidebar" class="shadow">
                    <div class="avatar" style="background-image: url(/images/sm.png);"></div>
                    <div class="block">
                        <div class="info">
                            <div class="sprite sprite-cubes"></div>
                            <span class="counter"><?php echo number_format($user["cubes"]); ?></span>
                            <span class="hint">Cubes</span>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-message"></div>
                            <span class="hint">Messages</span>
                            <span class="counter">14</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-burst"></div>
                            <span class="hint">Notifications</span>
                            <span class="counter">2</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="rule"><div class="text">Quick Links</div></div>
                        
                        <div class="button">
                            <div class="sprite sprite-pencil"></div>
                            <span class="title">Edit Profile</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-gear"></div>
                            <span class="title">Settings</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-tag"></div>
                            <span class="title">Inventory</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-foot"></div>
                            <span class="title">Friend Activity</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="rule"><div class="text">Moderation</div></div>
                        
                        <div class="button">
                            <div class="sprite sprite-camera"></div>
                            <span class="hint">Images</span>
                            <span class="counter">7</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-flag"></div>
                            <span class="hint">Reports</span>
                            <span class="counter">11</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="rule"><div class="text">Administration</div></div>
                        
                        <div class="button">
                            <div class="sprite sprite-computer"></div>
                            <span class="title">Admin Panel</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-key"></div>
                            <span class="title">Page Lock</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-clock"></div>
                            <span class="title">Page History</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <div class="sprite sprite-chat"></div>
                            <span class="hint">Notes</span>
                            <span class="counter">2</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="rule"><div class="text">Friends Online</div></div>
                        
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                        <div class="button">
                            <img class="icon" src="/images/sm.png" />
                            <span class="title">StuffMaker</span>
                            <div class="rightArrow" style="opacity: 0;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="content">