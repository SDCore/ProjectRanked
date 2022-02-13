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

    for($i = 1; $i < $setID + 2; $i++) {
        $getPlayer = "SELECT * FROM $CurrentRankPeriod WHERE id = $i";
        $queryPlayer = mysqli_query($DBConn, $getPlayer);

        while($row = mysqli_fetch_array($queryPlayer)) {
            $url = "https://api.apexstats.dev/id?platform=".$row['Platform']."&id=".$row['PlayerID'];

            $getJson = file_get_contents($url);

            $json = json_decode($getJson, true);

            $BR_LadderPos = $json['ranked']['BR']['ladderPos'];
            $BR_isPred = $json['ranked']['BR']['name'];
            $Arena_LadderPos = $json['ranked']['Arenas']['ladderPos'];
            $Arena_isPred = $json['ranked']['Arenas']['name'];
            $nickname = mysqli_real_escape_string($DBConn, $json['user']['username']);

            if($BR_LadderPos == -1) $BR_LadderPos = "9999";
            if($Arena_LadderPos == -1) $Arena_LadderPos = "9999";

            // mysqli_query($DBConn, "UPDATE $CurrentRankPeriod SET PlayerNick = '".$nickname."', PlayerLevel = '".$json['account']['level']."', Legend = '".$json['active']['legend']."', BR_RankScore = '".$json['ranked']['BR']['score']."', BR_LadderPos = '".$BR_LadderPos."', BR_isPred = '".isPred($BR_isPred)."', Arenas_RankScore = '".$json['ranked']['Arenas']['score']."', Arenas_LadderPos = '".$Arena_LadderPos."', Arenas_isPred = '".isPred($Arena_isPred)."', lastUpdated = '".time()."' WHERE PlayerID = '".$json['user']['id']."'");

            echo "id: ".$json['user']['id'];

            mysqli_query($DBConn, "UPDATE $CurrentRankPeriod SET `PlayerNick` = '".$nickname."' WHERE PlayerID = '".$json['user']['id']."'");

            // sleep(1);
        }

        if($i == 2)
            break;
    }
