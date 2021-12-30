<?php
    $title = "Stats";
    require_once("./include/nav.php");

    function getRankedDist($con, $less, $greater, $type, $current, $pred, $plat, $pos) {
        $minPred = mysqli_fetch_assoc(mysqli_query($con, "SELECT `$type` FROM $current WHERE `Platform` = '$plat' AND `$pred` = '1' ORDER BY `$pos` DESC LIMIT 1"));

        $query = "SELECT COUNT(*) FROM $current WHERE `$type` < $less AND `$type` >= $greater AND `$pred` != '1' AND NOT(`$type` >= '$minPred[$type]')";

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
            text: 'PC Rank Tier Distribution'
        },
        xAxis: {
            categories: [
                'Bronze',
                'Silver',
                'Gold',
                'Platinum',
                'Diamond',
                'Master'
            ],
        },
        series: [{
            name: "Rank Tier",
            data: [
                { y: <?php echo getRankedDist($DBConn, "1200", "0", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", "PC", "BR_LadderPos"); ?>, color: "#73482B"},
                { y: <?php echo getRankedDist($DBConn, "2800", "1200", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", "PC", "BR_LadderPos"); ?>, color: "#BEC2CB"},
                { y: <?php echo getRankedDist($DBConn, "4800", "2800", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", "PC", "BR_LadderPos"); ?>, color: "#D4AF37"},
                { y: <?php echo getRankedDist($DBConn, "7200", "4800", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", "PC", "BR_LadderPos"); ?>, color: "#75A4AD"},
                { y: <?php echo getRankedDist($DBConn, "10000", "7200", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", "PC", "BR_LadderPos"); ?>, color: "#396FA1"},
                { y: <?php echo getRankedDist($DBConn, "99999", "10000", "BR_RankScore", $CurrentRankPeriod, "BR_isPred", "PC", "BR_LadderPos"); ?>, color: "#925BC6"}
            ]
        }],
        yAxis: {
            title: {
                text: "Player Count"
            },
        }
    });
</script>

<?php require_once("./include/footer.php"); ?>
