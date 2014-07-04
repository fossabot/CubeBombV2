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
            
            // Increment view counter
            query("UPDATE `public_forums_threads` SET `views` = `views`+1 WHERE `id` = '" . escape(intval($id)) . "';");
            
            $breadcrumb = "<a href=\"/forum.php?index\">Forum Home</a> / <a href=\"/forum.php?forum&id=" . $thread["forumid"] . "\">" . htmlspecialchars($forum["name"]) . "</a>";
            $breadcrumb .= " / Current Thread";
            
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
                    <?php if ($isThread) { ?><div class="f-stats"><?php echo number_format($posts) . " posts, " . number_format($thread["views"]) . " views"; ?></div><?php } ?>
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
                    $results = query("SELECT * FROM `public_forums_threads` WHERE `deleted` = '0' AND `forumid` = '" . escape($id) . "' ORDER BY `timestamp` DESC, `sticky` DESC LIMIT 50");
                    
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
                        <span class="f-ago"><?php echo ago($post["timestamp"]); ?></span>
                        <span class="f-views"><?php if ($post["views"] > 1){ echo number_format($post["views"]); } ?></span>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>
                <?php }else if ($isThread){ ?>
                <div class="thread">
                    <?php
                        $results = query("SELECT * FROM `public_forums_posts` WHERE `postid` = '" . escape(intval($id)) . "' AND `deleted` = '0' ORDER BY `id` ASC LIMIT 20");
                        
                        while ($post = fetchRows($results)){ 
                        $post["username"] = getUsername($post["userid"]);
                    ?>
                    <div class="t-post">
                        <div class="t-left">
                            <div class="avatar" style="background-image: url(/data/avatars/<?php echo urlencode(strtolower($post["username"])); ?>.png);"></div>
                            <a href="/profile.php?id=2"><?php echo htmlspecialchars($post["username"]); ?></a>
                            <div class="badge">Top 10 poster</div>
                        </div>
                        <div class="t-right">
                            <?php echo nl2br(htmlspecialchars(trim($post["content"]))); ?>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
<?php                        
    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>