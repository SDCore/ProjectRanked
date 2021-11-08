<?php require_once(__DIR__."/../connect.php"); ?>

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
            if($GoogleAnalytics == "BR") require_once(__DIR__."/../analytics/BR.html");
            if($GoogleAnalytics == "Arenas") require_once(__DIR__."/../analytics/Arenas.html");
        }
    ?>
</head>

<body>
    <nav class="nav">
        <a href="https://ranked.apexstats.dev/" class="brand">
            <span class="text">
                <span class="top">Season Name</span>
                <span class="bottom">Ranked Type</span>
            </span>
        </a>
    </nav>
