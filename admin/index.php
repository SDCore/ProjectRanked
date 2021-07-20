<?php
    $pageTitle = "Admin";
    require_once("../include/nav.php");
    $DBConn = mysqli_connect($host, $user, $pass, $db);

    if(!isset($_SESSION["user"]) || $_SESSION["user"] !== true){
        header("location: /");
        exit;
    }

    $error = "";

    if(isset($_POST['addUser'])) {
        $uid = $_POST['uid'];
        $name = $_POST['username'];
        $plat = $_POST['platformOption'];

        $checkID = mysqli_query($DBConn, "SELECT * FROM $DB_RankPeriod WHERE `PlayerID` = '$uid'");

        if(mysqli_fetch_array($checkID) > 0) {
            $resp = '<span class="error">A user with that ID already exists.</span>';
        }else{
            mysqli_query($DBConn, "INSERT INTO $DB_RankPeriod (PlayerID, PlayerName, PlayerNick, Platform, Twitter, Twitch) VALUES ('$uid', '$name', '', '$plat', 'N/A', 'N/A')");
            $resp = '<span class="succ">User added successfully.</span>';
        }
    }
?>

<div class="adminContainer">
    <div class="addUser">
        <form action="#" method="POST">
            <span class="title">Add User</span>
            <?php if(!empty($resp)) { echo $resp; } ?>
            <span class="inputTitle">ID</span>
            <input type="text" class="newUser" id="uid" name="uid" placeholder="User ID" required />
            <br /><br />
            <span class="inputTitle">Username</span>
            <input type="text" class="newUser" id="username" name="username" placeholder="Username" required />
            <br /><br />
            <span class="inputTitle">Platform</span>
            <select name="platformOption" class="newUser">
                <option value="PC">PC</option>
                <option value="PS4">PlayStation</option>
                <option value="X1">Xbox</option>
            </select>
            <br /><br />
            <input type="submit" name="addUser" class="submitButton" value="Add User" />
        </span>
    </div>
</div>

<?php require_once("../include/footer.php"); ?>
