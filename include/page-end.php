            </div>
            <div style="clear: both;"></div>
        </div>
    </body>
</html>
<?php
if (isset($memcached)){
    // Discard of memcached instance if it is in use
    $memcached->quit();
}
?>
