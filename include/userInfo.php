<?php
    function platform($platform) {
        if($platform == "PC") return "<i class='fab fa-steam'></i>";
        if($platform == "PS4") return "<i class='fab fa-playstation'></i>";
        if($platform == "X1") return "<i class='fab fa-xbox'></i>";
        if($platform == "SWITCH") return "<i class='fas fa-gamepad'></i>";

        return "N/A";
    }

    function isOnline($platform, $id, $streamOpts) {
        $online = file_get_contents("https://api.apexstats.dev/isOnline?platform=".$platform."&id=".$id, false, stream_context_create($streamOpts));
        $status = json_decode($online, true);

        $user = $status['user']['status'];

        if ($user['online'] == 1 && $user['ingame'] == 0) {
            if ($user['matchLength'] != -1) return "<span class='lobby'><i class='fa-solid fa-circle'></i></span> Lobby (<span id='userTime''><i>Loading...</i></span><script type='text/javascript'>var matchLength = ".time()." - '".$user['matchLength']."';</script>)";

            return "<span class='lobby'><i class='fa-solid fa-circle'></i></span> Lobby";
        }else if($user['online'] == 1 && $user['ingame'] == 1) {
            if ($user['matchLength'] != -1) return "<span class='match'><i class='fa-solid fa-circle'></i></span> In a Match (<span id='userTime''><i>Loading...</i></span><script type='text/javascript'>var matchLength = ".time()." - '".$user['matchLength']."';</script>)";

            return "<span class='match'><i class='fa-solid fa-circle'></i></span> In a Match";
        }

        return "<span class='offline'><i class='fa-solid fa-circle'></i></span> Offline / Invite Only";
    }

    function change($current, $prev, $type) {
        if($current < $prev) {
            $newScore = number_format($prev - $current);

            return '<span class="prev neg"><i class="fa-solid fa-angle-down"></i> -'.$newScore.' '.$type.'</span>';
        }else if($current > $prev) {
            $newScore = number_format($current - $prev);

            return '<span class="prev posi"><i class="fa-solid fa-angle-up"></i> +'.$newScore.' '.$type.'</span>';
        }

        return '<span class="prev"><i class="fa-solid fa-equals"></i> 0 '.$type.'</span>';
    }

    function checkLadderPos($ladderPos) {
        if ($ladderPos <= 750 && $ladderPos >= 1) return 1;

        return 0;
    }
