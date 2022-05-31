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
    
    <nav class="nav responsive" id="navTop">
        <a href="/" class="brand">
            <span class="inner">
                <span class="top">Season Name</span>
                <span class="bottom">Rank Type</span>
            </span>
        </a>

        <a href="javascript:void(0);" class="icon" onclick="navToggle()">=</a>

        <a href="/" class="link"><span class="inner">Home</span></a>
        <a href="/search" class="link"><span class="inner">Search</span></a>
        <a href="/faq" class="link"><span class="inner">FAQ</span></a>
    </nav>

    <script>
        function navToggle() {
            var nav = document.getElementById("navTop");

            if(nav.className === "nav") {
                nav.className += " responsive";
            }else{
                nav.className = "nav";
            }
        }
    </script>
