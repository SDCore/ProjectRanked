<?php
    $pageTitle = "User"; require_once("./include/nav.php");

    if(isset($_GET['id'])) {
        $UID = $_GET['id'];
    }else{
        $UID = 0;
    }

    $playerQuery = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod_Current WHERE `PlayerID` = '$UID'");

    $rankPeriod01 = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod_01 WHERE `PlayerID` = '$UID'");
    $rankPeriod02 = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod_02 WHERE `PlayerID` = '$UID'");

    $PlayerNotExist = "<div style='text-align: center; width: 100%; color: #FFF; font-size: 20pt; text-shadow: 0 2px 0 rgba(0, 0, 0, 1); font-weight: bold; margin-top: 25px;'>A player with that ID does not exist.</div>";



    function getNickname($nick, $legend, $level) {
        if($nick != null) return $nick;

        return $legend."#".$level;
    }

    function truncate($str) {
        if (strlen($str) > 32) {
            return $str = substr($str, 0, 33) . '...';
        }else{
            return $str;
        }
    }

    function platformIcon($platform) {
        if($platform == "PC") return "steam";
        if($platform == "PS4") return "playstation";
        if($platform == "X1") return "xbox";
    }

    function BR_RankImage($isPred, $rankScore) {
        if($isPred == 1) {
            return '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Predator_2.png" /><div class="innerText pred">'.number_format($rankScore).' RP</div>';
        }

        return '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Master_2.png" /><div class="innerText master">'.number_format($rankScore).' RP</div>';
    }

    function BR_RankPeriodText($rankPeriod, $id) {
        include("connect.php");
        $DBConn = mysqli_connect($host, $user, $pass, $db);
        $period = mysqli_query($DBConn, "SELECT * FROM $rankPeriod WHERE `PlayerID` = '$id'");

        if(mysqli_num_rows($period) < 1) {
            echo 'N/A';
        } else {
            while($Ranked = mysqli_fetch_assoc($period)) {
                if($Ranked['BR_isPred'] == 1) return "[#".$Ranked['BR_LadderPos']."] Apex Predator";

                return "Master";
            }
        }
    }
?>

