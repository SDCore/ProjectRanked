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

    function timeTextHeader($time, $text) {
        if($time > 1 || $time == 0) return $time." ".$text."\s";

        return $time." ".$text;
    }

    function splitTimestamp($time) {
        $timestamp = $time - time();

        return gmdate(timeTextHeader("d", "\d\a\y").", ".timeTextHeader("h", "\h\o\u\\r").", ".timeTextHeader("i", "\m\i\\n\u\\t\\e"), $timestamp);
    }
?>

<div class="header">
    <div class="top"><?= platformText(); ?> Ranked Stats</div>
    <div class="middle"><b><?= $SeasonInfo['name']; ?></b> &#8212; Split <?= $SeasonInfo['currentSplit']; ?></div>
    <div class="stats">
        <span class="threshold">Predator Threshold: <?= number_format(minPred($minPred[$DBRankScore], $RankType, $DBRankScore, $RankFile['Master'])); ?> <?= scoreType($RankType); ?></span>
        <span class="splitTime"><?= splitTimestamp($SeasonInfo['end']); ?></span>
        <span class="playerCount">Based on <?= $totalRows; ?> <?= platformText() ?> Players</span>
    </div>
</div>
