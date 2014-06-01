<?php
    // Page configuration
    $title = "Sign In";
    
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
<h1>Log In</h1>

<div class="loginbox shadow">
    <form method="POST" action="/api/doLogin.php">
        <div class="inputRow">
            <input type="text" name="username" 
        </div>
    </form>
</div>
<?php
    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>