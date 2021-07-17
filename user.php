<?php
    require_once("./include/nav.php");
    date_default_timezone_set('UTC');

    $legendFile = file_get_contents("./GameData/legends.json");
    $legendIDs = json_decode($legendFile, true);

    $PID = $_GET['id'];
    $DBConn = mysqli_connect($host, $user, $pass, $db);
    $getPlayer = mysqli_query($DBConn, "SELECT * FROM `projectRanked` WHERE `PlayerID` = '$PID'");
    $player = mysqli_fetch_assoc($getPlayer);

    if(mysqli_num_rows($getPlayer) < 1) { echo '<div style="font-size: 25pt; width: 100%; text-align: center; color: #FFF; margin-top: 25px; font-weight: bold; text-shadow: 0 4px 0 rgba(0, 0, 0, 0.9);">User does not exist.</div>'; }

    if (mysqli_num_rows($getPlayer) >= 1) {
        $legendFile = file_get_contents("./GameData/legends.json");
        $legendIDs = json_decode($legendFile, true);

        function truncate($str) {
            if (strlen($str) > 12) {
                return $str = substr($str, 0, 13) . '...';
            }else{
                return $str;
            }
        }

        function checkNick($nick, $level, $legend) {
            if($nick == null) return truncate($legend."#".$level);

            return truncate($nick);
        }

        function isPred($Score, $isPred, $Pos) {
            if($Score < 10000) return "<img src='https://cdn.apexstats.dev/ProjectRanked/Badges/Unranked_2.png' class='RankImage' /><span class='unranked'>Unranked</span>";
            if($isPred == 0) return "<img src='https://cdn.apexstats.dev/ProjectRanked/Badges/Master.png' style='filter: drop-shadow(0 0 6px rgba(255, 0, 255, 0.4));' class='RankImage' />";

            return "<img src='https://cdn.apexstats.dev/ProjectRanked/Badges/Predator.png' style='filter: drop-shadow(0 0 6px rgba(255, 0, 0, 0.5));' class='RankImage' /><span class='pos'>#".$Pos."</span>";
        }

?>

    <div class="userContainer">
        <span class="avatar">
            <img src="https://cdn.apexstats.dev/LegendIcons/<?php echo $legendIDs[$player['Legend']]['Name'] ?>.png" class="legend" />
            <span class="name">
                <?php echo checkNick($player['PlayerNick'], $player['PlayerLevel'], $legendIDs[$player['Legend']]['Name']); ?>
                <span class="subText">Last Updated <?php echo date("h:i:s A T", $player['lastUpdated']); ?></span>
            </span>
        </span>
        <span class="stats">
            <span class="level">
                <img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Level.png" style="filter: drop-shadow(0 0 4px rgba(255, 234, 46, 0.35));" class="levelImage" />
                <span class="levelText">
                    Level <?php echo number_format($player['PlayerLevel']); ?>
                    <span class="subText">Account Level</span>
                </span>
            </span>
            <span class="BR_Rank">
                <?php echo isPred($player['BR_RankScore'],$player['BR_isPred'], $player['BR_LadderPos']); ?>
                <span class="RankText">
                    <?php echo number_format($player['BR_RankScore']); ?> RP
                    <span class="subText">Battle Royal</span>
                </span>
            </span>
            <span class="Arenas_Rank">
                <?php echo isPred($player['Arenas_RankScore'], $player['Arenas_isPred'], $player['Arenas_LadderPos']); ?>
                <span class="RankText">
                    <?php echo number_format($player['Arenas_RankScore']); ?> RP
                    <span class="subText">Arenas</span>
                </span>
            </span>
        </span>
    </div>

    <div class="userInfoContainer">
        <span class="kills">
            kills
        </span>
        <span class="twitch">
            <span class="title">Twitch</span>
            <span class="body">
                <?php
                    if($player['Twitch'] == "N/A") {
                        echo "<span class='NA'>Twitch Not Linked</span>";
                    }else{
                        echo "<div id='TwitchStream'></div>";
                    }
                ?>
            </span>
        </span>
        <span class="twitter">
            <span class="title">Twitter</span>
            <span class="body">
                <?php
                    if($player['Twitter'] == "N/A") {
                        echo "<span class='NA'>Twitter Not Linked</span>";
                    }else{
                        echo "<a class='twitter-timeline' data-dnt='true' data-theme='dark' href='https://twitter.com/".$player['Twitter']."'></a> <script async src='https://platform.twitter.com/widgets.js' charset='utf-8'></script>";
                    }
                ?>
            </span>
        </span>
    </div>

    <script src= "https://player.twitch.tv/js/embed/v1.js"></script>
    <script type="text/javascript">
        var options = {
            width: "100%",
            height: "450px",
            autoplay: false,
            muted: false,
            channel: "<?php echo $player['Twitch']; ?>",
        };
        var player = new Twitch.Player("TwitchStream", options);
        player.setVolume(0.5);
    </script>

<?php } require_once("./include/footer.php"); ?>
