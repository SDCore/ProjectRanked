<?php
    $pageTitle = "User"; require_once("./include/nav.php");

    if(isset($_GET['id'])) {
        $UID = $_GET['id'];
    }else{
        $UID = 0;
    }

    $playerQuery = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod WHERE `PlayerID` = '$UID'");

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
?>

<div class="user">
    <?php 
        if($UID == 0 || mysqli_num_rows($playerQuery) < 1) { echo $PlayerNotExist; return; }

        while($player = mysqli_fetch_assoc($playerQuery)) {
    ?>
        <span class="title">
            <span class="name"><i class="fab fa-<?php echo platformIcon($player['Platform']); ?>"></i> <?php echo truncate(getNickname($player['PlayerNick'], $player['Legend'], $player['Level'])); ?></span>
            <span class="socials">
                <a href="https://twitter.com/<?php echo $player['Twitter']; ?>" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://twitch.tv/<?php echo $player['Twitch']; ?>" target="_blank" class="twitch"><i class="fab fa-twitch"></i></a>
                <a href="https://tiktok.com/@<?php echo $player['TikTok']; ?>" target="_blank" class="tiktok"><i class="fab fa-tiktok"></i></a>
                <a href="https://youtube.com/channel/<?php echo $player['YouTube']; ?>" target="_blank" class="youtube"><i class="fab fa-youtube"></i></a>
            </span>
        </span>

        <span class="placement">
            <span class="box">account level</span>
            <span class="box">battle royale</span>
            <span class="box">arenas</span>
        </span>
    <?php } ?>
</div>

<?php require_once("./include/footer.php"); ?>
