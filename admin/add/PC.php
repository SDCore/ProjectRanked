<?php 
    $title = "Add PC User";
    require_once("../../include/nav.php");

    if(!isset($_SESSION["user"])){
        header("location: /");
        exit;
    }

    if(isset($_POST['addUser'])) {
        $uid = $_POST['id'];
        $name = $_POST['name'];

        $checkID = mysqli_query($DBConn, "SELECT * FROM $CurrentRankPeriod WHERE `PlayerID` = '$uid'");

        if(mysqli_fetch_array($checkID) > 0) {
            $resp = '<span class="error">A user with that ID already exists.</span>';
        }else{
            mysqli_query($DBConn, "INSERT INTO $CurrentRankPeriod (PlayerID, PlayerName, PlayerNick, Platform, Twitter, Twitch, TikTok, YouTube) VALUES ('$uid', '$name', '', 'PC', 'N/A', 'N/A', 'N/A', 'N/A')");
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
        <div class="group">
            <span class="title">Username</span>
            <input type="text" name="name" class="input" required="required" placeholder="Username" />
        </div>
        <input type="submit" class="submit" name="addUser" value="Add User" />
    </div>
</form>

<?php require_once("../../include/footer.php"); ?>
