<?php
    $lastUpdated = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod ORDER BY `lastUpdated` DESC");

    while($row = mysqli_fetch_assoc($lastUpdated)) {
        $time = $row['lastUpdated'];
    }

    function timeText($time) {
        $time = floor((time() - $time) / 60);

        if($time > 1 || $time == 0) return $time." minutes";

        return $time." minute";
    }
?>

    <footer class="footer">
        <a href="/admin/login" class="adminLink">&copy;</a> SDCore <?php echo date("Y"); ?> &middot; Data updated hourly. Last updated <?php echo timeText($time); ?> ago.
    </footer>

    <script src="https://kit.fontawesome.com/f9aca975cb.js" crossorigin="anonymous"></script>

</body>

</html>
