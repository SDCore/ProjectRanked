<?php require_once("./include/nav.php"); ?>

<div class="containerTitle">
    Rank Stats for PC
</div>

<div class="container">
    <div class="item">
        <div class="title">Account Level</div>
        <div class="title">Name</div>
        <div class="title">Rank</div>
        <div class="title">RP</div>
        <div class="title">Socials</div>
    </div>

    <?php
        $DBConn = mysqli_connect($host, $user, $pass, $db);
        $rankedQuery = mysqli_query($DBConn, "SELECT * FROM projectRanked ORDER BY `BR_RankScore` DESC");

        function isPred($pred) {
            if($pred == 0) return "Master";

            return "Apex Predator";
        }

        function formatSocial($name, $type) {
            if($name == "N/A") return;

            if($type == "Twitter") return "<a href='https://twitter.com/".$name."'>Twitter</a>";
            if($type == "Twitch") return "<a href='https://twitch.tv/".$name."'>Twitch</a>";

            return;
        }

        while($row = mysqli_fetch_assoc($rankedQuery)) {
            echo '<div class="item">';
                echo '<div class="list"><img src="https://i.imgur.com/vp64kDF.png" class="icon" /> '.$row['PlayerLevel'].'</div>';
                echo '<div class="list"><a href="#">'.$row['PlayerName'].'</a></div>';
                echo '<div class="list">'.isPred($row['BR_isPred']).'</div>';
                echo '<div class="list">'.$row['BR_RankScore'].' RP</div>';
                echo '<div class="list">'.formatSocial($row['Twitter'], "Twitter").' '.formatSocial($row['Twitch'], "Twitch").'</div>';
            echo '</div>';
        }
    ?>
</div>

    <!-- content -->
    top 750 on pc - top 750 on ps4 - top 750 on xbox

    <!-- news -->
    apex news

    <!-- featured stream(?) -->
    featured twitch stream

<?php require_once("./include/footer.php"); ?>
