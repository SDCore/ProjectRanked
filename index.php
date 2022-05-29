<?php
    $title = "Home";
    require_once("./include/nav.php");
    include_once("./include/sideNav.php");
    include("./include/rankDiv/preUpdate.php");
    include("./include/rankDiv/postUpdate.php");

    function platform() {
        if(isset($_GET['PC'])) return "PC";
        if(isset($_GET['Xbox'])) return "X1";
        if(isset($_GET['Switch'])) return "SWITCH";
        if(isset($_GET['PlayStation'])) return "PS4";

        return "PC";
    }

    function platformText() {
        if(isset($_GET['PC'])) return "PC";
        if(isset($_GET['Xbox'])) return "Xbox";
        if(isset($_GET['Switch'])) return "Nintendo Switch";
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

    $minPred = mysqli_fetch_assoc(mysqli_query($DBConn, "SELECT $DBRankScore, $DBLadderPos FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBisPred` = '1' ORDER BY `$DBLadderPos` DESC LIMIT 1"));

    $amount = 25;
    $offset = ($page - 1) * $amount;
    $totalRows = mysqli_fetch_array(mysqli_query($DBConn, "SELECT COUNT(*) FROM `$CurrentRankPeriod` WHERE `Platform` = '".platform()."' AND `$DBRankScore` >= '".$RankFile['Platinum']."' AND NOT(`$DBRankScore` >= '".$minPred[$DBRankScore]."' AND `$DBisPred` != '1') AND NOT (`$DBInactive` = '1')"))[0];
    $pages = ceil($totalRows / $amount);

    $playerList = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBRankScore` >= ".$RankFile['Platinum']." AND NOT(`$DBRankScore` >= ".$minPred[$DBRankScore]." AND `$DBisPred` != '1') AND NOT (`$DBInactive` = '1') ORDER BY `$DBRankScore` DESC, `$DBLadderPos` ASC LIMIT $offset, $amount");

    $predCount = mysqli_fetch_array(mysqli_query($DBConn, "SELECT COUNT(*) FROM $CurrentRankPeriod WHERE `Platform` = '".platform()."' AND `$DBisPred` = '1'"))[0];

    function checkPage() {
        if(isset($_GET['PC'])) return "?PC&";
        if(isset($_GET['PlayStation'])) return "?PlayStation&";
        if(isset($_GET['Xbox'])) return "?Xbox&";
        if(isset($_GET['Switch'])) return "?Switch&";

        return "?";
    }

    function checkRank($isPred, $score, $file) {
        if($isPred == "1") return "Apex Predator";

        if($score < $file['Diamond']) return "Platinum";
        if($score < $file['Master']) return "Diamond";

        return "Master";
    }

    function rankText($isPred, $score, $file, $type, $rankType) {
        if($isPred == "1") return "Apex Predator &#8212; <b>".number_format($score)." ".$type."</b>";

        if($rankType == "BR") {
            $rankDiv = brRankDivPostUpdate($score);
        }else{
            $rankDiv = arenasRankDivPostUpdate($score);
        }

        if($score < $file['Diamond']) return "Platinum ".$rankDiv." &#8212; <b>".number_format($score)." ".$type."</b>";
        if($score < $file['Master']) return "Diamond ".$rankDiv." &#8212; <b>".number_format($score)." ".$type."</b>";

        return "Master &#8212; <b>".number_format($score)." ".$type."</b>";
    }

    function checkPos($pos, $score, $type) {
        if($type == "BR") {
            if($score < 15000 || $pos == "-1") return "N/A";

            return "#".number_format($pos);
        }

        if($type == "Arenas") {
            if($score < 8000 || $pos == "-1") return "N/A";

            return "#".number_format($pos);
        }
    }

    function posStyle($pos) {
        if($pos == "1") return "First";
        if($pos == "2") return "Second";
        if($pos == "3") return "Third";

        return;
    }

    function isOnline($status) {
        if ($status == 1) {
            return "<span class='lobby'><i class='fa-solid fa-circle'></i></span>";
        }

        return "<span class='offline'><i class='fa-solid fa-circle'></i></span>";
    }

    function scoreChange($current, $prev) {
        if($current < $prev) {
            return '<span class="prev neg"><i class="fa-solid fa-angle-down"></i></span>';
        }else if($current > $prev) {
            return '<span class="prev posi"><i class="fa-solid fa-angle-up"></i></span>';
        }else{
            return '<span class="prev"><i class="fa-solid fa-equals"></i></span>';
        }
    }

    include_once("./include/header.php");
?>

<div class="container">
    <div class="top">
        <span class="item i1"><span class="inner">#</span></span>
        <span class="item i2"><span class="inner">Name</span></span>
        <span class="item i2"><span class="inner">Account Level</span></span>
        <span class="item i2"><span class="inner">Rank &#8212; Score</span></span>
    </div>

    <?php
        while($player = mysqli_fetch_assoc($playerList)) {
            $levelIcon = '<img src="https://cdn.apexstats.dev/ProjectRanked/Badges/Level.png" class="icon" />';
            $rankIcon = '<img src="https://cdn.apexstats.dev/ProjectRanked/RankedBadges/Season '.$SeasonInfo['number'].'/'.$RankType.'/'.checkRank($player[$DBisPred], $player[$DBRankScore], $RankFile).'.png" class="icon" />';

            echo '<div class="list '.checkRank($player[$DBisPred], $player[$DBRankScore], $RankFile).' '.posStyle($player[$DBLadderPos]).'">';
                echo '<span class="item bold"><span class="inner">'.checkPos($player[$DBLadderPos], $player[$DBRankScore], $RankType).'</span></span>';
                echo '<span class="item"><span class="inner"><a href="/user/'.$player['PlayerID'].'">'.isOnline($player['PlayerStatus']).' '.nickname($player['PlayerNick'], $Legendfile[$player['Legend']], $player['PlayerLevel']).'</a></span></span>';
                echo '<span class="item">'.$levelIcon.'<span class="inner">Level <b>'.number_format($player['PlayerLevel']).'</b></span></span>';
                echo '<span class="item">'.$rankIcon.'<span class="inner">'.rankText($player[$DBisPred], $player[$DBRankScore], $RankFile, scoreType($RankType), $RankType).' '.scoreChange($player[$DBRankScore], $player[$DBRankScorePrev]).'</span></span>';
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
