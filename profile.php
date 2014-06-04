<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");

    $noExist = true;

    $profileUser;
    
    if (isset($_GET["id"])){
        $id = trim($_GET["id"]);
    
        if (is_numeric($id)){
            $id = intval($id);
            
            if (userExistsNotDeleted($id)){
                $noExist = false;
                
                $profileUser = getArray("SELECT * FROM `private_users` WHERE `id` =" . escape($id) . " ORDER BY `id` ASC LIMIT 0, 1");
                
                if (getSingleValue("SELECT count(`id`) FROM `public_users_profiles` WHERE `userid` =" . escape($id) . " ORDER BY `timestamp` DESC LIMIT 0, 1") == 1){
                    // Use actual profile data
                    $profile = getArray("SELECT * FROM `public_users_profiles` WHERE `userid` =" . escape($id) . " ORDER BY `timestamp` DESC LIMIT 0, 1");
                }else{
                    // Default user data
                    $profile = getArray("SELECT * FROM `public_users_profiles` WHERE `userid` =999999999 ORDER BY `timestamp` DESC LIMIT 0, 1");
                }
            }
        }
    }

    query("UPDATE `private_users` SET `profileViews` = `profileViews`+1 WHERE `id` = '" . escape(intval($id)) . "';");

    /****************************/

    // Page configuration
    $title = (($profileUser == null) ? "User doesn't exist" : htmlspecialchars($profileUser["username"])."'s Profile");

    // Scripts
    $pageScript = "/js/pages/profile.js";

    // CSS
    $pageCss = "/css/pages/profile.css";

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");

    if ($noExist == false){
?>

                <div class="left">
                    <div class="username">
                        <span class="title"><?php echo htmlspecialchars($profileUser["username"]); ?></span>
                        <span class="seen">Last seen <?php echo timePassed($profileUser["lastTime"]); ?> ago</span>
                    </div>
                    <div class="description">
                        <?php echo str_replace("\n", "<br />", htmlspecialchars($profile["message"])); ?>
                    </div>
                    <div class="subtitle">Inventory</div>
                    <div class="inventory shadow">
                        <div class="topbar">
                            <a href="#" class="selected">Official Items (132)</a>
                            <a href="#">User Items (9)</a>
                            <div class="sort"></div>
                        </div>
                        
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2200</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2100</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2210</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2220</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2230</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2240</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2250</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2260</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2270</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2280</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2290</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2201</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2202</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2203</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2204</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2205</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2206</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2207</div>
                        </div></a>
                        <a href="#"><div class="item" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/small/white/cubes.png"/>2208</div>
                        </div></a>
                        
                        <a href="#">
                            <div class="nextBlock">
                                <img class="icon" src="/images/icons/large/black/rightPointer.png" />
                                <div>Page 1/10</div>
                            </div>
                        </a>
                        <div style="clear: both;"></div>
                    </div>
                    
                    <div class="subtitle">Shoutbox</div>
                    <div class="comments">
                        <div class="post">
                            <form action="/api/saveShoutboxComment.php">
                                <div class="error"></div>
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                                <div class="inputRow">
                                    <textarea name="comment" id="s-comment" label="Post comment" required></textarea>
                                </div>
                                <div class="inputRow">
                                    <div class="sa-button" id="s-submit" style="display: none;">Submit</div>
                                    <div style="clear: both;"></div>
                                </div>
                            </form>
                        </div>
                        <div class="comment" id="comment-template" style="display: none;">
                            <div class="avatar" title="View profile"></div>
                            <div class="content">
                                <div class="details">
                                    <a href="#">StuffMaker:</a>
                                    <span>30 minutes ago</span>
                                </div>
                                <span>Comment</span>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="fillspace">
                            <div class="message">Loading comments...</div>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="avatar" style="background-image: url(/data/avatars/<?php echo htmlspecialchars(strtolower($profileUser["username"])); ?>.png);"></div>
                    
                    <div class="subtitle">Actions</div>
                    
                    <div class="actions shadow">
                        <a href="#">Send Message <div class="sprite sprite-rightPointer"></div></a>
                        <a href="#">Friend Request <div class="sprite sprite-rightPointer"></div></a>
                        <a href="#">Block User <div class="sprite sprite-rightPointer"></div></a>
                        <a href="#">Subscribe <div class="sprite sprite-rightPointer"></div></a>
                        
                        <?php
                            if ($user["permissions"] >= $_PADMIN){
                        ?>
                        <div id="adminDropdownButton" style="height: 40px; cursor: pointer;">
                            <div class="rule"><div class="text">Administration [Expand]</div></div>
                        </div>
                        
                        <div id="adminDropdown" style="display: none;">
                            <a href="#">Send Notification <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Edit Profile <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Force Name Change <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Force Logout <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Actions History <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Clear Avatar <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Change Permissions <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Related Accounts <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Ban User <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">Delete Account <div class="sprite sprite-rightPointer"></div></a>
                            <a href="#">IP Ban <div class="sprite sprite-rightPointer"></div></a>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    
                    <div class="subtitle">Info</div>
                    
                    <div class="stats shadow">
                        <?php
                        switch ($profileUser["permissions"]){
                            case $_PARTIST:
                                ?><div style="color: #fff; background-color: #8f2ac5;">Artist</div><?php 
                                break;
                            case $_PMOD:
                                ?><div style="color: #fff; background-color: #6cc52a;">Moderator</div><?php
                                break;
                            case $_PADMIN:
                                ?><div style="color: #fff; background-color: #2a89c5;">Administrator</div><?php
                                break;
                            case $_POP:
                                ?><div style="color: #fff; background-color: #c5382a;">Operator</div><?php
                                break;
                        }?>
                        <div>Registered: <span><?php echo date("M. jS, Y", strtotime($profileUser["joinTime"])); ?></span></div>
                        <div>Profile views: <span><?php echo number_format($profileUser["profileViews"]); ?></span></div>
                        <div>Forum posts: <span>4,153</span></div>
                    </div>
                    
                    <div class="subtitle">Friends (73)</div>
                    
                    <div class="friends shadow">
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=341);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=308);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=317);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=12);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=444);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=372);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=444);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=1);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=341);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=308);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(http://cubetales.com/images/avatar/?id=317);">
                                <div class="details">StuffMaker</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="nextBlock">
                                <img class="icon" src="/images/icons/large/black/rightPointer.png" />
                                <div>Page 1/7</div>
                            </div>
                        </a>
                        
                        <div style="clear: both;"></div>
                    </div>
                </div>
<?php                        
    }else{
?>
                <h1>Error:</h1>
                <p>This user does not exist.</p>
<?php
    }

    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>