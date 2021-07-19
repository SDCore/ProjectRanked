<?php 
    session_start();
    require_once(__DIR__."/../connect.php");

    function checkActive($page) {
        if ($_SERVER['SCRIPT_NAME'] == $page.".php") return "active";

        return null;
    }
?>

<!DOCTYPE html>

<html>

<head>
    <title><?php if(isset($pageTitle)) { echo $pageTitle." -"; } ?> Apex Legends Ranked Leaderboard</title>

    <link type="text/css" rel="stylesheet" href="<?php __DIR__; ?>/../css/main.min.css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php __DIR__; ?>/../favicon.ico" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    </nav>
