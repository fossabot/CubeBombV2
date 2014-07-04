<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . "/include/page-utils.php");



    /****************************/

    // Page configuration
    $title = "Inbox";

    // Scripts
    $pageScript = "/js/pages/inbox.js";

    // CSS
    $pageCss = "/css/pages/inbox.css";

    require($_SERVER["DOCUMENT_ROOT"] . "/include/page-top.php");
?>
                <div class="sort-results">
                    <span class="title">Inbox</span>
                    <form action="#">
                        <div class="sa-button options">Options &or;</div>
                        <div class="sa-button submit">Search</div>
                        <input type="text" id="s-search" label="Search"/>
                        <div style="clear: both;"></div>
                        <div class="options-row">
                            <div class="sa-button delete-all">Delete all</div>
                            <div class="sa-button mark-all">Mark all as read</div>
                        </div>
                    </form>
                    <div style="clear: both;"></div>
                </div>
                <div class="inbox">
                    <div class="message header">
                        <span class="m-select">&nbsp;</span>
                        <span class="m-subject">Subject</span>
                        <span class="m-sender"><a href="#2" title="Visit profile">Sender</a></span>
                        <span class="m-time">Time</span>
                        <span class="m-flags">Flags</span>
                        <div style="clear: both;"></div>
                    </div>
                    <div class="messagearea">
                        <div class="message" id="message-template">
                            <span class="m-select"><input type="checkbox" class="m-check" /></span>
                            <span class="m-subject">Subject</span>
                            <span class="m-sender"><a href="#" title="Visit profile">Sender</a></span>
                            <span class="m-time">Time</span>
                            <span class="m-flags">Flags</span>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </div>
<?php
    include($_SERVER["DOCUMENT_ROOT"] . "/include/page-end.php");
?>
