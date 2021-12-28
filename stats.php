<?php
    $title = "Stats";
    require_once("./include/nav.php");

    function getRankedDist($con, $less, $greater, $type, $current, $pred, $min, $plat, $pos) {
        $minPred = mysqli_fetch_assoc(mysqli_query($con, "SELECT `$type` FROM $current WHERE `Platform` = '$platform' AND `$pred` = '1' ORDER BY `$pos` DESC LIMIT 1"));

        $query = "SELECT COUNT(*) FROM $current WHERE `$type` < $less AND `$type` >= $greater AND `$pred` = '0' AND NOT(`$type` >= '$minPred' AND `$DBisPred` != '1')";

        return mysqli_fetch_array(mysqli_query($con, $query))[0];
    }
?>

<div class="container">
    <div id="rankedDistribution"></div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<script>
    Highcharts.chart('rankedDistribution', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Title'
        },
        series: [{
            name: "Stats",
            data: [
                <?php echo getRankedDist($DBConn, "1200", "0", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", $minPred['BR_RankScore'], "PC", "BR_LadderPos"); ?>,
                <?php echo getRankedDist($DBConn, "2800", "1200", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", $minPred['BR_RankScore'], "PC", "BR_LadderPos"); ?>,
                <?php echo getRankedDist($DBConn, "4800", "2800", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", $minPred['BR_RankScore'], "PC", "BR_LadderPos"); ?>,
                <?php echo getRankedDist($DBConn, "7200", "4800", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", $minPred['BR_RankScore'], "PC", "BR_LadderPos"); ?>,
                <?php echo getRankedDist($DBConn, "10000", "7200", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", $minPred['BR_RankScore'], "PC", "BR_LadderPos"); ?>
            ]
        }]
    });
</script>

<?php require_once("./include/footer.php"); ?>
