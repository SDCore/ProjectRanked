<?php
    function brRankDivPreUpdate($score) {
        if($score < 300) {
            return 4;
        }else if($score < 600) {
            return 3;
        }else if($score < 900) {
            return 2;
        }else if($score < 1200) {
            return 1;
        }else if($score < 1600) {
            return 4;
        }else if($score < 2000) {
            return 3;
        }else if($score < 2400) {
            return 2;
        }else if($score < 2800) {
            return 1;
        }else if($score < 3300) {
            return 4;
        }else if($score < 3800) {
            return 3;
        }else if($score < 4300) {
            return 2;
        }else if($score < 4800) {
            return 1;
        }else if($score < 5400) {
            return 4;
        }else if($score < 6000) {
            return 3;
        }else if($score < 6600) {
            return 2;
        }else if($score < 7200) {
            return 1;
        }else if($score < 7900) {
            return 4;
        }else if($score < 8600) {
            return 3;
        }else if($score < 9300) {
            return 2;
        }else{
            return 1;
        }
    }

    function arenasRankDivPreUpdate($score) {
        if($score < 400) {
            return 4;
        }else if($score < 800) {
            return 3;
        }else if($score < 1200) {
            return 2;
        }else if($score < 1600) {
            return 1;
        }else if($score < 2000) {
            return 4;
        }else if($score < 2400) {
            return 3;
        }else if($score < 2800) {
            return 2;
        }else if($score < 3200) {
            return 1;
        }else if($score < 3600) {
            return 4;
        }else if($score < 4000) {
            return 3;
        }else if($score < 4400) {
            return 2;
        }else if($score < 4800) {
            return 1;
        }else if($score < 5200) {
            return 4;
        }else if($score < 5600) {
            return 3;
        }else if($score < 6000) {
            return 2;
        }else if($score < 6400) {
            return 1;
        }else if($score < 6800) {
            return 4;
        }else if($score < 7200) {
            return 3;
        }else if($score < 7600) {
            return 2;
        }else{
            return 1;
        }
    }
