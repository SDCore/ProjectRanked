<?php 
    $pageTitle = "Home"; require_once("./include/nav.php");
    $DBConn = mysqli_connect($host, $user, $pass, $db);

    if(isset($_GET['PC'])) {
        $platform = "PC";
        $platformText = "PC";
    }else if(isset($_GET['X1'])) {
        $platform = "X1";
        $platformText = "Xbox";
    }else if(isset($_GET['PS4'])) {
        $platform = "PS4";
        $platformText = "PlayStation";
    }else {
        $platform = "PC";
        $platformText = "PC";
    }

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    $records = 50;
    $offset = ($page - 1) * $records;
    $totalPlayers = "SELECT COUNT(*) FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000";
    $result = mysqli_query($DBConn, $totalPlayers);
    $totalRows = mysqli_fetch_array($result)[0];
    $totalPages = ceil($totalRows / $records);

    $rankedQuery = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 ORDER BY `$ladderPos` ASC, `$RankScore` DESC LIMIT $offset, $records");
    $minimumPred = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 AND `$isPred` = '1' ORDER BY `$ladderPos` DESC LIMIT 1");
?>

<div class="containerTitle">
    <span class="left">Ranked Stats for <?php echo $platformText; ?></span>
    <span class="right"><a href="?PC" class="<?php if($platform == 'PC') { echo 'active'; } ?>"><i class="fab fa-steam" style="line-height: 40px;"></i></a><a href="?PS4" class="<?php if($platform == 'PS4') { echo 'active'; } ?>"><i class="fab fa-playstation" style="line-height: 40px;"></i></a><a href="?X1" class="<?php if($platform == 'X1') { echo 'active'; } ?>"><i class="fab fa-xbox" style="line-height: 40px;"></i></a></span>
</div>

<div class="minimumPred">Approximate Minimum RP for Pred: <?php while($row = mysqli_fetch_assoc($minimumPred)) { echo number_format($row['BR_RankScore']); } ?></div>

<div class="container">
    <div class="title">
        <span class="item i1"><span class="text">#</span></span>
        <span class="item i2" style="flex-basis: 40%;"><span class="text">Name</span></span>
        <span class="item i2" style="flex-basis: 10%;"><span class="text">Level</span></span>
        <span class="item i2" style="flex-basis: 30%;"><span class="text">Rank (Score)</span></span>
        <span class="item i2" style="flex-basis: 15%;"><span class="text">Socials</span></span>
    </div>

    <?php
        function checkPage() {
            if(isset($_GET['PC'])) return "?PC&";
            if(isset($_GET['PS4'])) return "?PS4&";
            if(isset($_GET['X1'])) return "?X1&";

            return "?";
        }

        function ladderPos($ladderPos) {
            if($ladderPos == 9999) return "N/A";

            return "#".$ladderPos;
        }

        function isPred($isPred, $RP) {
            if($isPred == 0) return "<img src='https://cdn.apexstats.dev/RankedIcons/master.png' style='width: 20px; position: relative; top: 5px; filter: drop-shadow(0 0 4px rgba(255, 0, 255, 0.5));' /> Master (".number_format($RP)." RP)";

            return "<img src='https://cdn.apexstats.dev/RankedIcons/predator.png' style='width: 20px; position: relative; top: 5px; filter: drop-shadow(0 0 4px rgba(255, 0, 0, 0.75));' /> Apex Predator (".number_format($RP)." RP)";
        }

        function formatSocial($name, $type) {
            if($name == "N/A") return;

            if($type == "Twitter") return "<a href='https://twitter.com/".$name."' target='_blank'><i class='fab fa-twitter icoTwitter'></i></a>";
            if($type == "Twitch") return "<a href='https://twitch.tv/".$name."' target='_blank'><i class='fab fa-twitch icoTwitch'></i></a>";

            return;
        }

        function checkNick($nick, $level, $legend) {
            if($nick == null) return $legend."#".$level;

            return $nick;
        }

        function checkPos($pos) {
            if($pos == "1") return " first";
            if($pos == "2") return " second";
            if($pos == "3") return " third";
        }

        $i = 1;

        $legendFile = file_get_contents("./GameData/legends.json");
        $legendIDs = json_decode($legendFile, true);

        if($page > $totalPages) {
            echo '<span style="display: inline-block; width: 100%; text-align: center; color: #FFF; font-size: 15pt;">No results on this page.</span>';
        }

        while($row = mysqli_fetch_assoc($rankedQuery)) {
            echo '<div class="list'.checkPos($row[$ladderPos]).'">';
                echo '<span class="item i1"><span class="text">'.ladderPos($row[$ladderPos]).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 40%;"><span class="text"><img src="https://cdn.apexstats.dev/LegendIcons/'.$legendIDs[$row['Legend']]['Name'].'.png" class="icon legend" /> <a href="#">'.checkNick($row['PlayerNick'], $row['PlayerLevel'], $legendIDs[$row['Legend']]['Name']).'</a></span></span>';
                echo '<span class="item i2" style="flex-basis: 10%;"><span class="text"><img src="https://i.imgur.com/vp64kDF.png" class="icon level" /> '.number_format($row['PlayerLevel']).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 30%;"><span class="text">'.isPred($row[$isPred], $row['BR_RankScore']).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 15%;"><span class="text">'.formatSocial($row['Twitter'], "Twitter").' '.formatSocial($row['Twitch'], "Twitch").'</span></span>';
            echo '</div>';
        }
    ?>
</div>

<div class="pagination">
    <a href="<?php echo checkPage(); if($page == 1) { echo 'page=1'; } else { echo '#'; } ?>?>" class="page first <?php if($page == 1) { echo 'disabled'; } ?>"><i class="fas fa-angle-double-left"></i> First</a>
    <a href="<?php echo checkPage(); if($page <= 1) { echo '#'; } else { echo 'page='.($page - 1); } ?>" class="<?php if($page <= 1) { echo 'disabled'; } ?> page prev"><i class="fas fa-angle-left"></i> Previous</a>
    <a href="<?php echo checkPage(); if($page >= $totalPages) { echo '#'; } else { echo 'page='.($page + 1); } ?>" class="<?php if($page >= $totalPages) { echo 'disabled'; } ?> page next">Next <i class="fas fa-angle-right"></i></a>
    <a href="<?php echo checkPage(); if($page == $totalPages) { echo '#'; } else { echo 'page='.$totalPages; } ?>" class="page last <?php if($page == $totalPages) { echo 'disabled'; } ?>">Last <i class="fas fa-angle-double-right"></i></a>
</div>

    <!-- news -->
    <!-- apex news -->

    <!-- featured stream(?) -->
    <!-- featured twitch stream -->

<?php require_once("./include/footer.php"); ?>
