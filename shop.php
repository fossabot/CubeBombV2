<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");

    

    /****************************/

    // Page configuration
    $title = "Shop";

    // Scripts
    $pageScript = '/js/pages/shop.js';

    // CSS
    $pageCss = '/css/pages/shop.css';

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");
?>
                <div class="section">
                    <div class="subtitle" style="margin-top: 0px;">Featured items</div>
                    <div id="featured">
                        
                    </div>
                </div>
                <div class="section">

                </div>
<?php                        

    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>