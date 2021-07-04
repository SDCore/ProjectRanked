<?php

// Hi :) If you're viewing this, please don't super-reverse-engineer it
// and ruin it. I haven't set up a way to authenticate/rate limit, and I
// don't want to if I don't have to. This is the simplist way for me to
// update the rank info, and while I don't mind having to complicate it,
// I really shouldn't have to. Please keep that in mind.
//
// - Love, SDCore <3

include "../connect.php";
set_time_limit(72000);

// Create and check connection
$DBConn = mysqli_connect($host, $user, $pass, $db);

if(!$DBConn) {
  die("Error: Connection failed. " . mysqli_connect_error());
}

$playerCount = mysqli_fetch_array($DBConn->query("SELECT COUNT(*) FROM projectRanked"));

function isPred($name) {
    if($name == "Apex Predator") return 1;

    return 0;
}

for($i = 1; $i < $playerCount[0] + 1; $i++) {
  $getPlayer = "SELECT * FROM projectRanked WHERE id = $i";
  $queryPlayer = mysqli_query($DBConn, $getPlayer);

  while($row = mysqli_fetch_array($queryPlayer)) {
    $url = "https://api.apexstats.dev/stats.php?platform=".$row['Platform']."&player=".urlencode($row['PlayerName']);

    $getJson = file_get_contents($url);

    $json = json_decode($getJson, true);

    $BR_LadderPos = $json['accountInfo']['Ranked_BR']['ladderPos'];
    $BR_isPred = $json['accountInfo']['Ranked_BR']['name'];

    if($BR_LadderPos == -1) $BR_LadderPos = "9999";

    mysqli_query($DBConn, "UPDATE projectRanked SET PlayerNick = '".$json['userData']['username']."', PlayerLevel = '".$json['accountInfo']['level']."', Legend = '".$json['accountInfo']['active']['legend']."', BR_RankScore = '".$json['accountInfo']['Ranked_BR']['score']."', BR_LadderPos = '".$BR_LadderPos."', BR_isPred = '".isPred($BR_isPred)."', lastUpdated = '".time()."' WHERE PlayerID = '".$json['userData']['userID']."'");

    sleep(2);
  }

    if($i == $playerCount[0] + 1)
        break;
}
