<?php
$page['auth'] = 7;
require "include/functions.inc";
require "include/mysql.inc";

$pointID = filter_input(INPUT_POST, 'pointid', FILTER_SANITIZE_NUMBER_INT);

switch (filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING)) {
    case 'edit':
        //TODO
        echo "Feature not available at this time.";
        break;
    case 'delete':
        //TODO
        $query = "DELETE FROM `dsp`.`points_awarded` WHERE `points_awarded`.`pointid` = '". $pointID."';";
        mysql_query($query) or die("Delete Unsuccessful: ".  mysql_error());
        echo "Delete Success! (".$pointID.")";
        break;
    case 'editmultiple':
        //TODO
        echo "Edit unsuccessful!";
        break;
    case 'deletemultiple':
        //TODO
        echo "Delete unsuccessful!";
        break;
}

mysql_close($mysql_link);