<?php 
    require_once(__DIR__."/../connect.php");

    $DBConn = mysqli_connect($host, $user, $pass, $db);

    $NavInfo = mysqli_fetch_array(mysqli_query($DBConn, "SELECT * FROM seasonInfo")) or die(mysqli_error($DBConn));

    function active($page) {
        if ($_SERVER['SCRIPT_NAME'] == $page.".php") return "active";

        return "link";
    }

    function rankType($type) {
        if($type == "BR") return "Battle Royale";
        if($type == "Arenas") return "Arenas";
    }
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?> &#8212; Apex Legends Ranked Leaderboards</title>

    <link type="text/css" rel="stylesheet" href="<?php __DIR__; ?>/../css/main.min.css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php __DIR__; ?>/../favicon.ico" />

    <?php
        if($debug == false) {
            if($RankType == "BR") require_once(__DIR__."/../analytics/BR.html");
            if($RankType == "Arenas") require_once(__DIR__."/../analytics/Arenas.html");
        }
    ?>
</head>

<body>
    <nav class="nav">
        <a href="https://ranked.apexstats.dev/" class="brand">
            <span class="inner">
                <span class="top"><?php echo $NavInfo['name']; ?></span>
                <span class="bottom"><?php echo rankType($RankType); ?></span>
            </span>
        </a>
        <a href="/" class="<?php echo active('/index'); ?>"><span class="inner">Home</span></a>
        <a href="#" class="link disabled"><span class="inner">History</span></a>
        <a href="#" class="link disabled"><span class="inner">Search</span></a>
        <a href="/faq" class="<?php echo active('/faq'); ?>"><span class="inner">F.A.Q.</span></a>
        <a href="#" class="link disabled"><span class="inner">Submit</span></a>
        <a href="#" class="link disabled"><span class="inner">Discord</span></a>
    </nav>
