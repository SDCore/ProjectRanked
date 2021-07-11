<?php session_start(); require_once(__DIR__."/../connect.php"); ?>

<!DOCTYPE html>

<html>

<head>
    <title><?php echo $pageTitle; ?> - Apex Legends Ranked Leaderboard</title>

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link type="text/css" rel="stylesheet" href="<?php __DIR__; ?>/../css/main.css" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ranked Leaderboards for Apex Legends. View Masters and Apex Predator rankings for PC, PlayStation, and Xbox."/>
    <meta name="keywords" content="apex, apex legends, apex stats, apex legends stats, leaderboard, apex legends leaderboard, apex legends ranked, apex legends masters, apex legends predators, apex legends apex predators, apex predators, preds, predators, masters, leaderboards, ranked" />

    <?php
        if($debug == false) {
            if($GoogleAnalytics == "BR") require_once(__DIR__."/../analytics/BR.html");
            if($GoogleAnalytics == "Arenas") require_once(__DIR__."/../analytics/Arenas.html");
        }
    ?>
</head>

<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="inner">
            <a class="brand" href="/"><span class="text">Apex Ranked</span></a>
            <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/index.php") ? 'active':''; ?>" href="/"><span class="text">Home</span></a>
            <!-- <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/search.php") ? 'active':''; ?>" href="/search"><span class="text">Player Search</span></a>
            <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/about.php") ? 'active':''; ?>" href="/about"><span class="text">About</span></a>
            <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/faq.php") ? 'active':''; ?>" href="/faq"><span class="text">FAQ</span></a> -->
        </div>
    </nav>
