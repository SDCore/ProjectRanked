<?php
    function minPred($min, $type, $amount, $master) {
        if($type == "BR") {
            if($min < $master) return $master;

            return $min;
        }

        if($type == "Arenas") {
            if($min < $master) return $master;

            return $min;
        }
    }
?>

<div class="header">
    <div class="top">
        <?php echo platformText(); ?> Ranked Stats for <?php echo $SeasonInfo['name']; ?>: Split <?php echo $SeasonInfo['currentSplit']; ?>
    </div>
    <div class="bottom">
    <?php echo scoreType($RankType); ?> Threshold for Apex Predator Based on <?php echo $totalRows; ?> Players: <b><?php echo number_format(minPred($minPred[$DBRankScore], $RankType, $DBRankScore, $RankFile['Master']))." ".scoreType($RankType); ?></b>
    </div>
</div>
