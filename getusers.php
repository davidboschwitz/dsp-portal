<?php
/*
 * Copyright 2016 David Boschwitz.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
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
    $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` LIKE '%s%%' OR `first_name` LIKE '%s%%' OR `last_name` LIKE '%s%%' LIMIT 10", mysql_escape_string($search), mysql_escape_string($search), mysql_escape_string($search));
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
} else {
    $search = trim($search);
    $query = sprintf("SELECT *  FROM `$mysql_db`.`dsp_users` WHERE `user` LIKE '%s%%' OR `first_name` LIKE '%s%%' OR `last_name` LIKE '%s%%' LIMIT 10", mysql_escape_string($search), mysql_escape_string($search), mysql_escape_string($search));
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
