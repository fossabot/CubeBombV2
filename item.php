<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");

    $noExist = true;

    $item;
    
    if (isset($_GET["id"])){
        $id = trim($_GET["id"]);
    
        if (is_numeric($id)){
            $id = intval($id);
            
            if (itemExistsNotDeleted($id)){
                $noExist = false;
                
                $item = getArray("SELECT * FROM `public_items` WHERE `id` =" . escape($id) . " ORDER BY `id` ASC LIMIT 0, 1");
                
                $item += getArray("SELECT * FROM (SELECT * FROM`public_items_details` WHERE `itemid` ='" . $item["id"] . "' ORDER BY `id` DESC LIMIT 0, 1) A, (SELECT `username` as `author` FROM `private_users` WHERE `id` ='" . $item["userid"] . "') B, (SELECT COUNT(`id`) AS `purchases` FROM `private_purchases` WHERE `itemid` = '" . $item["id"] . "') C");
            }
        }
    }

    query("UPDATE `public_items` SET `views` = `views`+1 WHERE `id` = '" . $item["id"] . "';");

    /****************************/

    // Page configuration
    $title = "Shop";

    // Scripts
    $pageScript = "/js/pages/item.js";

    // CSS
    $pageCss = "/css/pages/item.css";

    $breadcrumb = true;

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");
?>
                <div class="breadcrumb">
                    <!--<div class="star">&#9734; &#9733;</div>-->
                    <a href="#">&laquo; Return to Shop</a>
                    
                </div>
                <div class="left">
                    <div class="description">
                        <div class="namebar">
                            <span class="title"><?php echo htmlspecialchars($item["name"]); ?></span>
                            <div style="clear: both;"></div>
                        </div>                        
                        <?php echo nl2br(htmlspecialchars($item["description"])); ?>
                    </div>
                    <div class="purchasebox">
                        <div class="cost">
                            <img class="icon" src="/images/icons/cubes.svg"/>
                            <span><?php echo number_format($item["cost"]); ?></span>
                        </div>
                        <div class="sa-button" id="s-purchase"><img class="icon" src="/images/icons/cubes-white.svg"/>Purchase</div>
                        <div class="sa-button" id="s-gift" title=":)">Gift</div>
                    </div>
                    <div class="subtitle">Comments</div>
                    <div class="comments">
                        <div class="post">
                            <form action="/api/saveItemComment.php">
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
                    <div class="preview" style="background-image: url(/data/items/previews/full/<?php echo htmlspecialchars($item["image"]); ?>.png);"></div>
                    <div class="subtitle">Info</div>
                    
                    <div>
                        <div class="info">
                            <div>Author: <span><a href="#"><?php echo htmlspecialchars($item["author"]); ?></a></span></div>
                            <div>Created: <span><?php  ?>Feb. 16, 2010</span></div>
                            <div>Purchased: <span><?php echo number_format($item["purchases"]); ?></span></div>
                            <div>Views: <span><?php echo htmlspecialchars($item["views"]); ?></span></div>
                        </div>
                        <div class="avatar" title="View profile" style="background-image: url(/data/avatars/<?php echo urlencode(strtolower($item["author"])); ?>.png);"></div>
                        <div style="clear: both;"></div>
                    </div>
                    <div class="subtitle">More from this user</div>
                    <div class="more">
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="thumbnail" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png);">
                                <div class="details"><img class="icon" src="/images/icons/cubes-white.svg"/>2260</div>
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
                <div style="clear: both;"></div>
<?php                        

    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>