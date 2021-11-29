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
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/BR/Bronze.png" /></span>
                <span class="top">0 RP</span>
                <span class="bottom">Bronze</span>
                <span class="label">BR Ranked Split 1</span>
            </span>
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/BR/Bronze.png" /></span>
                <span class="top">0 RP</span>
                <span class="bottom">Bronze</span>
                <span class="label">BR Ranked Split 1</span>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/Arenas/Unranked.png" /></span>
                <span class="top">0 RP</span>
                <span class="bottom">Unranked</span>
                <span class="label">Arenas Ranked Split 1</span>
            </span>
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/Arenas/Unranked.png" /></span>
                <span class="top">0 RP</span>
                <span class="bottom">Unranked</span>
                <span class="label">Arenas Ranked Split 1</span>
            </span>
        </span>
    </span>
</div>

<?php require_once("./include/footer.php"); ?>
