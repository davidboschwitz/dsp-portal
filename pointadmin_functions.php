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
        $query = "DELETE FROM `$mysql_db`.`points_awarded` WHERE `points_awarded`.`pointid` = '". $pointID."';";
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