<div class="user">
    <?php 
        if($UID == 0 || mysqli_num_rows($playerQuery) < 1) { echo $PlayerNotExist; return; }

        while($player = mysqli_fetch_assoc($playerQuery)) {
            $twitter = $player['Twitter'];
            $twitch = $player['Twitch'];
            $tiktok = $player['TikTok'];
            $youtube = $player['YouTube'];
    ?>
        <span class="title">
            <span class="name"><i class="fab fa-<?php echo platformIcon($player['Platform']); ?>"></i> <?php echo getNickname($player['PlayerNick'], $player['Legend'], $player['PlayerLevel']); ?></span>
            <span class="socials">
                <?php if($twitter != "N/A") { ?><a href="https://twitter.com/<?php echo $player['Twitter']; ?>" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a><?php } ?>
                <?php if($twitch != "N/A") { ?><a href="https://twitch.tv/<?php echo $player['Twitch']; ?>" target="_blank" class="twitch"><i class="fab fa-twitch"></i></a><?php } ?>
                <?php if($tiktok != "N/A") { ?><a href="https://tiktok.com/@<?php echo $player['TikTok']; ?>" target="_blank" class="tiktok"><i class="fab fa-tiktok"></i></a><?php } ?>
                <?php if($youtube != "N/A") { ?><a href="https://youtube.com/channel/<?php echo $player['YouTube']; ?>" target="_blank" class="youtube"><i class="fab fa-youtube"></i></a><?php } ?>
            </span>
        </span>

        <span class="placement">
            <span class="box">
                <span class="inner">
                    <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Level.png" /></span>
                    <span class="text"><?php echo number_format($player['PlayerLevel']); ?></span>
                    <span class="label">Account Level</span>
                </span>
            </span>
            <span class="box">
                <span class="inner">
                    <span class="image">
                        <?php
                            if(mysqli_num_rows($rankPeriod01) < 1) {
                                echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Unranked_3.png" /><div class="innerText">Unranked</div>';
                            } else {
                                while($Ranked_01 = mysqli_fetch_assoc($rankPeriod01)) {
                                    echo BR_RankImage($Ranked_01['BR_isPred'], $Ranked_01['BR_RankScore']);
                                }
                            }
                        ?>
                    </span>
                    <span class="text">
                        <?php echo BR_RankPeriodText($DB_RankPeriod_01, $UID); ?>
                    </span>
                    <span class="label">Battle Royale Split 1</span>
                </span>
                <span class="inner">
                    <span class="image">
                        <?php
                            if(mysqli_num_rows($rankPeriod02) < 1) {
                                echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Unranked_3.png" /><div class="innerText">Unranked</div>';
                            } else {
                                while($Ranked_01 = mysqli_fetch_assoc($rankPeriod02)) {
                                    echo BR_RankImage($Ranked_01['BR_isPred'], $Ranked_01['BR_RankScore']);
                                }
                            }
                        ?>
                    </span>
                    <span class="text">
                        <?php echo BR_RankPeriodText($DB_RankPeriod_02, $UID); ?>
                    </span>
                    <span class="label">Battle Royale Split 2</span>
                </span>
            </span>
            <span class="box">
                <span class="inner">
                    <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Unranked_3.png" /></span>
                    <span class="text">Coming Season 10!</span>
                    <span class="label">Arenas</span>
                </span>
            </span>
        </span>

        <span class="userInfo">
            <span class="box twitter">
                <span class="title" style="background: none;">Twitter</span>
                <?php if($player['Twitter'] == "N/A") { echo "<span style='text-align: center; width: 100%; font-weight: bold; display: block; color: rgba(255, 255, 255, 0.5); font-size: 14pt;'>N/A</span>"; } else { ?>
                    <a class="twitter-timeline" data-dnt="true" data-theme="dark" href="https://twitter.com/<?php echo $player['Twitter'] ?>"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                <?php } ?>
            </span>
            <span class="box">
                <span class="title">BR Ranked History</span>
                <span class="BR_History">
                <span class="item">
                        <span class="top" style="background: url('https://cdn.apexstats.dev/ProjectRanked/Season/Season_9.png') center no-repeat; background-color: rgba(0, 0, 0, 0.5);">Season 9</span>
                        <span class="inner">
                            <span class="split01">
                                <?php
                                    if(mysqli_num_rows(mysqli_query($DBConn, "SELECT * FROM Ranked_S009_01 WHERE `PlayerID` = '$UID'")) < 1) {
                                        echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Unranked_3.png" /><span class="text">Unranked</span>';
                                    } else {
                                        $result = mysqli_query($DBConn, "SELECT * FROM Ranked_S009_01 WHERE `PlayerID` = '".$player['PlayerID']."' LIMIT 1");
                                        $row = mysqli_fetch_assoc($result);
                                        
                                        if($row['BR_isPred'] == "1") {
                                            echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Predator_2.png" /><span class="text">[#'.$row['BR_LadderPos'].'] Apex Predator ('.number_format($row['BR_RankScore']).' RP)</span>';
                                        }else{
                                            echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Master_2.png" /><span class="text">Master ('.number_format($row['BR_RankScore']).' RP)</span>';
                                        }
                                    }
                                ?>
                            </span>
                            <span class="split02">
                                <?php
                                    if(mysqli_num_rows(mysqli_query($DBConn, "SELECT * FROM Ranked_S009_02 WHERE `PlayerID` = '".$player['PlayerID']."' LIMIT 1")) < 1) {
                                        echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Unranked_3.png" /><span class="text">Unranked</span>';
                                    } else {
                                        $result = mysqli_query($DBConn, "SELECT * FROM Ranked_S009_02 WHERE `PlayerID` = '".$player['PlayerID']."' LIMIT 1");
                                        $row = mysqli_fetch_assoc($result);
                                        
                                        if($row['BR_isPred'] == "1") {
                                            echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Predator_2.png" /><span class="text">[#'.$row['BR_LadderPos'].'] Apex Predator ('.number_format($row['BR_RankScore']).' RP)</span>';
                                        }else{
                                            echo '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Master_2.png" /> <span class="text">Master ('.number_format($row['BR_RankScore']).' RP)</span>';
                                        }
                                    }
                                ?>
                            </span>
                        </span>
                    </span>
                </span>
            </span>
            <span class="box">
                <span class="title">Arena Ranked History</span>
                <span class="Arenas_History">
                    <span style="background: rgba(0, 0, 0, 0.75); text-align: center; width: 100%; font-weight: bold; display: block; color: rgba(255, 255, 255, 0.75); font-size: 14pt; padding: 10px 0;">Coming Season 10!</span>
                </span>
            </span>
        </span>
    <?php } ?>
</div>

<?php require_once("./include/footer.php"); ?>
