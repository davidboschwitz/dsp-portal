<?php

$config['VERSION'] = 0.1;
$config['debug'] = true;
date_default_timezone_set('US/Central');

function points_status($totalpts) {
    if ($totalpts < 100) {
        return "Delinquent";//0-99 points
    }
    if ($totalpts < 200) {
        return "Sailor";//100-199
    }
    if ($totalpts < 300) {
        return "First Mate";//200-299
    }
    if ($totalpts < 400) {
        return "Captian";//300-399
    }
    if ($totalpts < 500) {
        return "Egyptian";//400-499 
    }
    if ($totalpts < 600) {
        return "Nile";//500-599 
    }
    if ($totalpts < 700) {
        return "Pyramid";//600-699 
    }
    return "Sphinx"; //700+ 
}
