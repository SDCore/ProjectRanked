<?php 
    require_once("./include/nav.php");

    if(!isset($_GET['platform'])) {
        $platform = "PC";
        $platformText = "PC";
    }else if($_GET['platform'] == "PC") {
        $platform = "PC";
        $platformText = "PC";
    }else if($_GET['platform'] == "X1") {
        $platform = "X1";
        $platformText = "Xbox";
    }else if($_GET['platform'] == "PS4") {
        $platform = "PS4";
        $platformText = "PlayStation";
    }else{
        $platform = "PC";
        $platformText = "PC";
    }

    $DBConn = mysqli_connect($host, $user, $pass, $db);

    $rankedQuery = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' ORDER BY `BR_LadderPos` ASC, `BR_RankScore` DESC");
    $minimumPred = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `BR_isPred` = '1' ORDER BY `BR_LadderPos` DESC LIMIT 1");
?>

<div class="containerTitle">
    <span class="left">Ranked Stats for <?php echo $platformText; ?></span>
    <span class="right"><a href="?platform=PC" class="<?php if($platform == 'PC') { echo 'active'; } ?>">PC</a><a href="?platform=PS4" class="<?php if($platform == 'PS4') { echo 'active'; } ?>">PS4</a><a href="?platform=X1" class="<?php if($platform == 'X1') { echo 'active'; } ?>">X1</a></span>
</div>

<div class="minimumPred">Approximate Minimum RP for Pred: <?php while($row = mysqli_fetch_assoc($minimumPred)) { echo number_format($row['BR_RankScore']); } ?></div>

<div class="container">
    <div class="item">
        <div class="title">Account Level</div>
        <div class="title">Name</div>
        <div class="title">Rank</div>
        <div class="title">RP</div>
        <div class="title">Socials</div>
    </div>

    <?php
        function isPred($pred, $ladderPos) {
            if($pred == 1) return "<b>[#".$ladderPos."]</b> Apex Predator";

            return "Master";
        }

        function formatSocial($name, $type) {
            if($name == "N/A") return;

            if($type == "Twitter") return "<a href='https://twitter.com/".$name."' target='_blank'><i class='fab fa-twitter icoTwitter'></i></a>";
            if($type == "Twitch") return "<a href='https://twitch.tv/".$name."' target='_blank'><i class='fab fa-twitch icoTwitch'></i></a>";

            return;
        }

        $i = 1;

        $legendFile = file_get_contents("./GameData/legends.json");
        $legendIDs = json_decode($legendFile, true);

        while($row = mysqli_fetch_assoc($rankedQuery)) {
            echo '<div class="item">';
                echo '<div class="list"><img src="https://i.imgur.com/vp64kDF.png" class="icon" /> '.number_format($row['PlayerLevel']).'</div>';
                echo '<div class="list"> <img src="https://cdn.apexstats.dev/LegendIcons/'.$legendIDs[$row['Legend']]['Name'].'.png" class="icon" /> <a href="#">'.$row['PlayerNick'].'</a></div>';
                echo '<div class="list">'.isPred($row['BR_isPred'], $row['BR_LadderPos']).'</div>';
                echo '<div class="list">'.number_format($row['BR_RankScore']).' RP</div>';
                echo '<div class="list social">'.formatSocial($row['Twitter'], "Twitter").' '.formatSocial($row['Twitch'], "Twitch").'</div>';
            echo '</div>';

            $i++;
        }
    ?>
</div>

    <!-- content -->
    <!-- top 750 on pc - top 750 on ps4 - top 750 on xbox -->

    <!-- news -->
    <!-- apex news -->

    <!-- featured stream(?) -->
    <!-- featured twitch stream -->

<?php require_once("./include/footer.php"); ?>
