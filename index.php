<?php 
    require_once("./include/nav.php");

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

    $DBConn = mysqli_connect($host, $user, $pass, $db);

    $rankedQuery = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 ORDER BY `$LadderPos` ASC, `$RankScore` DESC");
    $minimumPred = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 AND `$isPred` = '1' ORDER BY `$LadderPos` DESC LIMIT 1");
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

        function checkNick($name, $nick) {
            if($nick == null) return $name;

            return $nick;
        }

        $i = 1;

        $legendFile = file_get_contents("./GameData/legends.json");
        $legendIDs = json_decode($legendFile, true);

        while($row = mysqli_fetch_assoc($rankedQuery)) {
            echo '<div class="list">';
                echo '<span class="item i1"><span class="text">'.ladderPos($row['BR_LadderPos']).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 40%;"><span class="text"><img src="https://cdn.apexstats.dev/LegendIcons/'.$legendIDs[$row['Legend']]['Name'].'.png" class="icon legend" /> <a href="#">'.checkNick($row['PlayerName'], $row['PlayerNick']).'</a></span></span>';
                echo '<span class="item i2" style="flex-basis: 10%;"><span class="text"><img src="https://i.imgur.com/vp64kDF.png" class="icon level" /> '.number_format($row['PlayerLevel']).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 30%;"><span class="text">'.isPred($row['BR_isPred'], $row['BR_RankScore']).'</span></span>';
                echo '<span class="item i2" style="flex-basis: 15%;"><span class="text">'.formatSocial($row['Twitter'], "Twitter").' '.formatSocial($row['Twitch'], "Twitch").'</span></span>';
            echo '</div>';
        }
    ?>
</div>

    <!-- news -->
    <!-- apex news -->

    <!-- featured stream(?) -->
    <!-- featured twitch stream -->

<?php require_once("./include/footer.php"); ?>
