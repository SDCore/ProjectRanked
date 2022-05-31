<?php
    function type($type) {
        return ($type == "BR") ? "Battle Royale" : "Arenas";
    }

    function season($con, $info) {
        $data = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `seasonData`")) or die(myslqi_error($con));

        return $data[$info];
    }
