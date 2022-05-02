<?php
    $splitOneQuery = mysqli_query($DBConn, "SELECT * FROM `$RankPeriod01` WHERE `PlayerID` = '$UID'");
    $splitOneInfo = mysqli_fetch_assoc($splitOneQuery);
    $splitTwoQuery = mysqli_query($DBConn, "SELECT * FROM `$RankPeriod02` WHERE `PlayerID` = '$UID'");
    $splitTwoInfo = mysqli_fetch_assoc($splitTwoQuery);

    function rankImage($pred, $pos, $score, $type) {
        $ScoreFile = json_decode(file_get_contents("./GameData/".$type."_RankPosition.json"), true);

        if($score == 0) return "Unranked";

        if($pred == 1) return "Apex Predator";

        if($score < $ScoreFile['Silver']) return "Bronze";
        if($score < $ScoreFile['Gold']) return "Silver";
        if($score < $ScoreFile['Platinum']) return "Gold";
        if($score < $ScoreFile['Diamond']) return "Platinum";
        if($score < $ScoreFile['Master']) return "Diamond";

        return "Master";
    }

    function rankName($pred, $pos, $score, $type, $noMaster) {
        $ScoreFile = json_decode(file_get_contents("./GameData/".$type."_RankPosition.json"), true);

        if($score == 0) return "Unranked";

        if($pred == 1) return "[#".$pos."] Apex Predator";

        if($type == "BR") {
            $rankDiv = brRankDiv($score);
        }else{
            $rankDiv = arenasRankDiv($score);
        }

        if($score < $ScoreFile['Silver']) return "Bronze ".$rankDiv;
        if($score < $ScoreFile['Gold']) return "Silver ".$rankDiv;
        if($score < $ScoreFile['Platinum']) return "Gold ".$rankDiv;
        if($score < $ScoreFile['Diamond']) return "Platinum ".$rankDiv;
        if($score < $ScoreFile['Master']) return "Diamond ".$rankDiv;

        if($noMaster == 1) {
            return "Master";
        }else{
            return "[#".number_format($pos)."] Master";
        }
        
    }

    function rankInfo($con, $split, $id, $type, $noMaster) {
        $splitQuery = mysqli_query($con, "SELECT * FROM `$split` WHERE `PlayerID` = '$id'");
        $splitInfo = mysqli_fetch_assoc($splitQuery);

        if($type == "BR") {
            $suffix = "RP";
        }else{
            $suffix = "AP";
        }

        if(mysqli_num_rows($splitQuery) < 1) {
            return '<span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/'.$type.'/Unranked.png" /></span>
            <span class="top">0 '.$suffix.'</span>
            <span class="bottom">Unranked</span>';
        }else{
            $isPred = $splitInfo[$type."_isPred"];
            $ladderPos = $splitInfo[$type."_LadderPos"];
            $rankScore = $splitInfo[$type."_RankScore"];

            return '<span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankBadges/'.$type.'/'.rankImage($isPred, $ladderPos, $rankScore, $type).'.png" /></span>
            <span class="top">'.number_format($rankScore).' '.$suffix.'</span>
            <span class="bottom">'.rankName($isPred, $ladderPos, $rankScore, $type, $noMaster).'</span>';
        }
    }
