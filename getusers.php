<?php
$page['auth'] = 1;
require 'include/functions.inc';
require 'include/mysql.inc';

$search = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($_GET['multiple'])) {
    $start = 0;
    //echo $search;
    while (strpos($search, ",") > 0) {
        $start += ($a = strpos($search, ",") + 1);
        $search = substr($search, $a);
    }

    $search = trim($search);
    $query = sprintf("SELECT * FROM `dsp`.`dsp_users` WHERE `user` LIKE '%s%%' OR `first_name` LIKE '%s%%' OR `last_name` LIKE '%s%%' LIMIT 10", mysql_escape_string($search), mysql_escape_string($search), mysql_escape_string($search));
    //echo $query;
    $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
    $i = 0;
    echo "[";

    while ($row[$i] = mysql_fetch_assoc($result)) {
        if ($i > 0)
            echo ", ";
        echo "{ \"label\": \"" . $row[$i]['last_name'] . ", " . $row[$i]['first_name'] . " (" . $row[$i]['user'] . ")\", \"value\": \"" . substr($_GET['term'], 0, $start) . " " . $row[$i]['user'] . ", \"}";

        $i++;
    }

    echo "]";
}else {
    $search = trim($search);
    $query = sprintf("SELECT *  FROM `dsp`.`dsp_users` WHERE `user` LIKE '%s%%' OR `first_name` LIKE '%s%%' OR `last_name` LIKE '%s%%' LIMIT 10", mysql_escape_string($search), mysql_escape_string($search), mysql_escape_string($search));
    //echo $query;
    $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
    $i = 0;
    echo "[";

    while ($row[$i] = mysql_fetch_assoc($result)) {
        if ($i > 0)
            echo ", ";
        echo "{ \"label\": \"" . $row[$i]['last_name'] . ", " . $row[$i]['first_name'] . " (" . $row[$i]['user'] . ")\", \"value\": \"" . $row[$i]['user'] . "\"}";

        $i++;
    }

    echo "]";
}