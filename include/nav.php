<?php 
    session_start();
    require_once(__DIR__."/../connect.php");

    $DBConn = mysqli_connect($host, $user, $pass, $db);

    if ($_SERVER['SCRIPT_NAME']=="/user.php") {
        $PID = $_GET['id'];
        $getPlayer = mysqli_query($DBConn, "SELECT * FROM `$DB_RankPeriod` WHERE `PlayerID` = '$PID'");
        $player = mysqli_fetch_assoc($getPlayer);

        if(mysqli_num_rows($getPlayer) < 1) {
            $pageTitle = "N/A";
        }else{
            $legendFile = file_get_contents("./GameData/legends.json");
            $legendIDs = json_decode($legendFile, true);

            if($player['PlayerNick'] == null) {
                $pageTitle = $legendIDs[$player['Legend']]['Name']."#".$player['PlayerLevel'];
            }else{
                $pageTitle = $player['PlayerNick'];
            }
        }
    }

    function checkActive($page) {
        if ($_SERVER['SCRIPT_NAME'] == $page.".php") return "active";

        return null;
    }
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php if(isset($pageTitle)) { echo $pageTitle." &#8212;"; } ?> Apex Legends <?php echo $typeTitle; ?> Ranked Leaderboard</title>

    <link type="text/css" rel="stylesheet" href="<?php __DIR__; ?>/../css/main.min.css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php __DIR__; ?>/../favicon.ico" />

    <meta name="author" content="SDCore" />
    <meta name="description" content="Ranked Leaderboards for Apex Legends. View Master and Apex Predator rankings for PC, PlayStation, and Xbox."/>
    <meta name="keywords" content="apex, apex legends, apex stats, apex legends stats, leaderboard, apex legends leaderboard, apex legends ranked, apex legends masters, apex legends predators, apex legends apex predators, apex predators, preds, predators, masters, leaderboards, ranked" />

    <?php
        if($debug == false) {
            if($GoogleAnalytics == "BR") require_once(__DIR__."/../analytics/BR.html");
            if($GoogleAnalytics == "Arenas") require_once(__DIR__."/../analytics/Arenas.html");
        }
    ?>
</head>

<body>

    <nav class="nav">
        <a href="https://ranked.apexstats.dev/" class="brand"><span class="text"><?php echo $typeTitle; ?></span></a>
        <a href="/" class="link <?php echo checkActive('/index'); ?>"><span class="text">Home</span></a>
        <a href="#" class="link <?php echo checkActive('/search'); ?> disabled"><span class="text">Search</span></a>
        <a href="#" class="link <?php echo checkActive('/faq'); ?> disabled"><span class="text">F.A.Q.</span></a>
        <a href="#" class="link disabled" target="_blank"><span class="text">Discord</span></a>
    </nav>
