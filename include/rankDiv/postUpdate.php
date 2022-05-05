<?php
    function brRankDivPostUpdate($score) {
        if($score < 250) {
            return 4;
        }else if($score < 500) {
            return 3;
        }else if($score < 750) {
            return 2;
        }else if($score < 1000) {
            return 1;
        }else if($score < 1500) {
            return 4;
        }else if($score < 2000) {
            return 3;
        }else if($score < 2500) {
            return 2;
        }else if($score < 3000) {
            return 1;
        }else if($score < 3600) {
            return 4;
        }else if($score < 4200) {
            return 3;
        }else if($score < 4800) {
            return 2;
        }else if($score < 5400) {
            return 1;
        }else if($score < 6100) {
            return 4;
        }else if($score < 6800) {
            return 3;
        }else if($score < 7500) {
            return 2;
        }else if($score < 8200) {
            return 1;
        }else if($score < 9000) {
            return 4;
        }else if($score < 9800) {
            return 3;
        }else if($score < 10600) {
            return 2;
        }else if($score < 11400) {
            return 1;
        }else if($score < 12300) {
            return 4;
        }else if($score < 13200) {
            return 3;
        }else if($score < 14100) {
            return 2;
        }else{
            return 1;
        }
    }

    function arenasRankDivPostUpdate($score) {
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
