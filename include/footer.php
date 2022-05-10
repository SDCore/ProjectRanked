<?php
    $lastUpdated = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod ORDER BY `id` DESC");

    while($row = mysqli_fetch_assoc($lastUpdated)) {
        $time = $row['lastUpdated'];
    }

    function timeText($time) {
        $time = floor((time() - $time) / 60);

        if($time > 1 || $time == 0) return $time." minutes";

        return $time." minute";
    }

    // Close connection
    mysqli_close($DBConn);
?>
    
    <footer class="footer">
        <a href="/admin/index">&copy;</a> SD <?php echo date("Y"); ?> <!-- &middot; Thanks Shrugtal for the Background --> &middot; Updated hourly. Last updated <?php echo timeText($time); ?> ago.
    </footer>
    
    <script rel="preload" src="https://kit.fontawesome.com/f9aca975cb.js" crossorigin="anonymous"></script>

</body>

</html>
