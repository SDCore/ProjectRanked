<?php 
    $pageTitle = "Add PS4 User";
    require_once("../include/nav.php");

    if(!isset($_SESSION["user"])){
        header("location: /");
        exit;
    }

    if(isset($_POST['addUser'])) {
        $uid = $_POST['uid'];
        $name = $_POST['username'];
        $plat = "PS4";

        $checkID = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod_Current WHERE `PlayerID` = '$uid'");

        if(mysqli_fetch_array($checkID) > 0) {
            $resp = '<span class="error">A user with that ID already exists.</span>';
        }else{
            mysqli_query($DBConn, "INSERT INTO $DB_RankPeriod_Current (PlayerID, PlayerName, PlayerNick, Platform, Twitter, Twitch, TikTok, YouTube) VALUES ('$uid', '$name', '', '$plat', 'N/A', 'N/A', 'N/A', 'N/A')");
            $resp = '<span class="success">User added successfully.</span>';
        }
    }
?>

<form action="#" method="post">
    <div class="adminAddUser">
        <span class="title">Add PS4 User</span>
        <?php if(!empty($resp)) { echo $resp; } ?>
        <div class="group">
            <span class="title">User ID</span>
            <input type="text" name="uid" class="input" required="required" />
        </div>
        <div class="group">
            <span class="title">Username</span>
            <input type="text" name="username" class="input" required="required" />
        </div>
        <input type="submit" class="submit" name="addUser" value="Add User" />
    </div>
</form>

<?php require_once("../include/footer.php"); ?>
