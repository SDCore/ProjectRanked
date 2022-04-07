<?php
    $title = "User";
    require_once("./include/nav.php");

    if(isset($_GET['id'])) {
        $UID = $_GET['id'];
    }else{
        $UID = 0;
    }

    if($debug == true) {
        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];
    }else{
        $stream_opts = [
            "ssl" => [
                "verify_peer"=>true,
                "verify_peer_name"=>true,
            ]
        ];  
    }

    $playerRequest = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `PlayerID` = '$UID'");
    $playerQuery = mysqli_fetch_assoc($playerRequest);
    if($UID == 0 || mysqli_num_rows($playerRequest) < 1) { echo '<div class="noPlayer">Player with that ID does not exist.</div>'; return; }

    function platformIcon($platform) {
        if($platform == "PC") return "<i class='fab fa-steam'></i>";
        if($platform == "PS4") return "<i class='fab fa-playstation'></i>";
        if($platform == "X1") return "<i class='fab fa-xbox'></i>";
        if($platform == "SWITCH") return "<i class='fas fa-gamepad'></i>";
    }

    function isOnline($platform, $id, $stream_opts) {
        $onlineAPI = file_get_contents("https://api.apexstats.dev/isOnline?platform=".$platform."&id=".$id, false, stream_context_create($stream_opts));

        $status = json_decode($onlineAPI, true);

        $user = $status['user']['status'];

        if ($user['online'] == 1 && $user['ingame'] == 0) {
            if ($user['matchLength'] != -1) return "<span class='lobby'><i class='fa-solid fa-circle'></i></span> Lobby (".gmdate("i\m s\s", $user['matchLength']).")";

            return "<span class='lobby'><i class='fa-solid fa-circle'></i></span> Lobby";
        }else if($user['online'] == 1 && $user['ingame'] == 1) {
            if ($user['matchLength'] != -1) return "<span class='match'><i class='fa-solid fa-circle'></i></span> In a Match (".gmdate("i\m s\s", $user['matchLength']).")";

            return "<span class='match'><i class='fa-solid fa-circle'></i></span> In a Match";
        }

        return "<span class='offline'><i class='fa-solid fa-circle'></i></span> Offline / Invite Only";
    }

    require_once("./include/rankInfo.php");
    require_once("./include/rankDiv.php");
?>

<div class="user">
    <div class="userInfo">
        <div class="name"><?php echo platformIcon($playerQuery['Platform']); ?>&nbsp;<?php echo nickname($playerQuery['PlayerNick'], $Legendfile[$playerQuery['Legend']],  $playerQuery['PlayerLevel']); ?></div>
        <div class="status"><?php echo isOnline($playerQuery['Platform'], $playerQuery['PlayerID'], $stream_opts); ?></div>
    </div>
    
    <?php
        if($playerQuery['isBlacklisted'] == 1) {
            echo "<div style='background: rgba(255, 0, 0, 0.75); backdrop-filter: blur(10px); padding: 5px; margin-bottom: 1px; text-align: center; color: #FFF; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.75);'>";
                echo "<b>ATTENTION:</b> This user has been blacklisted from appearing on the leaderboards.";
            echo "</div>";
        }
    ?>
    
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
        <div class="season">Season 11 &#8212; Escape</div>
        <span class="box">
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S011_01", $UID, "BR"); ?>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S011_02", $UID, "BR"); ?>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S011_01", $UID, "Arenas"); ?>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S011_02", $UID, "Arenas"); ?>
            </span>
        </span>
    </span>
    <span class="history">
    <div class="season">Season 10 &#8212; Emergence</div>
        <span class="box">
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S010_01", $UID, "BR"); ?>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S010_02", $UID, "BR"); ?>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S010_02", $UID, "Arenas"); ?>
            </span>
        </span>
    </span>
    <span class="history">
        <div class="season">Season 09 &#8212; Legacy</div>
        <span class="box">
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S009_01", $UID, "BR"); ?>
            </span>
            <span class="inner">
                <?php echo rankInfo($DBConn, "Ranked_S009_02", $UID, "BR"); ?>
            </span>
        </span>
        <span class="box">
            <span class="inner">
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/Arenas/Unranked.png" /></span>
                <span class="top">N/A</span>
                <span class="bottom">N/A</span>
            </span>
        </span>
    </span>
</div>

<?php require_once("./include/footer.php"); ?>
