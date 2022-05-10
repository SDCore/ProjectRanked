<?php
    $title = "User Search";
    require_once("./include/nav.php");

    $UID = 0;

    if(isset($_GET['user'])) {
        $user = $_GET['user'];
    }
    $minLength = 3;

    if(strlen($user) >= $minLength) {
        $user = htmlspecialchars($user);
        $user = mysqli_real_escape_string($DBConn, $user);

        $results = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE (`PlayerNick` LIKE '%".$user."%')");
    }else{
        $error = "<span class='error'>Your search must contain 3 or more characters</span>";
    }

    function icon($platform) {
        if($platform == "PC") return '<i class="fab fa-steam"></i>';
        if($platform == "X1") return '<i class="fab fa-xbox"></i>';
        if($platform == "PS4") return '<i class="fab fa-playstation"></i>';
        if($platform == "SWITCH") return '<i class="fas fa-gamepad"></i>';
    }

    function isOnline($status) {
        if ($status == 1) {
            return "<span class='lobby'><i class='fa-solid fa-circle'></i></span>";
        }

        return "<span class='offline'><i class='fa-solid fa-circle'></i></span>";
    }

    //require_once("./include/rankInfo/preUpdate.php");
    require_once("./include/rankInfo/postUpdate.php");
    //require_once("./include/rankDiv/preUpdate.php");
    require_once("./include/rankDiv/postUpdate.php");
?>

<div class="search">
    <span class="help">* Search users by their current in-game name</span>
    <form action="" method="GET" class="searchBox">
        <input type="text" id="user" name="user" class="input" <?php if(isset($_GET['user'])) { echo 'value="'.$user.'"'; } else { echo 'placeholder="Username"'; } ?> autoFocus />
        <input type="submit" class="button" value="Search">
    </form>
    <div class="results">
        <div class="top">
            <span class="item" style="flex-basis: 40%;"><span class="inner">Username</span></span>
            <span class="item" style="flex-basis: 30%;"><span class="inner">Battle Royale Rank</span></span>
            <span class="item" style="flex-basis: 30%;"><span class="inner">Arenas Rank</span></span>
        </div>
        <?php 
            if(isset($_GET['user'])) {
                if(isset($error)) {
                    echo $error;
                }else{
                    if(mysqli_num_rows($results) < 1) {
                        echo "<span class='error'>No players found with that username</span>";
                    }else{
                        while($player = mysqli_fetch_assoc($results)) {
                            echo '<a href="/user/'.$player['PlayerID'].'" class="list">';
                                echo '<span class="item" style="flex-basis: 40%; font-weight: bold;">'.isOnline($player['PlayerStatus']).' '.icon($player['Platform']).' '.$player['PlayerNick'].'</span>';
                                echo '<span class="item" style="flex-basis: 30%;">'.rankNamePostUpdate($player['BR_isPred'], $player['BR_LadderPos'], $player['BR_RankScore'], "BR", 0).' &#8212; '.number_format($player['BR_RankScore']).' RP</span>';
                                echo '<span class="item" style="flex-basis: 30%;">'.rankNamePostUpdate($player['Arenas_isPred'], $player['Arenas_LadderPos'], $player['Arenas_RankScore'], "Arenas", 0).' &#8212; '.number_format($player['Arenas_RankScore']).' AP</span>';
                            echo '</a>';
                        }
                    }
                }
            }else{
                echo '<span class="error">-</span>';
            }
        ?>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>
