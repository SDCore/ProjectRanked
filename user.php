<?php
    $title = "User";
    require_once("./include/nav.php");

    if(isset($_GET['id'])) {
        $UID = $_GET['id'];
    }else{
        $UID = 0;
    }

    $playerRequest = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `PlayerID` = '$UID'");
    $playerQuery = mysqli_fetch_assoc($playerRequest);
    if($UID == 0 || mysqli_num_rows($playerRequest) < 1) { echo '<div class="noPlayer">Player with that ID does not exist.</div>'; return; }

    $splitOneInfo = mysqli_fetch_assoc(mysqli_query($DBConn, "SELECT * FROM `$RankPeriod01` WHERE `PlayerID` = '$UID'"));
    $splitTwoInfo = mysqli_fetch_assoc(mysqli_query($DBConn, "SELECT * FROM `$RankPeriod02` WHERE `PlayerID` = '$UID'"));

    function platformIcon($platform) {
        if($platform == "PC") return "steam";
        if($platform == "PS4") return "playstation";
        if($platform == "X1") return "xbox";
    }

    function rankImage($pred, $pos, $score, $type) {
        $ScoreFile = json_decode(file_get_contents("./GameData/".$type."_RankPosition.json"), true);

        if($score == 0) return "Unranked";

        if($pred == 1) return "Apex Predator";

        if($score < $ScoreFile['Silver']) return "Bronze";
        if($score < $ScoreFile['Gold']) return "Silver";
        if($score < $ScoreFile['Platinum']) return "Gold";
        if($score < $ScoreFile['Diamond']) return "Platinum";
        if($score < $ScoreFile['Master']) return "Diamond";

        return "Master";
    }

    function rankName($pred, $pos, $score, $type) {
        $ScoreFile = json_decode(file_get_contents("./GameData/".$type."_RankPosition.json"), true);

        if($score == 0) return "Unranked";

        if($pred == 1) return "[#".$pos."] Apex Predator";

        if($score < $ScoreFile['Silver']) return "Bronze";
        if($score < $ScoreFile['Gold']) return "Silver";
        if($score < $ScoreFile['Platinum']) return "Gold";
        if($score < $ScoreFile['Diamond']) return "Platinum";
        if($score < $ScoreFile['Master']) return "Diamond";

        return "Master";
    }
?>

<div class="user">
    <div class="username"><i class="fab fa-<?php echo platformIcon($playerQuery['Platform']); ?>"></i>&nbsp;<?php echo nickname($playerQuery['PlayerNick'], $Legendfile[$playerQuery['Legend']]['Name'], $playerQuery['PlayerLevel']); ?></div>
    <span class="placement">
        <span class="box">
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Level.png" /></span>
                <span class="top"><?php echo number_format($playerQuery['PlayerLevel']); ?></span>
                <span class="bottom">Level</span>
                <span class="label">Account Level</span>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/BR/<?php echo rankImage($splitOneInfo['BR_isPred'], $splitOneInfo['BR_LadderPos'],  $splitOneInfo['BR_RankScore'], "BR"); ?>.png" /></span>
                <span class="top"><?php echo number_format($splitOneInfo['BR_RankScore']); ?> RP</span>
                <span class="bottom"><?php echo rankName($splitOneInfo['BR_isPred'], $splitOneInfo['BR_LadderPos'], $splitOneInfo['BR_RankScore'], "BR"); ?></span>
                <span class="label">BR Ranked Split 1</span>
            </span>
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/BR/<?php echo rankImage($splitTwoInfo['BR_isPred'], $splitTwoInfo['BR_LadderPos'], $splitTwoInfo['BR_RankScore'], "BR"); ?>.png" /></span>
                <span class="top"><?php echo number_format($splitTwoInfo['BR_RankScore']); ?> RP</span>
                <span class="bottom"><?php echo rankName($splitTwoInfo['BR_isPred'], $splitTwoInfo['BR_LadderPos'], $splitTwoInfo['BR_RankScore'], "BR"); ?></span>
                <span class="label">BR Ranked Split 2</span>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/Arenas/<?php echo rankImage($splitOneInfo['Arenas_isPred'], $splitOneInfo['Arenas_LadderPos'],  $splitOneInfo['Arenas_RankScore'], "Arenas"); ?>.png" /></span>
                <span class="top"><?php echo number_format($splitOneInfo['Arenas_RankScore']); ?> AP</span>
                <span class="bottom"><?php echo rankName($splitOneInfo['Arenas_isPred'], $splitOneInfo['Arenas_LadderPos'], $splitOneInfo['Arenas_RankScore'], "Arenas"); ?></span>
                <span class="label">Arenas Ranked Split 1</span>
            </span>
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/Arenas/<?php echo rankImage($splitTwoInfo['Arenas_isPred'], $splitTwoInfo['Arenas_LadderPos'],  $splitTwoInfo['Arenas_RankScore'], "Arenas"); ?>.png" /></span>
                <span class="top"><?php echo number_format($splitTwoInfo['Arenas_RankScore']); ?> AP</span>
                <span class="bottom"><?php echo rankName($splitTwoInfo['Arenas_isPred'], $splitTwoInfo['Arenas_LadderPos'], $splitTwoInfo['Arenas_RankScore'], "Arenas"); ?></span>
                <span class="label">Arenas Ranked Split 2</span>
            </span>
        </span>
    </span>
</div>

<?php require_once("./include/footer.php"); ?>
