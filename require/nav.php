<?php
    // Requires
    require_once(__DIR__."/../connect.php");

    // Database Connection
    $DBConn = mysqli_connect($host, $user, $pass, $db);

    // Functions
    include_once("./include/functions/misc.php");
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="<?php __DIR__; ?>/../css/main.min.css" />
    <link type="shortcut icon" rel="iamge/x-icon" href="<?php __DIR__; ?>/../favicon.ico" />

    <meta name="author" content="Stryder Dev" />
    <meta name="description" content="<?= type($RankType); ?> Ranked Leaderboards for Apex Legends. View up-to-date rankings for PC, PlayStation, Xbox, and Nintendo Switch." />
    <meta name="keywords" content="apex, apex legends, apex stats, apex legends stats, leaderboard, apex legends leaderboard, apex legends ranked, apex legends masters, apex legends predators, apex legends apex predators, apex predators, preds, predators, masters, leaderboards, ranked" />
</head>

<body>
    
    <nav class="nav">
        nav
    </nav>
