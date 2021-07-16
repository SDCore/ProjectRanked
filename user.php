<?php
    require_once("./include/nav.php");

    $PID = $_GET['id'];
    $DBConn = mysqli_connect($host, $user, $pass, $db);
    $getPlayer = mysqli_query($DBConn, "SELECT * FROM `projectRanked` WHERE `PlayerID` = '$PID'");
    $player = mysqli_fetch_assoc($getPlayer);

    if(mysqli_num_rows($getPlayer) < 1) { echo '<div style="font-size: 25pt; width: 100%; text-align: center; color: #FFF; margin-top: 25px; font-weight: bold;">User does not exist.</div>'; }
?>

<?php require_once("./include/footer.php"); ?>
