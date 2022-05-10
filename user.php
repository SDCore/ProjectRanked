<?php
    $title = "User";

    if(isset($_GET['id'])) {
        $UID = $_GET['id'];
    }else{
        $UID = 0;
    }

    require_once("./include/nav.php");
    require_once("./include/rankInfo/preUpdate.php");
    require_once("./include/rankInfo/postUpdate.php");
    require_once("./include/rankDiv/preUpdate.php");
    require_once("./include/rankDiv/postUpdate.php");
    require_once("./include/userInfo.php");

    if($debug == true) {
        $streamOpts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];
    }else{
        $streamOpts = [
            "ssl" => [
                "verify_peer"=>true,
                "verify_peer_name"=>true,
            ]
        ];  
    }

    $request = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `PlayerID` = '$UID'");
    $player = mysqli_fetch_assoc($request);

    if($UID == 0 || mysqli_num_rows($request) < 1) {
        echo '<div class="noPlayer">No player with that ID exists.</div>';
    }
?>

<div class="user">
    <div class="userInfo">
        <div class="name">
            <?= platform($player['Platform']); ?>&nbsp;<?= nickname($player['PlayerNick'], $Legendfile[$player['Legend']], $player['PlayerLevel']); ?>
        </div>
        <div class="status">
            <?= isOnline($player['Platform'], $player['PlayerID'], $streamOpts); ?>
        </div>
    </div>

    <span class="placement">
        <span class="box">
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Level.png" /></span>
                <span class="top">
                    <?= number_format($player['PlayerLevel']); ?>
                </span>
                <span class="bottom">Level</span>
                <span class="label">Account</span>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php
                    if($SeasonInfo['currentSplit'] == "1") {
                        echo currentRank($player['PlayerID'], $player['Platform'], $player['BR_RankScorePrev'], "BR", $SeasonInfo['number'], $streamOpts);
                    }else{
                        echo rankInfoPostUpdate($DBConn, $SeasonInfo['number'], "1", "BR", $UID, 0);
                    }
                ?>
                <span class="label">Battle Royale Split 1</span>
            </span>
            <span class="inner">
                <?php
                    if($SeasonInfo['currentSplit'] == "2") {
                        echo currentRank($player['PlayerID'], $player['Platform'], $player['BR_RankScorePrev'], "BR", $SeasonInfo['number'], $streamOpts);
                    }else{
                        echo rankInfoPostUpdate($DBConn, $SeasonInfo['number'], "2", "BR", $UID, 0);
                    }
                ?>
                <span class="label">Battle Royale Split 2</span>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php
                    if($SeasonInfo['currentSplit'] == "1") {
                        echo currentRank($player['PlayerID'], $player['Platform'], $player['Arenas_RankScorePrev'], "Arenas", $SeasonInfo['number'], $streamOpts);
                    }else{
                        echo rankInfoPostUpdate($DBConn, $SeasonInfo['number'], "1", "Arenas", $UID, 0);
                    }
                ?>
                <span class="label">Arenas Split 1</span>
            </span>
            <span class="inner">
                <?php
                    if($SeasonInfo['currentSplit'] == "2") {
                        echo currentRank($player['PlayerID'], $player['Platform'], $player['Arenas_RankScorePrev'], "Arenas", $SeasonInfo['number'], $streamOpts);
                    }else{
                        echo rankInfoPostUpdate($DBConn, $SeasonInfo['number'], "2", "Arenas", $UID, 0);
                    }
                ?>
                <span class="label">Arenas Split 2</span>
            </span>
        </span>
    </span>

    <span class="history">
        <span class="title">Battle Royale History</span>
        <span class="title">Arenas History</span>
    </span>
    <span class="history">
        <div class="season">Season 12 &#8212; Defiance</div>
        <span class="box">
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "12", "1", "BR", $UID, 0); ?>
            </span>
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "12", "2", "BR", $UID, 0); ?>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "12", "1", "Arenas", $UID, 0); ?>
            </span>
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "12", "2", "Arenas", $UID, 0); ?>
            </span>
        </span>
    </span>
    <span class="history">
        <div class="season">Season 11 &#8212; Escape</div>
        <span class="box">
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "11", "1", "BR", $UID, 0); ?>
            </span>
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "11", "2", "BR", $UID, 0); ?>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "11", "1", "Arenas", $UID, 0); ?>
            </span>
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "11", "2", "Arenas", $UID, 0); ?>
            </span>
        </span>
    </span>
    <span class="history">
        <div class="season">Season 10 &#8212; Emergence</div>
        <span class="box">
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "10", "1", "BR", $UID, 0); ?>
            </span>
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "10", "2", "BR", $UID, 0); ?>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "10", "2", "Arenas", $UID, 0); ?>
            </span>
        </span>
    </span>
    <span class="history">
        <div class="season">Season 9 &#8212; Legacy</div>
        <span class="box">
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "09", "1", "BR", $UID, 0); ?>
            </span>
            <span class="inner">
                <?php echo rankInfoPreUpdate($DBConn, "09", "2", "BR", $UID, 0); ?>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <span class="image">
                    <img src="https://cdn.apexstats.dev/ProjectRanked/RankedBadges/Arenas_Unranked.png" />
                </span>
                <span class="top">N/A</span>
                <span class="bottom">N/A</span>
            </span>
        </span>
    </span>
</div>

<?php require_once("./include/footer.php"); ?>
