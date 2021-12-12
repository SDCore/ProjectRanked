<?php 
    $title = "Admin Dashboard";
    require_once("../include/nav.php");
?>

<div class="container">
    <div class="addUserButtons">
        <span class="title">Add User</span>
        <span class="buttons">
            <a class="button" href="/addPC">PC</a>
            <a class="button" href="/addPS4">PlayStation</a>
            <a class="button" href="/addX1">Xbox</a>
        </span>
    </div>
</div>

<?php require_once("../include/footer.php"); ?>
