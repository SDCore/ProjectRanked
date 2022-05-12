<?php
    $splitOneQuery = mysqli_query($DBConn, "SELECT * FROM `$RankPeriod01` WHERE `PlayerID` = '$UID'");
    $splitOneInfo = mysqli_fetch_assoc($splitOneQuery);
    $splitTwoQuery = mysqli_query($DBConn, "SELECT * FROM `$RankPeriod02` WHERE `PlayerID` = '$UID'");
    $splitTwoInfo = mysqli_fetch_assoc($splitTwoQuery);

    function rankInfoPostUpdate($con, $season, $split, $type, $id, $master) {
        $split = mysqli_query($con, "SELECT * FROM `Ranked_S0".$season."_0".$split."` WHERE `PlayerID` = '$id'");
        $info = mysqli_fetch_assoc($split);

        $season = "Season ".$season;

        if($type == "BR") {
            $suffix = "RP";
        }else{
            $suffix = "AP";
        }
        
        if(mysqli_num_rows($split) < 1) {
            return '
                <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankedBadges/'.$type.'_Unranked.png" /></span>
                <span class="top">0 '.$suffix.'</span>
                <span class="bottom">Unranked</span>
            ';
        }

        $isPred = $info[$type."_isPred"];
        $ladderPos = $info[$type."_LadderPos"];
        $rankScore = $info[$type."_RankScore"];

        return '
            <span class="image"><img src="https://cdn.apexstats.dev/ProjectRanked/RankedBadges/'.rankImagePostUpdate($isPred, $ladderPos, $rankScore, $season, $type).'.png" /></span>
            <span class="top">'.number_format($rankScore).' '.$suffix.'</span>
            <span class="bottom">'.rankNamePostUpdate($isPred, $ladderPos, $rankScore, $type, $master).'</span>
        ';
    }

    function rankNamePostUpdate($pred, $pos, $score, $type, $master) {
        $file = json_decode(file_get_contents("./GameData/New_RankData/".$type."_RankPosition.json"), true);

        if($type == "BR") {
            if($score == 0) return "Rookie";
        }else{
            if($score == 0) return "Unranked";
        }

        if($pred == 1) return "[#".$pos."] Apex Predator";

        if($type == "BR") {
            $rankDiv = brRankDivPostUpdate($score);

            if($score < $file['Bronze']) return "Rookie ".$rankDiv;
            if($score < $file['Silver']) return "Bronze ".$rankDiv;
            if($score < $file['Gold']) return "Silver ".$rankDiv;
            if($score < $file['Platinum']) return "Gold ".$rankDiv;
            if($score < $file['Diamond']) return "Platinum ".$rankDiv;
            if($score < $file['Master']) return "Diamond ".$rankDiv;
        }else{
            $rankDiv = arenasRankDivPostUpdate($score);

            if($score < $file['Silver']) return "Bronze ".$rankDiv;
            if($score < $file['Gold']) return "Silver ".$rankDiv;
            if($score < $file['Platinum']) return "Gold ".$rankDiv;
            if($score < $file['Diamond']) return "Platinum ".$rankDiv;
            if($score < $file['Master']) return "Diamond ".$rankDiv;
        }

        if($master == 1) return "[#".number_format($pos)."] Master";;

        return "Master";
    }

    function rankImagePostUpdate($pred, $pos, $score, $season, $type) {
        $file = json_decode(file_get_contents("./GameData/New_RankData/".$type."_RankPosition.json"), true);

        if($score == "0") return $type."_Unranked";

        if($pred == 1) return $season."/".$type."/Apex Predator";

        if($type == "BR") {
            if($score < $file['Bronze']) return $season."/".$type."/Rookie";
        }

        if($score < $file['Silver']) return $season."/".$type."/Bronze";
        if($score < $file['Gold']) return $season."/".$type."/Silver";
        if($score < $file['Platinum']) return $season."/".$type."/Gold";
        if($score < $file['Diamond']) return $season."/".$type."/Platinum";
        if($score < $file['Master']) return $season."/".$type."/Diamond";

        return $season."/".$type."/Master";
    }

    function currentRank($id, $platform, $score, $type, $season, $opts) {
        $file = file_get_contents("https://api.apexstats.dev/id?platform=".$platform."&id=".$id, false, stream_context_create($opts));

        $rank = json_decode($file, true);

        $BR = $rank['ranked']['BR'];
        $Arenas = $rank['ranked']['Arenas'];

        if($type == "BR") {
            return '
                <span class="image">
                    <img src="https://cdn.apexstats.dev/ProjectRanked/RankedBadges/Season '.$season.'/'.$type.'/'.$BR['name'].'.png" />
                </span>
                <span class="top">
                    <span class="current">'.number_format($BR['score']).' RP
                    '.change($BR['score'], $score, "RP").'</span>
                </span>
                <span class="bottom">'.rankNamePostUpdate(checkLadderPos($BR['ladderPos']), $BR['ladderPos'], $BR['score'], "BR", 1).'</span>
            ';
        }else{
            if($Arenas['name'] == "Unranked") {
                $image = 'https://cdn.apexstats.dev/ProjectRanked/RankedBadges/Arenas_Unranked.png';
            }else{
                $image = 'https://cdn.apexstats.dev/ProjectRanked/RankedBadges/Season '.$season.'/'.$type.'/'.$Arenas['name'].'.png';
            }

            return '
                <span class="image">
                    <img src="'.$image.'" />
                </span>
                <span class="top">
                    <span class="current">'.number_format($Arenas['score']).' AP
                    '.change($Arenas['score'], $score, "AP").'</span>
                </span>
                <span class="bottom">'.rankNamePostUpdate(checkLadderPos($Arenas['ladderPos']), $Arenas['ladderPos'], $Arenas['score'], "Arenas", 1).'</span>
            ';
        }
    }
