<?php 
    require_once("./include/nav.php");

    if(!isset($_GET['platform'])) {
        $platform = "PC";
        $platformText = "PC";
    }else if($_GET['platform'] == "PC") {
        $platform = "PC";
        $platformText = "PC";
    }else if($_GET['platform'] == "X1") {
        $platform = "X1";
        $platformText = "Xbox";
    }else if($_GET['platform'] == "PS4") {
        $platform = "PS4";
        $platformText = "PlayStation";
    }else{
        $platform = "PC";
        $platformText = "PC";
    }

    $DBConn = mysqli_connect($host, $user, $pass, $db);

    $rankedQuery = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' ORDER BY `BR_LadderPos` ASC, `BR_RankScore` DESC");
    $minimumPred = mysqli_query($DBConn, "SELECT * FROM projectRanked WHERE `Platform` = '$platform' AND `BR_isPred` = '1' ORDER BY `BR_LadderPos` DESC LIMIT 1");
?>

<div class="containerTitle">
    <span class="left">Ranked Stats for <?php echo $platformText; ?></span>
    <span class="right"><a href="?platform=PC" class="<?php if($platform == 'PC') { echo 'active'; } ?>">PC</a><a href="?platform=PS4" class="<?php if($platform == 'PS4') { echo 'active'; } ?>">PS4</a><a href="?platform=X1" class="<?php if($platform == 'X1') { echo 'active'; } ?>">X1</a></span>
</div>

<div class="minimumPred">Approximate Minimum RP for Pred: <?php while($row = mysqli_fetch_assoc($minimumPred)) { echo number_format($row['BR_RankScore']); } ?></div>

<div class="container">
    <!-- #0 \ Name \ Level \ Rank \ RP \ Socials -->
    <div class="title">
        <span class="item i1"><span class="text">#</span></span>
        <span class="item i2"><span class="text">Name</span></span>
        <span class="item i2"><span class="text">Account Level</span></span>
        <span class="item i2"><span class="text">Rank (Score)</span></span>
        <span class="item i2"><span class="text">Socials</span></span>
    </div>
</div>

    <!-- content -->
    <!-- top 750 on pc - top 750 on ps4 - top 750 on xbox -->

    <!-- news -->
    <!-- apex news -->

    <!-- featured stream(?) -->
    <!-- featured twitch stream -->

<?php require_once("./include/footer.php"); ?>
