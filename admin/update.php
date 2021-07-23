<?php

// Hi :) If you're viewing this, please don't super-reverse-engineer it and ruin it.
// I haven't set up a way to authenticate/rate limit, and I don't want to if I don't
// have to. This is the simplist way for me to update the rank info, and while
// I don't mind having to complicate it, I really shouldn't have to.
//
// Please keep that in mind.
//
// - Love, SDCore <3

// Include connect scripts
include_once("../connect.php");
set_time_limit(0);

// Create and check connection
$DBConn = mysqli_connect($host, $user, $pass, $db);

if(!$DBConn) {
  die("Error: Connection failed. " . mysqli_connect_error());
}

// Get total player count from DB
$playerCount = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod ORDER BY `id` DESC LIMIT 1");

while ($row = mysqli_fetch_assoc($playerCount)) {
    $setID = $row['id'];
}
  
// Function to check if the user is a pred
function isPred($name) {
    if($name == "Apex Predator") return 1;

    return 0;
}

// Check ladder pos
function checkLadderPos($pos) {
    if($pos == -1) return "9999";

    return $pos;
}

// Loop thru every user in the DB and update the info
for($i = 1; $i < $setID + 1; $i++) {
  $getPlayer = "SELECT * FROM $DB_RankPeriod WHERE id = $i";
  $queryPlayer = mysqli_query($DBConn, $getPlayer);

  while($row = mysqli_fetch_array($queryPlayer)) {
    $url = "https://api.apexstats.dev/id.php?platform=".$row['Platform']."&id=".$row['PlayerID'];

    $getJson = file_get_contents($url);

    $json = json_decode($getJson, true);

    // Account Info
    $playerID = $json['userData']['userID'];
    $nickname = mysqli_real_escape_string($DBConn, $json['userData']['username']);
    $level = $json['accountInfo']['level'];
    $legend = $json['accountInfo']['active']['legend'];

    // BR Ranked Info
    $BR_RankScore = $json['accountInfo']['Ranked']['BR']['score'];
    $BR_isPred = $json['accountInfo']['Ranked']['BR']['name'];
    $BR_LadderPos = $json['accountInfo']['Ranked']['BR']['ladderPos'];

    // Arenas Ranked Info
    $Arena_RankScore = $json['accountInfo']['Ranked']['Arenas']['score'];
    $Arena_isPred = $json['accountInfo']['Ranked']['Arenas']['name'];
    $Arena_LadderPos = $json['accountInfo']['Ranked']['Arenas']['ladderPos'];

    // Update
    mysqli_query($DBConn, "UPDATE $DB_RankPeriod SET PlayerNick = '".$nickname."', PlayerLevel = '".$level."', Legend = '".$legend."', BR_RankScore = '".$BR_RankScore."', BR_LadderPos = '".checkLadderPos($BR_LadderPos)."', BR_isPred = '".isPred($BR_isPred)."', Arenas_RankScore = '".$Arena_RankScore."', Arenas_LadderPos = '".checkLadderPos($Arena_LadderPos)."', Arenas_isPred = '".isPred($Arena_isPred)."', lastUpdated = '".time()."' WHERE PlayerID = '".$playerID."'");

    if($debug != true) {
        sleep(1);
    }
  }

    if($i == $setID + 1)
        break;
}
