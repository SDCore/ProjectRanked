<?php session_start(); require_once(__DIR__."/../connect.php"); ?>

<!DOCTYPE html>

<html>

<head>
    <title>Apex Legends Ranked Leaderboard</title>

    <link type="text/css" rel="stylesheet" href="<?php __DIR__; ?>/../css/main.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="inner">
            <a class="brand" href="/"><span class="text">Apex Ranked</span></a>
            <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/index.php") ? 'active':''; ?>" href="/"><span class="text">Home</span></a>
            <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/search.php") ? 'active':''; ?>" href="/search"><span class="text">Player Search</span></a>
            <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/about.php") ? 'active':''; ?>" href="/about"><span class="text">About</span></a>
            <a class="link <?= ($_SERVER['SCRIPT_NAME']=="/faq.php") ? 'active':''; ?>" href="/faq"><span class="text">FAQ</span></a>
        </div>
    </nav>
