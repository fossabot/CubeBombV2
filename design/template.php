<?php
    // Page configuration
    $title = "Template Page";
    
    // Access
    $public = true;
    $publicOnly = false;
    
    // Functionality
    $hideSidebar = false;

    // Scripts
    $pageScript = "";
    $additionalScripts = "";

    // CSS
    $pageCss = "";
    $additionalCss = "";

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");
?>

<?php
    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>