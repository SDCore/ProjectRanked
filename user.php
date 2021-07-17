<?php
    require_once("./include/nav.php");

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
            if (strlen($str) > 10) {
                return $str = substr($str, 0, 14) . '...';
            }else{
                return $str;
            }
        }

        function checkNick($nick, $level, $legend) {
            if($nick == null) return truncate($legend."#".$level);

            return truncate($nick);
        }

        function isPred($isPred, $Pos) {
            if($isPred == 0) return "<img src='https://cdn.apexstats.dev/RankedIcons/master.png' class='RankImage' />";

            return "<img src='https://cdn.apexstats.dev/RankedIcons/predator.png' class='RankImage' /><span class='pos'>#".$Pos."</span>";
        }

?>

    <div class="userContainer">
        <span class="avatar">
            <img src="https://cdn.apexstats.dev/LegendIcons/<?php echo $legendIDs[$player['Legend']]['Name'] ?>.png" class="legend" />
            <span class="name"><?php echo checkNick($player['PlayerNick'], $player['PlayerLevel'], $legendIDs[$player['Legend']]['Name']); ?></span>
        </span>
        <span class="stats">
            <span class="level">
                <img src="https://cdn.apexstats.dev/Badges/AccountBadges/AccountLevel.png" class="levelImage" />
                <span class="levelText">Level <?php echo number_format($player['PlayerLevel']); ?></span>
            </span>
            <span class="BR_Rank">
                <?php echo isPred($player['BR_isPred'], $player['BR_LadderPos']); ?>
                <span class="RankText"><?php echo number_format($player['BR_RankScore']); ?> RP</span>
            </span>
            <span class="Arenas_Rank">
                Arenas_Rank 1,234 RP
            </span>
        </span>
    </div>

separate boxes, have backgrounds be slightly transparent, borders/margins are about 5 pixel spacing between content boxes

first box
check avatar -> if yes, use avatar, if no, use recently selected legend
under avatar, name

second box
current legen, rank score, master/pred icon

third box (under the first 2)
total (counted) kills with each legend

fourth box (maybe next to third box?)
twitch stream/twitter widget if linked in DB

<?php } require_once("./include/footer.php"); ?>
