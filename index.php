<?php
    $pageTitle = "Home"; require_once("./include/nav.php");

    // Loading legend file w/ names
    $legendFile = file_get_contents("./GameData/legends.json");
    $legendIDs = json_decode($legendFile, true);

    // Detecting which platform to use for title
    if(isset($_GET['PC'])) {
        $platform = "PC";
        $text = "PC";
    }else if(isset($_GET['X1'])) {
        $platform = "X1";
        $text = "Xbox";
    }else if(isset($_GET['PS4'])) {
        $platform = "PS4";
        $text = "PlayStation";
    }else{
        $platform = "PC";
        $text = "PC";
    }

    // Pagination
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    $records = 50;
    $offset = ($page - 1) * $records;
    $totalPlayers = mysqli_query($DBConn, "SELECT COUNT(*) FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000");
    $totalRows = mysqli_fetch_array($totalPlayers)[0];
    $totalPages = ceil($totalRows / $records);
    
    $rankedQuery = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 ORDER BY `$ladderPos` ASC, `$RankScore` DESC LIMIT $offset, $records");

    // Minimum amount to reach Apex Predator
    $minimumPred = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 AND `$isPred` = '1' ORDER BY `$ladderPos` DESC LIMIT 1");

    while($row = mysqli_fetch_assoc($minimumPred)) {
        $minPred = number_format($row[$RankScore]);
    }

    function getNickname($nick, $legend, $level) {
        if($nick != null) return $nick;

        return $legend."#".$level;
    }

    function ladderPos($pos, $isPred) {
        if($isPred == "1") return "#".$pos;

        return "N/A";
    }

    function isPred($isPred, $rankScore) {
        if($isPred == "0") return "<img src='https://cdn.apexstats.dev/ProjectRanked/Badges/Master.png' class='icon' style='filter: drop-shadow(0 0 4px rgba(255, 0, 255, 0.5));' /> Master (".number_format($rankScore).") RP";

        return "<img src='https://cdn.apexstats.dev/ProjectRanked/Badges/Predator.png' class='icon' style='filter: drop-shadow(0 0 4px rgba(255, 0, 0, 0.75));' /> Apex Predator (".number_format($rankScore)." RP)";
    }

    function formatSocial($text, $type) {
        if($text == "N/A") return;

        if($type == "Twitter") return "<a href='https://twitter.com/".$text."' target='_blank'><i class='fab fa-twitter twitter'></i></a>";
        if($type == "Twitch") return "<a href='https://twitch.tv/".$text."' target='_blank'><i class='fab fa-twitch twitch'></i></a>";

        return;
    }

    function checkPos($pos) {
        if($pos == "1") return " first";
        if($pos == "2") return " second";
        if($pos == "3") return " third";
    }
?>

<div class="header">
    <span class="left">
        <?php echo $text; ?> Ranked Stats <span class="small"><a href="?full">[See Full List]</a></span>
        <span class="minimumRP">Approximate Minimum RP for Apex Predator: <b><?php echo $minPred; ?> RP</b></span>
    </span>
    <span class="right">
        <a href="?X1" <?php if($platform == "X1") { echo 'class="active"'; } ?>><i class="fab fa-xbox"></i></a><a href="?PS4" <?php if($platform == "PS4") { echo 'class="active"'; } ?>><i class="fab fa-playstation"></i></a><a href="?PC" <?php if($platform == "PC") { echo 'class="active"'; } ?>><i class="fab fa-steam"></i></a>
    </span>
</div>

<div class="container">
    <div class="leaderboardTop">
        <span class="item i1" style="flex-basis: 5%;"><span class="text">#</span></span>
        <span class="item i2" style="flex-basis: 40%;"><span class="text">Name</span></span>
        <span class="item i2" style="flex-basis: 10%;"><span class="text">Level</span></span>
        <span class="item i2" style="flex-basis: 30%;"><span class="text">Rank (Score)</span></span>
        <span class="item i2" style="flex-basis: 15%;"><span class="text">Socials</span></span>
    </div>

    <?php
        while($player = mysqli_fetch_assoc($rankedQuery)) {
            echo '<div class="leaderboardList'.checkPos($player[$ladderPos]).'">';
                echo '<span class="item i1" style="flex-basis: 5%;"><span class="text">'.ladderPos($player[$ladderPos], $player[$isPred]).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 40%;"><span class="text"><b><img src="https://cdn.apexstats.dev/LegendIcons/'.$legendIDs[$player['Legend']]['Name'].'.png" class="icon" /> '.getNickname($player['PlayerNick'], $legendIDs[$player['Legend']]['Name'], $player['PlayerLevel']).'</b></span></span>';
                echo '<span class="item i2" style="flex-basis: 10%;"><span class="text"><img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Level.png" class="icon" /> '.number_format($player['PlayerLevel']).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 30%;"><span class="text">'.isPred($player[$isPred], $player[$RankScore]).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 15%;"><span class="text">'.formatSocial($player['Twitter'], "Twitter").' '.formatSocial($player['Twitch'], "Twitch").'</span></span>';
            echo '</div>';
        }
    ?>
</div>

<?php require_once("./include/footer.php"); ?>
