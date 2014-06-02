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
                <div class="sort-results">
                    <span class="title">Shop</span>
                    <form action="#">
                        <div class="sa-button submit">Search</div>
                        <input type="text" id="s-search" label="Search"/>
                        <div style="clear: both;"></div>
                    </form>
                    <div style="clear: both;"></div>
                </div>
                <div class="subtitle">Latest <span class="s-more">Browse All Latest &raquo;</span></div>
                <div class="section">
                    <?php for ($i = 0; $i < 2; $i++) { ?>
                    <div class="row">
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name of this awesome</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">152 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">Official</span></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Hate name</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">6,351 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">User</span></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name hat look</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">10 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">Official</span></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">this</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">1,242 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">User</span></div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>
                <div class="subtitle">Featured <span class="s-more">Browse All Featured &raquo;</span></div>
                <div class="section">
                    <?php for ($i = 0; $i < 2; $i++) { ?>
                    <div class="row">
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name of this awesome</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">152 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">Official</span></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Hate name</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">6,351 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">User</span></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">Name hat look</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">10 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">Official</span></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="spacer">
                                <div class="preview" style="background-image: url(https://www.cubebomb.com/data/items/previews/200/<?php echo rand(1, 1000); ?>.png); "></div>
                            </div>
                            <div class="details">
                                <div class="name">this</div>
                                <div class="author">StuffMaker</div>
                                <div class="cost">1,242 <img src="/images/icons/cubes.svg" class="cubes" /><span class="origin">User</span></div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <?php } ?>
                </div>
<?php                        

    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>