<?php
    $pageTitle = "Home"; require_once("./include/nav.php");

    // Detecting which platform to use for title
    if(isset($_GET['PC'])) {
        $platform = "PC";
        $text = "PC";
    }else if(isset($_GET['X1'])) {
        $platform = "X1";
        $text = "Xbox";
    }else if(isset($_GET['PS4'])) {
        $platform = "PS4";
        $text = "PlayStation";
    }else{
        $platform = "PC";
        $text = "PC";
    }

    // Pagination
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    $records = 50;
    $offset = ($page - 1) * $records;
    $totalPlayers = mysqli_query($DBConn, "SELECT COUNT(*) FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000");
    $totalRows = mysqli_fetch_array($totalPlayers)[0];
    $totalPages = ceil($totalRows / $records);
    
    $rankedQuery = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 ORDER BY `$ladderPos` ASC, `$RankScore` DESC LIMIT $offset, $records");

    // Minimum amount to reach Apex Predator
    $minimumPred = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `$RankScore` >= 10000 AND `$isPred` = '1' ORDER BY `$ladderPos` DESC LIMIT 1");
?>

<?php
    while($player = mysqli_fetch_assoc($rankedQuery)) {
        echo $player[$ladderPos];
    }
?>

<?php require_once("./include/footer.php"); ?>
