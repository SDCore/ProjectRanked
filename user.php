<?php
    require_once("./include/nav.php");

    $PID = $_GET['id'];
    $DBConn = mysqli_connect($host, $user, $pass, $db);
    $getPlayer = mysqli_query($DBConn, "SELECT * FROM `projectRanked` WHERE `PlayerID` = '$PID'");
    $player = mysqli_fetch_assoc($getPlayer);

    if(mysqli_num_rows($getPlayer) < 1) { echo '<div style="font-size: 25pt; width: 100%; text-align: center; color: #FFF; margin-top: 25px; font-weight: bold; text-shadow: 0 4px 0 rgba(0, 0, 0, 0.9);">User does not exist.</div>'; }

    if (mysqli_num_rows($getPlayer) >= 1) {
        $legendFile = file_get_contents("./GameData/legends.json");
        $legendIDs = json_decode($legendFile, true);

        function checkNick($nick, $level, $legend) {
            if($nick == null) return $legend."#".$level;

            return $nick;
        }
?>

    <div class="userContainer">
        <?php echo "<h1>".checkNick($player['PlayerNick'], $player['PlayerLevel'], $legendIDs[$player['Legend']]['Name'])."</h1>"; ?>
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
