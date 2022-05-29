<?php
    function minPred($min, $type, $amount, $master, $pos) {
        if((int)$pos <= "700") {
            if($type == "BR") return 15000;
            if($type == "Arenas") return 8000;
        }

        if($type == "BR") {
            if($min < $master) return $master;

            return $min;
        }

        if($type == "Arenas") {
            if($min < $master) return $master;

            return $min;
        }
    }

    function textPlural($time, $text) {
        if($time > 1 || $time == 0) return $time." ".$text."s";

        return $time." ".$text;
    }

    function splitTimestamp($time) {
        $time = $time - time();

        $days = floor($time / (60*60*24));//day
        $time %= (60 * 60 * 24);

        $hours = floor($time / (60 * 60));//hour
        $time %= (60 * 60);

        $minutes = floor($time / 60);//min
        $time %= 60;

        return textPlural($days, "day").", ".textPlural($hours, "hour").", ".textPlural($minutes, "minute");
    }

    function getSplitTime($split, $middle, $end) {
        if($split == 1) return $middle;

        return $end;
    }
?>

<div class="header">
    <div class="top"><?= platformText(); ?> Ranked Stats</div>
    <div class="middle"><b><?= $SeasonInfo['name']; ?></b> &#8212; Split <?= $SeasonInfo['currentSplit']; ?></div>
    <div class="stats">
        <span class="threshold">Predator Threshold: <?= number_format(minPred($minPred[$DBRankScore], $RankType, $DBRankScore, $RankFile['Master'], $minPred[$DBLadderPos])); ?> <?= scoreType($RankType); ?></span>
        <!-- <span class="splitTime"><?= splitTimestamp($SeasonInfo['end']); ?></span> -->
        <div id="splitTimer" class="splitTime">- Days, - Hours, - Minutes, - Seconds</div>
        <span class="playerCount">Based on <?= number_format($totalRows); ?> <?= platformText() ?> Players</span>
    </div>
</div>

<script type="text/javascript">
    var date = <?= getSplitTime($SeasonInfo['currentSplit'], $SeasonInfo['split'], $SeasonInfo['end']); ?>;
</script>
<script src="../js/timer.js"></script>


