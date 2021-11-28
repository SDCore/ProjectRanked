<?php
    $title = "User";
    require_once("./include/nav.php");

    if(isset($_GET['id'])) {
        $UID = $_GET['id'];
    }else{
        $UID = 0;
    }

    $playerRequest = mysqli_num_rows(mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `PlayerID` = '$UID'"));
    if($UID == 0 || $playerRequest < 1) { echo '<div class="noPlayer">Player with that ID does not exist.</div>'; return; }

    $splitOneInfo = mysqli_fetch_assoc(mysqli_query($DBConn, "SELECT * FROM `$RankPeriod01` WHERE `PlayerID` = '$UID'"));
    $splitTwoInfo = mysqli_fetch_assoc(mysqli_query($DBConn, "SELECT * FROM `$RankPeriod02` WHERE `PlayerID` = '$UID'"));

    
