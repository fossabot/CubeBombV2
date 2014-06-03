            </div>
            <div style="clear: both;"></div>
        </div>
    </body>
</html>
<?php 
if (isset($memcached)){
    $memcached->quit();
}
?>