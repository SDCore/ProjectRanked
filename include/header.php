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
    <div class="top"><?= platformText(); ?> Ranked Stats</div>
    <div class="middle"><b><?= $SeasonInfo['name']; ?></b> &#8212; Split <?= $SeasonInfo['currentSplit']; ?></div>
    <div class="stats">
        <span class="threshold">Predator Threshold: <?= number_format(minPred($minPred[$DBRankScore], $RankType, $DBRankScore, $RankFile['Master'])); ?> <?= scoreType($RankType); ?></span>
        <!-- <span class="predCount">Apex Predator Count: <?= $predCount; ?></span> -->
        <span class="playerCount">Based on <?= $totalRows; ?> <?= platformText() ?> Players</span>
    </div>
</div>
