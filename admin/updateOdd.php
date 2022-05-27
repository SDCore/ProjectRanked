<?php

    // Hi :) If you're viewing this, please don't super-reverse-engineer it
    // and ruin it. I haven't set up a way to authenticate/rate limit, and I
    // don't want to if I don't have to. This is the simplist way for me to
    // update the rank info, and while I don't mind having to complicate it,
    // I really shouldn't have to. Please keep that in mind.
    //
    // - Love, SDCore <3

    include "../connect.php";
    set_time_limit(0);

    if($debug == true) {
        $streamOpts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];
    }else{
        $streamOpts = [
            "ssl" => [
                "verify_peer"=>true,
                "verify_peer_name"=>true,
            ]
        ];  
    }

    // Create and check connection
    $DBConn = mysqli_connect($host, $user, $pass, $db);

    if(!$DBConn) {
    die("Error: Connection failed. " . mysqli_connect_error());
    }

    $SeasonInfo = mysqli_fetch_array(mysqli_query($DBConn, "SELECT * FROM seasonInfo")) or die(mysqli_error($DBConn));
    $CurrentRankPeriod = "Ranked_S0".$SeasonInfo['number']."_0".$SeasonInfo['currentSplit'];

    $playerCount = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod ORDER BY `id` DESC LIMIT 1");

    while ($row = mysqli_fetch_assoc($playerCount)) {
        $setID = $row['id'];
    }
    

    function isPred($name) {
        if($name == "Apex Predator") return 1;

        return 0;
    }

    function previousPoints($database, $stryder, $prev) {
        // if database == stryder
        // set prev points to current prev point value
        // if database != stryder
        // update prev points to new current value

        if($database == $stryder) {
            return $prev;
        }else if($database != $stryder) {
            return $database;
        }
    }

    function brLadderTest($score, $pos) {
        if($score >= 15000 && $pos == -1) return 1;
        
        return 0;
    }

    function brLadderPos($score, $pos) {
        if($score >= 15000) return $pos;

        return -1;
    }

    function arenasLadderTest($score, $pos) {
        if($score >= 8000 && $pos == -1) return 1;
        
        return 0;
    }

    function arenasLadderPos($score, $pos) {
        if($score >= 8000) return $pos;

        return -1;
    }

    for($i = 1; $i < $setID + 2; $i++) {
        $getPlayer = "SELECT * FROM $CurrentRankPeriod WHERE id = $i";
        $queryPlayer = mysqli_query($DBConn, $getPlayer);

        if($i % 2 != 0){
            while($row = mysqli_fetch_array($queryPlayer)) {
                $url = "https://api.apexstats.dev/id?platform=".$row['Platform']."&id=".$row['PlayerID'];
    
                $getJson = file_get_contents($url, false, stream_context_create($streamOpts));
    
                $json = json_decode($getJson, true);
    
                // User Data
                $UserID = $json['user']['id'];
                $level = $json['account']['level'];
                $legend = $json['active']['legend'];
                $nickname = mysqli_real_escape_string($DBConn, $json['user']['username']);
    
                // Battle Royale Rank Data
                $brScore = $json['ranked']['BR']['score'];
                $brPrevScore = $row['BR_RankScore'];
                $brIsPred = $json['ranked']['BR']['name'];
                $brLadderPos = $json['ranked']['BR']['ladderPos'];
    
                // Arenas Rank Data
                $arenasScore = $json['ranked']['Arenas']['score'];
                $arenasPrevScore = $row['Arenas_RankScore'];
                $arenasIsPred = $json['ranked']['Arenas']['name'];
                $arenasLadderPos = $json['ranked']['Arenas']['ladderPos'];
    
                mysqli_query($DBConn, "UPDATE $CurrentRankPeriod SET `PlayerNick` = '".$nickname."', `PlayerLevel` = '".$level."', `PlayerStatus` = '".$json['user']['status']['online']."', `Legend` = '".$legend."', `BR_RankScore` = '".$brScore."', `BR_RankScorePrev` = '".previousPoints($row['BR_RankScore'], $brScore, $row['BR_RankScorePrev'])."', `BR_isPred` = '".isPred($brIsPred)."', `BR_LadderPos` = '".brLadderPos($brScore, $brLadderPos)."', `BR_Inactive` = '".brLadderTest($brScore, $brLadderPos)."', `Arenas_RankScore` = '".$arenasScore."', `Arenas_RankScorePrev` = '".previousPoints($row['Arenas_RankScore'], $arenasScore, $row['Arenas_RankScorePrev'])."', `Arenas_isPred` = '".isPred($arenasIsPred)."', `Arenas_LadderPos` = '".arenasLadderPos($arenasScore, $arenasLadderPos)."', `Arenas_Inactive` = '".arenasLadderTest($arenasScore, $arenasLadderPos)."', `lastUpdated` = '".time()."' WHERE PlayerID = '".$row['PlayerID']."'");
    
                // sleep(1);
            }
        }

        if($i == $setID + 1)
            break;

    }
