<?php 
    $title = "Admin Dashboard";
    require_once("../include/nav.php");

    if(!isset($_SESSION["user"])){
        header("location: /");
        exit;
    }
?>

<div class="container">
    <div class="addUserButtons">
        <span class="title">Add User</span>
        <span class="buttons">
            <a class="button" href="./add/PC"><i class="fab fa-steam"></i> PC</a>
            <a class="button" href="./add/PlayStation"><i class="fab fa-playstation"></i> PlayStation</a>
            <a class="button" href="./add/Xbox"><i class="fab fa-xbox"></i> Xbox</a>
            <a class="button" href="./add/Switch"><i class="fas fa-gamepad"></i> Nintendo Switch</a>
        </span>
    </div>
</div>

<?php require_once("../include/footer.php"); ?>
