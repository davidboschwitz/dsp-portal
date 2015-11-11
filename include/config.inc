<?php

$config['version'] = 0.1;

$config['debug'] = false;

/* Timeout: set to 0 for never timeout. */
$config['timeout'] = 0;

/*  */
$config['webmaster_email'] = "dbosch@iastate.edu";

/* For making sure Dates/Times are correct. Will throw errors if removed */
date_default_timezone_set('US/Central');

function points_status($totalpts) {
    if ($totalpts < 100)
        return "Delinquent"; //0-99 points
    if ($totalpts < 200)
        return "Sailor"; //100-199
    if ($totalpts < 300)
        return "First Mate"; //200-299
    if ($totalpts < 400)
        return "Captian"; //300-399
    if ($totalpts < 500)
        return "Egyptian"; //400-499 
    if ($totalpts < 600)
        return "Nile"; //500-599 
    if ($totalpts < 700)
        return "Pyramid"; //600-699 
    return "Sphinx"; //700+ 
}
