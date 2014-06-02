<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");

    

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
                    <a href="#">&laquo; Return to Shop</a>
                    <a href="#" style="float: right;">&#9734; &#9733;</a>
                </div>
                <div class="left">
                    <div class="description">
                        <div class="namebar">
                            <span class="title">Item Name</span>
                            <div style="clear: both;"></div>
                        </div>                        
                        Description and stuff
                    </div>
                    <div class="purchasebox">
                        <div class="cost">
                            <img class="icon" src="/images/icons/cubes.svg"/>
                            <span>20,164</span>
                        </div>
                        <div class="sa-button" id="s-purchase"><img class="icon" src="/images/icons/cubes-white.svg"/>Purchase</div>
                        <div class="sa-button" id="s-gift">Gift</div>
                    </div>
                </div>
                <div class="right">
                    <div class="preview" style="background-image: url(/data/items/previews/full/1.png);"></div>
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