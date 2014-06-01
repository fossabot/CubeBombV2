<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");

    

    /****************************/

    // Page configuration
    $title = "Shop";

    // Scripts
    $pageScript = "/js/pages/shop.js";

    // CSS
    $pageCss = "/css/pages/shop.css";

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");
?>
                <div class="title">
                    <span>Shop</span>
                    <!--<div class="sort-results">
                        <form action="#">
                            <div class="sa-button submit">Search</div>
                            <input type="text" id="s-search" label="Search" />
                        </form>
                    </div>-->
                </div>
                <div class="subtitle">Featured items</div>
                <div class="section">
                    <?php for ($i = 0; $i < 2; $i++) { ?>
                    <div class="row">
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name of this awesome</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">152 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">Official</div></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Hate name</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">6,351 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">User</div></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name hat look</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">10 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">Official</div></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">this</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">1,242 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">User</div></div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>
                <div class="subtitle">Latest</div>
                <div class="section">
                    <?php for ($i = 0; $i < 1; $i++) { ?>
                    <div class="row">
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name of this awesome</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">152 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">Official</div></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Hate name</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">6,351 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">User</div></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name hat look</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">10 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">Official</div></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/full/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">this</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">1,242 <img src="/images/icons/cubes.svg" class="cubes" /><div class="origin">User</div></div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>
<?php                        

    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>