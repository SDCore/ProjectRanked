<?php 
    $title = "Add PC User";
    require_once("../../include/nav.php");

    if(!isset($_SESSION["user"])){
        header("location: /");
        exit;
    }

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

    if(isset($_POST['addUser'])) {
        $uid = $_POST['id'];

        $IDAPI = file_get_contents("https://api.apexstats.dev/id?platform=PC&id=".$uid, false, stream_context_create($streamOpts));

        $user = json_decode($IDAPI, true);

        $checkID = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `PlayerID` = '$uid'");

        if(mysqli_fetch_array($checkID) > 0) {
            $resp = '<span class="error">A user with that ID already exists.</span>';
        }else{
            function isPredCheck($ladderPos) {
                if($ladderPos <= 750 && $ladderPos >= 1) return 1;

                return 0;
            }

            function ladderPosCheck($ladderPos) {
                if($ladderPos <= 750 && $ladderPos >= 1) return $ladderPos;

                return 9999;
            }

            $playerName = $playerNick = $user['user']['username'];
            $platform = "PC";
            $PlayerLevel = $user['account']['level'];
            $Legend = $user['active']['legend'];

            $BR_RankScore = $user['ranked']['BR']['score'];
            $BR_isPred = isPredCheck($user['ranked']['BR']['ladderPos']);
            $BR_LadderPos = ladderPosCheck($user['ranked']['BR']['ladderPos']);

            $Arenas_RankScore = $user['ranked']['Arenas']['score'];
            $Arenas_isPred = isPredCheck($user['ranked']['Arenas']['ladderPos']);
            $Arenas_LadderPos = ladderPosCheck($user['ranked']['Arenas']['ladderPos']);

            mysqli_query($DBConn, "INSERT INTO $CurrentRankPeriod (PlayerID, PlayerName, PlayerNick, Platform, PlayerLevel, Legend, BR_RankScore, BR_isPred, BR_LadderPos, Arenas_RankScore, Arenas_isPred, Arenas_LadderPos) VALUES ('$uid', '$playerName', '$playerName', '$platform', '$PlayerLevel', '$Legend', '$BR_RankScore', '$BR_isPred', '$BR_LadderPos', '$Arenas_RankScore', '$Arenas_isPred', '$Arenas_LadderPos')");
            $resp = '<span class="success">User added successfully.</span>';
        }
    }
?>

<form action="#" method="POST">
    <div class="adminForm">
        <span class="title">Add PC User</span>
        <?php if(isset($resp)) { echo $resp; } ?>
        <div class="group">
            <span class="title">User ID</span>
            <input type="text" name="id" class="input" required="required" placeholder="User ID" />
        </div>
        <input type="submit" class="submit" name="addUser" value="Add User" />
    </div>
</form>

<?php require_once("../../include/footer.php"); ?>
