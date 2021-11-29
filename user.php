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

    function platformIcon($platform) {
        if($platform == "PC") return "steam";
        if($platform == "PS4") return "playstation";
        if($platform == "X1") return "xbox";
    }

    require_once("./include/user/rankInfo.php");
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
                <?php echo rankInfo($DBConn, $RankPeriod01, $UID, "BR"); ?>
                <span class="label">BR Ranked Split 1</span>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, $RankPeriod02, $UID, "BR"); ?>
                <span class="label">BR Ranked Split 2</span>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php echo rankInfo($DBConn, $RankPeriod01, $UID, "Arenas"); ?>
                <span class="label">Arenas Ranked Split 1</span>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, $RankPeriod02, $UID, "Arenas"); ?>
                <span class="label">Arenas Ranked Split 2</span>
            </span>
        </span>
    </span>
    <span class="history">
        <span class="title">BR Ranked History</span>
        <span class="title">Arenas Ranked History</span>
    </span>
    <span class="history">
        <span class="box">
            <div class="season">Season 10 &#8212; Emergence</div>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S010_01", $UID, "BR"); ?>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S010_02", $UID, "BR"); ?>
            </span>
        </span>
        <span class="box">
            <div class="season">Season 10 &#8212; Emergence</div>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S010_02", $UID, "Arenas"); ?>
            </span>
        </span>
    </span>
    <span class="history">
        <span class="box">
            <div class="season">Season 09 &#8212; Legacy</div>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S009_01", $UID, "BR"); ?>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S009_02", $UID, "BR"); ?>
            </span>
        </span>
        <span class="box">
            <div class="season">Season 09 &#8212; Legacy</div>
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/Arenas/Unranked.png" /></span>
                <span class="top">N/A</span>
                <span class="bottom">N/A</span>
            </span>
        </span>
    </span>
</div>

<?php require_once("./include/footer.php"); ?>
