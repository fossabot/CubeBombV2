<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");


    $isThread = false;
    $isForum = false;
    $isIndex = false;

    // Determine if this is the board index.
    if (isset($_GET["index"])){
        $isIndex = true;
    }
    
    // Test id. If this isn't the board index, process the request
    if (isset($_GET["id"]) && intval($_GET["id"]) > 0 && !$isIndex){
        $id = intval($_GET["id"]);
                
        // Determine what the user wants
        if (isset($_GET["thread"])){
            $isThread = true;
            
            if (isThreadDeleted($id)){
                $forumid = getSingleValue("SELECT `forumid` FROM `public_forums_threads` WHERE `id` = '" . escape($id) . "'");
                
                header("Location:/forum.php?forum&id=$forumid&deleted");
                exit;
            }else if (!threadExists($id)){
                header("Location:/forum.php?index&unknown");
                exit;
            } 
            
            $thread = getArray("SELECT * FROM `public_forums_threads` WHERE `deleted` = '0' AND `id` ='" . escape($id) . "'");
            $forum = getArray("SELECT `id`, `name` FROM `public_forums_sections` WHERE `id` = '" . escape(intval($thread["forumid"])) . "'");
            
            $posts = getSingleValue("SELECT COUNT(`id`) FROM `public_forums_posts` WHERE `postid` = '" . escape(intval($id)). "' AND `deleted` = '0' LIMIT 1");
            
            $lastpost = strtotime(getSingleValue("SELECT `timestamp` FROM `public_forums_posts` WHERE `postid` = '" . escape(intval($id)). "' AND `deleted` = '0' ORDER BY `timestamp` DESC LIMIT 1"));
            
            // Pagination
            
            $page = 1;
            $pageSize = 20;
            
            if (isset($_GET["page"]) && trim($_GET["page"]) != "" && is_numeric($_GET["page"])){
                $page = intval(trim(escape($_GET["page"])));
            }
            
            $numRows = $posts;
            $maxPages = ceil($numRows/$pageSize);

            // Constrain page to limits
            if ($page > $maxPages){
                $page = $maxPages;
            }else if ($page < 0){
                $page = 1;
            }
            $queryPage = $pageSize * ($page-1);
            
            $breadcrumb = "<a href=\"/forum.php?index\">Forum Home</a> / <a href=\"/forum.php?forum&id=" . $thread["forumid"] . "\">" . htmlspecialchars($forum["name"]) . "</a>";
            $breadcrumb .= " / Current Thread";
            
            if ($page != 1){
                $breadcrumb .= " (Page $page)";
            }
            
            // Increment view counter
            query("UPDATE `public_forums_threads` SET `views` = `views`+1 WHERE `id` = '" . escape(intval($id)) . "';");
            
        }else if (isset($_GET["forum"])){
            $isForum = true;
            
            if (!forumExists($id)){
                header("Location:/forum.php?index&unknown");
                exit;
            }
            
            if (isset($_GET["deleted"])){
                
            }
            
            $forum = getArray("SELECT `id`, `name` FROM `public_forums_sections` WHERE `id` = '" . escape(intval($id)) . "'");
            
            $threads = getSingleValue("SELECT COUNT(`id`) FROM `public_forums_threads` WHERE `forumid` = '" . escape($id) . "' AND `deleted` = '0' LIMIT 1");
            
            $breadcrumb = "<a href=\"/forum.php?index\">Forum Home</a> / " . htmlspecialchars($forum["name"]);
        }
    }else if (!isset($_GET["id"]) && !isset($_GET["index"]) && !isset($_GET["thread"]) && !isset($_GET["forum"])){
        // None of the flags are set -- redirect to board index
        header("Location:/forum.php?index");
        exit;
    }

    /****************************/

    // Page configuration
    $title = "Forum";

    // Scripts
    $pageScript = "/js/pages/forum.js";

    // CSS
    $pageCss = "/css/pages/forum.css";

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");
    
