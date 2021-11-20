<?php
    $title = "Home";
    require_once("./include/nav.php");

    $CurrentRankPeriod = "Ranked_S0".$SeasonInfo['number']."_0".$SeasonInfo['currentSplit'];
    $DBRankScore = $RankType."_RankScore";
    $DBLadderPos = $RankType."_LadderPos";
    $DBisPred = $RankType."_isPred";
    
    $RankFile = json_decode(file_get_contents("./GameData/".$RankType."_RankPosition.json"), true);
    $Legendfile = json_decode(file_get_contents("./GameData/Legends.json"), true);

    function platform() {
        if(isset($_GET['PC'])) return "PC";
        if(isset($_GET['Xbox'])) return "Xbox";
        if(isset($_GET['PlayStation'])) return "PlayStation";

        return "PC";
    }

    function scoreType($type) {
        if($type == "BR") return "RP";
        if($type == "Arenas") return "AP";
    }

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    $amount = 50;
    $offset = ($page - 1) * $amount;
    $totalRows = mysqli_fetch_array(mysqli_query($DBConn, "SELECT COUNT(*) FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBRankScore` >= ".$RankFile['Platinum']))[0];
    $pages = ceil($totalRows / $amount);

    $playerList = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBRankScore` >= ".$RankFile['Platinum']." ORDER BY `$DBLadderPos` ASC, `$DBRankScore` DESC LIMIT $offset, $amount");

    function checkRank($isPred, $score, $file) {
        if($isPred == "1") return "Predator";

        if($score < $file['Diamond']) return "Platinum";
        if($score < $file['Master']) return "Diamond";

        return "Master";
    }

    function rankText($isPred, $score, $file, $type) {
        if($isPred == "1") return "Apex Predator (".number_format($score)." ".$type.")";

        if($score < $file['Diamond']) return "Platinum (".number_format($score)." ".$type.")";
        if($score < $file['Master']) return "Diamond (".number_format($score)." ".$type.")";

        return "Master (".number_format($score)." ".$type.")";
    }

    function checkPos($pos) {
        if($pos > "750" || $pos == "-1") return "N/A";

        return "#".$pos;
    }

    function nickname($nick, $legend, $level) {
        if($nick != null) return $nick;

        return $legend."#".$level;
    }
?>

Rank Info

<div class="container">
    <div class="top">
        <span class="item i1" style="flex-basis: 5%;"><span class="inner">#</span></span>
        <span class="item i2" style="flex-basis: 45%;"><span class="inner">Name</span></span>
        <span class="item i2" style="flex-basis: 15%;"><span class="inner">Level</span></span>
        <span class="item i2" style="flex-basis: 35%;"><span class="inner">Rank (Score)</span></span>
    </div>

    <?php
        while($player = mysqli_fetch_assoc($playerList)) {
            echo '<div class="list '.checkRank($player[$DBisPred], $player[$DBRankScore], $RankFile).'">';
                echo '<span class="bold" style="flex-basis: 5%;"><span class="inner">'.checkPos($player[$DBLadderPos]).'</span></span>';
                echo '<span class="item" style="flex-basis: 45%;"><span class="inner"><a href="#">'.nickname($player['PlayerNick'], $Legendfile[$player['Legend']]['Name'], $player['PlayerLevel']).'</a></span></span>';
                echo '<span class="item" style="flex-basis: 15%;"><span class="inner">Level '.number_format($player['PlayerLevel']).'</span></span>';
                echo '<span class="item" style="flex-basis: 35%;"><span class="inner">'.rankText($player[$DBisPred], $player[$DBRankScore], $RankFile, scoreType($RankType)).'</span></span>';
            echo '</div>';
        }
    ?>
</div>
