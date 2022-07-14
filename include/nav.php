<?php 
    session_start();
    require_once(__DIR__."/../connect.php");

    if($debug == true) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    $DBConn = mysqli_connect($host, $user, $pass, $db);

    $SeasonInfo = mysqli_fetch_array(mysqli_query($DBConn, "SELECT * FROM seasonInfo")) or die(mysqli_error($DBConn));
    $Legendfile = json_decode(file_get_contents(__DIR__."/../GameData/legends.json"), true);
    $RankFile = json_decode(file_get_contents(__DIR__."/../GameData/New_RankData/".$RankType."_RankPosition.json"), true);

    function active($page) {
        if ($_SERVER['SCRIPT_NAME'] == $page.".php") return "active";

        return "link";
    }

    function rankType($type) {
        if($type == "BR") return "Battle Royale";
        if($type == "Arenas") return "Arenas";
    }

    function nickname($nick, $legend, $level) {
        if($nick != null) return htmlspecialchars($nick);

        return $legend."#".$level;
    }

    function userTitle($db, $rank, $id) {
        $userRequest = mysqli_query($db, "SELECT * FROM $rank WHERE `PlayerID` = '$id'");
        $userQuery = mysqli_fetch_assoc($userRequest);
        $Legendfile = json_decode(file_get_contents("./GameData/legends.json"), true);

        if($id == 0 || mysqli_num_rows($userRequest) < 1) { 
            echo "<title>N/A &#8212; Apex Legends Ranked Leaderboards</title>";
        }else{
            echo "<title>".nickname($userQuery['PlayerNick'], $Legendfile[$userQuery['Legend']], $userQuery['PlayerLevel'])." &#8212; Apex Legends Ranked Leaderboards</title>";
        }
    }

    $CurrentRankPeriod = "Ranked_S0".$SeasonInfo['number']."_0".$SeasonInfo['currentSplit'];
    $RankPeriod01 = "Ranked_S0".$SeasonInfo['number']."_01";
    $RankPeriod02 = "Ranked_S0".$SeasonInfo['number']."_02";
    $DBRankScore = $RankType."_RankScore";
    $DBRankScorePrev = $RankType."_RankScorePrev";
    $DBLadderPos = $RankType."_LadderPos";
    $DBisPred = $RankType."_isPred";
    $DBInactive = $RankType."_Inactive";
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
        if($title == "User") {
            userTitle($DBConn, $CurrentRankPeriod, $_GET['id']);
        }else{
            echo "<title>".$title." &#8212; Apex Legends Ranked Leaderboards</title>";
        }
    ?>

    <link type="text/css" rel="stylesheet" href="<?php __DIR__; ?>/../css/main.min.css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php __DIR__; ?>/../favicon.ico" />

    <meta name="author" content="SDCore" />
    <meta name="description" content="Ranked Leaderboards for Apex Legends. View up-to-date rankings for PC, PlayStation, Xbox, and Nintendo Switch."/>
    <meta name="keywords" content="apex, apex legends, apex stats, apex legends stats, leaderboard, apex legends leaderboard, apex legends ranked, apex legends masters, apex legends predators, apex legends apex predators, apex predators, preds, predators, masters, leaderboards, ranked" />

    <?php
        if($debug == false) {
            if($RankType == "BR") require_once(__DIR__."/../analytics/BR.html");
            if($RankType == "Arenas") require_once(__DIR__."/../analytics/Arenas.html");

            $homeLink = "https://ranked.apexstats.dev/";
        }else{
            $homeLink = "/";
        }
    ?>
</head>

<body>
    <nav class="nav">
        <a href="<?php echo $homeLink; ?>" class="brand">
            <span class="inner">
                <span class="top"><?php echo $SeasonInfo['name']; ?></span>
                <span class="bottom"><?php echo rankType($RankType); ?></span>
            </span>
        </a>
        <a href="/" class="<?php echo active('/index'); ?>"><span class="inner">Home</span></a>
        <!-- <a href="/history/index" class="link"><span class="inner">History</span></a> -->
        <a href="/search" class="<?php echo active('/search'); ?>"><span class="inner">Search</span></a>
        <!-- <a href="/stats" class="link"><span class="inner">Stats</span></a> -->
        <a href="/faq" class="<?php echo active('/faq'); ?>"><span class="inner">FAQ</span></a>
        <!-- <a href="#" class="link disabled"><span class="inner">Submit</span></a>
        <a href="#" class="link disabled"><span class="inner">Discord <i class="fas fa-external-link-alt" style="font-size: 10pt;"></i></span></a> -->
    </nav>