?>
                <div class="sort-results">
                    <span class="title">
                        <?php 
                            if ($isThread){
                                echo htmlspecialchars($thread["title"]);
                            }else if ($isForum){
                                echo htmlspecialchars($forum["name"]);
                            }else if ($isIndex){
                                echo "Forum Home";
                            }
                        ?>
                    </span>
                    <?php if ($isForum) { ?><div class="sa-button f-newtopic" style="float: right;">New Thread</div><?php } ?>
                    <div style="clear: both;"></div>
                    <?php if ($breadcrumb != false && !$isIndex) { ?>
                    <?php if ($isForum) { ?><div class="f-stats"><?php echo number_format($threads) ?> threads in this forum</div><?php } ?>
                    <?php if ($isThread) { ?><div class="f-stats"><?php echo number_format($posts) . " post" . ($posts != 1 ? "s" : "") . ", " . number_format($thread["views"]) . " view" . ($thread["views"] != 1 ? "s" : ""); ?></div><?php } ?>
                    <div class="breadcrumb"><?php echo $breadcrumb; ?></div>
                    <?php } ?>
                    <div style="clear: both;"></div>
                </div>
                <?php if ($isForum){ ?>
                <div class="forum">
                    <div class="f-thread key">
                        <div class="f-icon">&nbsp;</div>
                        <span class="f-title">Title</span>
                        <span class="f-poster">Poster</span>
                        <span class="f-ago">Last Post</span>
                        <span class="f-views">Views</span>
                        <div style="clear: both;"></div>
                    </div>
                    <?php 
                    $results = query("SELECT a.*, c.`userid` as `lastposter`, c.`timestamp` AS `lastpost`
                                        FROM `public_forums_threads` a
                                            INNER JOIN `public_forums_posts` c
                                                ON a.id = c.postid
                                            INNER JOIN (
                                                SELECT postid, MAX(timestamp) maxTime
                                                FROM `public_forums_posts`
                                                GROUP BY postid
                                            ) b ON c.postid = b.postid AND
                                                c.timestamp = b.maxTime
                                        WHERE a.deleted =0
                                        AND a.forumid ='" . escape($id) . "'
                                        ORDER BY a.`sticky` DESC, c.`timestamp` DESC
                                        LIMIT 0, 50");
                    
                    while ($post = fetchRows($results)){ ?>
                    <div class="f-thread<?php if ($post["sticky"]){ ?> sticky<?php } ?>" onclick="window.location='/forum.php?thread&id=<?php echo $post["id"]; ?>'">
                        <?php if ($post["sticky"]){ ?>
                            <div class="f-icon sticky"></div>
                        <?php }else if(!$post["canReply"]) { ?>
                            <div class="f-icon locked"></div>
                        <?php }else{ ?>
                            <div class="f-icon"></div>
                        <?php } ?>
                        <span class="f-title"><?php echo htmlspecialchars($post["title"]); ?></span>
                        <span class="f-poster">
                            <a href="/profile.php?id=<?php echo $post["userid"]; ?>"><?php echo htmlspecialchars(getUsername($post["userid"])); ?></a>
                        </span>
                        <span class="f-ago"><?php echo ago($post["lastpost"]); ?></span>
                        <span class="f-views"><?php if ($post["views"] > 1){ echo number_format($post["views"]); } ?></span>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>
                <?php }else if ($isThread){ 

                if ($thread["id"] <= 14705){ ?>
                <div class="notice">
                    This thread is locked because it is from the original CubeBomb. <a href="/">Details &raquo;</a>
                </div>
                <?php }else if ($lastpost <= (time()-1209600)){ ?>
                <div class="notice">
                    This thread is locked because it has been inactive for more than 14 days.
                </div>

                <?php } if ($user["permissions"] >= $_PMOD){ ?>
                <div class="mod-bar">
                    <div class="sa-button compact">Moderation History</div>
                    <div class="sa-button compact red" title="Prevent users from posting. Only moderators can post.">Lock Thread</div>
                    <div class="sa-button compact red" title="Remove thread, make available to moderators only.">Delete Thread</div>
                    <div class="sa-button compact red" title="Remove from forum index, make available to public via url only.">Hide Thread</div>
                    <select id="mod-move" style="display: inline-block; width: 125px; height: 25px;">
                        <?php 
                        $results = query("SELECT * FROM `public_forums_sections` WHERE `deleted` =0 LIMIT 50");
                        while ($section = fetchRows($results)){ ?>
                        <option value="<?php echo $section["id"]; ?>"><?php echo htmlspecialchars($section["name"]); ?></option>
                        <?php } ?>
                    </select>
                    <div class="sa-button compact red" title="Move thread to another forum.">Move Thread</div>
                </div>
                <?php } 
                    if ($maxPages > 1){ ?>
                    <div class="pageBar top">
                        <?php
                        $idealWidth = 13;
                        $centerDistance = 7;
                            
                        $startPoint = 0;
                        $width = $idealWidth;

                        // Calculate constraints
                        if ($page > $centerDistance){
                            $startPoint = $page - $centerDistance;
                        }

                        if ($startPoint + $width > $maxPages){
                            $difference = abs($startPoint + $width - $maxPages);
                            if ($difference <= $startPoint){
                                $startPoint -= $difference;
                            }else if ($width > $maxPages){
                                $width = $maxPages;
                                $startPoint = 0;
                            }
                        }
                        
                        if ($startPoint > 0){ ?>
                        <a href="/forum.php?thread&id=<?php echo $id; ?>&page=1">First</a>
                        <?php }
                        
                        for ($i = $startPoint; $i < $startPoint+$width; $i++){ ?>
                        <a href="/forum.php?thread&id=<?php echo $id; ?>&page=<?php echo ($i+1); ?>" <?php if ($page == $i+1){ ?>class="current"<?php } ?>><?php echo number_format($i+1); ?></a>
                        <?php } 
                        
                        if ($startPoint + $width < $maxPages){?>
                        <a href="/forum.php?thread&id=<?php echo $id; ?>&page=<?php echo $maxPages; ?>">Last (<?php echo number_format($maxPages); ?>)</a>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                <div class="thread">
                    <?php
                        if ($user["permissions"] >= $_PMOD){
                            $results = query("SELECT * FROM `public_forums_posts` WHERE `postid` = '" . escape(intval($id)) . "' ORDER BY `id` ASC LIMIT $queryPage, $pageSize");
                        }else{
                            $results = query("SELECT * FROM `public_forums_posts` WHERE `postid` = '" . escape(intval($id)) . "' AND `deleted` = '0' ORDER BY `id` ASC LIMIT $queryPage, $pageSize");
                        }
                        
                        while ($post = fetchRows($results)){ 
                        $post["username"] = getUsername($post["userid"]);
                    ?>
                    <div class="t-post<?php if ($post["deleted"]) {?> deleted<?php } ?>">
                        <input type="hidden" class="t-post-id" value="<?php echo $post["id"]; ?>" />
                        <div class="t-left">
                            <a href="/profile.php?id=<?php echo intval($post["userid"]); ?>">
                                <div class="avatar" style="background-image: url(/data/avatars/<?php echo rawurlencode(strtolower($post["username"])); ?>.png);"></div>
                            </a>
                            <a href="/profile.php?id=<?php echo intval($post["userid"]); ?>"><?php echo htmlspecialchars($post["username"]); ?></a>
                            <?php if ($post["userid"] == 2){ ?><div class="catch">I make stuff :)</div><?php } ?>
                            <div class="date" title="<?php echo date("M j, Y H:i:s", strtotime($post["timestamp"])); ?>"><?php echo ((time()-strtotime($post["timestamp"]) >= 604800) ? date("M j, Y H:i", strtotime($post["timestamp"])) : ago($post["timestamp"]) . " ago"); ?></div>
                            <!--<div class="badge">Top 10 poster</div>-->
                            <div class="t-donate">
                                <span>0</span><img class="icon" src="/images/icons/cubes.svg" />
                            </div>
                        </div>
                        <div class="t-right">
                            <?php echo cbbbc(nl2br(htmlspecialchars(trim($post["content"])))); ?>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>

                <?php if ($maxPages > 1){ ?>
                    <div class="pageBar">
                        <?php
                        if ($startPoint > 0){ ?>
                        <a href="/forum.php?thread&id=<?php echo $id; ?>&page=1">First</a>
                        <?php }
                        
                        for ($i = $startPoint; $i < $startPoint+$width; $i++){ ?>
                        <a href="/forum.php?thread&id=<?php echo $id; ?>&page=<?php echo ($i+1); ?>" <?php if ($page == $i+1){ ?>class="current"<?php } ?>><?php echo number_format($i+1); ?></a>
                        <?php } 
                        
                        if ($startPoint + $width < $maxPages){?>
                        <a href="/forum.php?thread&id=<?php echo $id; ?>&page=<?php echo $maxPages; ?>">Last (<?php echo number_format($maxPages); ?>)</a>
                        <?php } ?>
                    </div>
                <?php }
                } ?>
<?php                        
    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>