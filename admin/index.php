<?php
    require_once("../include/nav.php");

    if(!isset($_SESSION["user"]) || $_SESSION["user"] !== true){
        header("location: /");
        exit;
    }

    require_once("../include/footer.php");
