<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");

    if (!isset($_GET["id"]) || !is_int(intval($_GET["id"])) || $_GET["id"] <= 0 || !canAccessMessage($_GET["id"], $user["id"])){
        header("Location:/inbox.php?unknown");
        exit;
    }
        
    $message = getArray("SELECT * FROM `private_messages` WHERE `id` = '" . escape(intval($_GET["id"])) . "' AND `receiverId` = '" . $user["id"] . "' AND `deleted` =0");

    /****************************/

    // Page configuration
    $title = "Private Message";

    // Scripts
    $pageScript = "/js/pages/pm.js";

    // CSS
    $pageCss = "/css/pages/pm.css";

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");
?>
                <div class="sort-results">
                    <span class="title"><?php echo htmlspecialchars(trim($message["subject"])); ?></span>
                </div>
                <div style="clear: both;"></div>
                <div class="breadcrumb">
                    <a href="/inbox.php">Inbox</a> / Private Message
                </div>
                <div style="clear: both;"></div>
                <div class="message">
                    <div class="left">
                        <?php echo nl2br(htmlspecialchars(trim($message["body"]))); ?>
                    </div>
                </div>
<?php
    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>
