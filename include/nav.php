<DOCTYPE html>

<html>

<head>
    <title>Apex Legends Ranked Leaderboard</title>

    <link type="text/css" rel="stylesheet" href="./css/main.css" />
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
