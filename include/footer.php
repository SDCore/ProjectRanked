<?php 
    $DBConn = mysqli_connect($host, $user, $pass, $db);

    $recentQuery = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod ORDER BY `BR_RankScore` ASC");

    while ($row = mysqli_fetch_assoc($recentQuery)) {
        $time = $row['lastUpdated'];
    }

    function time2string($timeline) {
        $periods = array('minute' => 60);
        $ret = "";
    
        foreach($periods AS $name => $seconds){
            $num = floor($timeline / $seconds);
            $timeline -= ($num * $seconds);
            $ret .= $num.' '.$name.(($num > 1 || $num == 0) ? 's' : '').' ';
        }
    
        return trim($ret);
    }
?>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="inner">
            <b><a href="/admin/login" style="text-decoration: none; color: rgba(255, 255, 255, 0.25);">&copy;</a> SDCore <?php echo date("Y"); ?>. &middot; Data updated every hour. &middot; Last updated <?php echo time2string(time()-$time); ?> ago.</b> <?php if(isset($_SESSION['user'])) { echo "<span style='float: right;'>".$_SESSION['username']." &middot; <a href='../admin/' style='color: rgba(255, 255, 255, 0.5); text-decoration: none;'>Admin</a> &middot; <a href='../logout' style='color: rgba(255, 255, 255, 0.5); text-decoration: none;'>Sign Out</a></span>"; } ?>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/f9aca975cb.js" crossorigin="anonymous"></script>
</body>

</html>
