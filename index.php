<?php
    $title = "Home";
    require_once("./include/nav.php");
    include_once("./include/platform.php");

    $CurrentRankPeriod = "Ranked_S0".$SeasonInfo['number']."_0".$SeasonInfo['currentSplit'];
    $DBRankScore = $RankType."_RankScore";
    $DBLadderPos = $RankType."_LadderPos";
    $DBisPred = $RankType."_isPred";
    
    $RankFile = json_decode(file_get_contents("./GameData/".$RankType."_RankPosition.json"), true);
    $Legendfile = json_decode(file_get_contents("./GameData/Legends.json"), true);

    function platform() {
        if(isset($_GET['PC'])) return "PC";
        if(isset($_GET['Xbox'])) return "X1";
        if(isset($_GET['PlayStation'])) return "PS4";

        return "PC";
    }

    function platformText() {
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

    $amount = 25;
    $offset = ($page - 1) * $amount;
    $totalRows = mysqli_fetch_array(mysqli_query($DBConn, "SELECT COUNT(*) FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBRankScore` >= ".$RankFile['Platinum']))[0];
    $pages = ceil($totalRows / $amount);

    $minPred = mysqli_fetch_assoc(mysqli_query($DBConn, "SELECT `$DBRankScore` FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBisPred` = '1' ORDER BY `$DBLadderPos` DESC LIMIT 1"));

    $playerList = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBRankScore` >= ".$RankFile['Platinum']." AND not(`$DBRankScore` >= ".$minPred[$DBRankScore]." and `$DBisPred` != '1') ORDER BY `$DBLadderPos` ASC, `$DBRankScore` DESC LIMIT $offset, $amount");

    function checkPage() {
        if(isset($_GET['PC'])) return "?PC&";
        if(isset($_GET['PlayStation'])) return "?PlayStation&";
        if(isset($_GET['Xbox'])) return "?Xbox&";

        return "?";
    }

    function checkRank($isPred, $score, $file) {
        if($isPred == "1") return "Predator";

        if($score < $file['Diamond']) return "Platinum";
        if($score < $file['Master']) return "Diamond";

        return "Master";
    }

    function rankText($isPred, $score, $file, $type) {
        if($isPred == "1") return "Apex Predator &#8212; <b>".number_format($score)." ".$type."</b>";

        if($score < $file['Diamond']) return "Platinum &#8212; <b>".number_format($score)." ".$type."</b>";
        if($score < $file['Master']) return "Diamond &#8212; <b>".number_format($score)." ".$type."</b>";

        return "Master &#8212; <b>".number_format($score)." ".$type."</b>";
    }

    function checkPos($pos) {
        if($pos > "750" || $pos == "-1") return "N/A";

        return "#".$pos;
    }

    function nickname($nick, $legend, $level) {
        if($nick != null) return $nick;

        return $legend."#".$level;
    }

    function posStyle($pos) {
        if($pos == "1") return "First";
        if($pos == "2") return "Second";
        if($pos == "3") return "Third";

        return;
    }

    include_once("./include/header.php");
?>

<div class="container">
    <div class="top">
        <span class="item i1" style="flex-basis: 5%;"><span class="inner">#</span></span>
        <span class="item i2" style="flex-basis: 44%;"><span class="inner">Name</span></span>
        <span class="item i2" style="flex-basis: 16%;"><span class="inner">Account Level</span></span>
        <span class="item i2" style="flex-basis: 35%;"><span class="inner">Rank &#8212; Score</span></span>
    </div>

    <?php
        while($player = mysqli_fetch_assoc($playerList)) {
            $levelIcon = '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Level.png" class="icon" />';
            $rankIcon = '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/'.checkRank($player[$DBisPred], $player[$DBRankScore], $RankFile).'.png" class="icon" />';

            echo '<div class="list '.checkRank($player[$DBisPred], $player[$DBRankScore], $RankFile).' '.posStyle($player[$DBLadderPos]).'">';
                echo '<span class="item bold" style="flex-basis: 5%;"><span class="inner">'.checkPos($player[$DBLadderPos]).'</span></span>';
                echo '<span class="item" style="flex-basis: 44%;"><span class="inner"><a href="#">'.nickname($player['PlayerNick'], $Legendfile[$player['Legend']]['Name'], $player['PlayerLevel']).'</a></span></span>';
                echo '<span class="item" style="flex-basis: 16%;">'.$levelIcon.'<span class="inner">Level <b>'.number_format($player['PlayerLevel']).'</b></span></span>';
                echo '<span class="item" style="flex-basis: 35%;">'.$rankIcon.'<span class="inner">'.rankText($player[$DBisPred], $player[$DBRankScore], $RankFile, scoreType($RankType)).'</span></span>';
            echo '</div>';
        }
    ?>

    <div class="pagination">
        <a href="<?php echo checkPage(); ?>page=1" class="page <?php if($page == 1) { echo 'disabled'; } ?>"><i class="fas fa-angle-double-left"></i> First</a>
        <a href="<?php echo checkPage(); if($page <= 1) { echo '#'; } else { echo 'page='.($page - 1); } ?>" class="page <?php if($page <= 1) { echo 'disabled'; } ?>"><i class="fas fa-angle-left"></i> Previous</a>
        <a href="<?php echo checkPage(); if($page >= $pages) { echo '#'; } else { echo 'page='.($page + 1); } ?>" class="page <?php if($page >= $pages) { echo 'disabled'; } ?>">Next <i class="fas fa-angle-right"></i></a>
        <a href="<?php echo checkPage(); ?>page=<?php echo $pages; ?>" class="page <?php if($page >= $pages) { echo 'disabled'; } ?>">Last <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>
