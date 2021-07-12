<?php
    require_once("./include/nav.php");

    $PID = $_GET['id'];
    $DBConn = mysqli_connect($host, $user, $pass, $db);
    $getPlayer = mysqli_query($DBConn, "SELECT * FROM `projectRanked` WHERE `PlayerID` = '$PID'");
    $player = mysqli_fetch_assoc($getPlayer);
?>

<?php require_once("./include/footer.php"); ?>
