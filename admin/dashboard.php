<?php 
    $pageTitle = "Admin Dashboard";
    require_once("../include/nav.php");

    if(!isset($_SESSION["user"])){
        header("location: /");
        exit;
    }
?>

<div class="addUserButtons">
    <span class="title">Add User</span>
    <a href="addPCUser">PC</a>
    <a href="addPS4User">PS4</a>
    <a href="addX1User">X1</a>
</div>

<?php require_once("../include/footer.php"); ?>
