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
$page['auth'] = 100;
require "include/functions.inc";


switch(filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING)) {

    case "resetpass":
        require "include/hash.php";
        require "include/mysql.inc";

        if(!validate_password(filter_input(INPUT_POST, 'mypass', FILTER_SANITIZE_STRING), $_SESSION['pass'])) {
            die(json_encode(array('status' => 0, 'error' => "Invalid authentication")));
        }
        $user = filter_input(INPUT_POST, 'usertoreset', FILTER_SANITIZE_STRING);
        $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($user));
        $result = mysql_query($query);
        $data = mysql_fetch_assoc($result);

        mysql_close($mysql_link);

        if ($user !== $data['user']) {
            //webmasters should know better
            die(json_encode(array('status' => 0, 'error' => "User: $user does not exist!")));
        }
        $newpass = substr(md5(rand()), 7, 8);

        $query = sprintf("UPDATE `$mysql_db`.`dsp_users` SET `pass` = '%s' WHERE `dsp_users`.`user` = '%s';", mysql_escape_string(create_hash($newpass)), mysql_escape_string($user));
        $result = mysql_query($query) or die(json_encode(array('status' => 0, 'error' => ('Invalid query: ' . mysql_error()))));
        echo json_encode(array('status' => 1, 'newpass' => $newpass));
        break;


    case "toggledebug":
        if(!isset($_SESSION['debug'])) {
            $_SESSION['debug'] = true;
        } else {
            $_SESSION['debug'] = !$_SESSION['debug'];
        }
        echo json_encode(array('status' => ($_SESSION['debug'] ? 1 : 2), 'msg' => "Debug is now ".($_SESSION['debug'] ? "ON" : "OFF")));
        break;


    case "createuser":
        die(json_encode(array('status' => 0, 'error' => "Feature not yet implemented!")));

        break;

    case "createpointdef":
        require "include/hash.php";

        if(!validate_password(filter_input(INPUT_POST, 'mypass', FILTER_SANITIZE_STRING), $_SESSION['pass'])) {
            die(json_encode(array('status' => 0, 'error' => "Invalid authentication")));
        }

        $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
        $pts = filter_input(INPUT_POST, 'pts', FILTER_SANITIZE_NUMBER_INT);
        $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);

        if(strlen($code) < 4 || strlen($code) > 5){
            die(json_encode(array('status' => 0, 'error' => ("Code should be in format AA##"))));
        }
        if($pts < 1 || $pts > 50){
            die(json_encode(array('status' => 0, 'error' => ("1 < pts < 50"))));
        }
        require "include/mysql.inc";

        $query = sprintf("INSERT INTO `$mysql_db`.`points_definition` (`code`, `points`, `description`) VALUES ('%s', '%s', '%s');", mysql_escape_string($code), mysql_escape_string($pts), mysql_escape_string($desc));
        $result = mysql_query($query) or die(json_encode(array('status' => 0, 'error' => ('Invalid query: ' . mysql_error()))));
        mysql_close($mysql_link);

        echo json_encode(array('status' => 1, 'msg' => "Added point $code"));
        break;

    case "deletepointdef":
        //DELETE FROM `deltasigba`.`points_definition` WHERE `points_definition`.`code` = '%s'
        break;

    case "updateperson":
        require "include/hash.php";

        if(!validate_password(filter_input(INPUT_POST, 'mypass', FILTER_SANITIZE_STRING), $_SESSION['pass'])) {
            die(json_encode(array('status' => 'error', 'msg' => "Invalid authentication", 'title'=>"")));
        }
        require 'include/mysql.inc';

        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $auth = filter_input(INPUT_POST, 'auth', FILTER_SANITIZE_NUMBER_INT);
        $pos = filter_input(INPUT_POST, 'pos', FILTER_SANITIZE_STRING);

        $query = sprintf("SELECT * FROM `{$mysql_db}`.`dsp_users` WHERE `user` = '%s'", $user);
        $result = mysql_query($query) or die(json_encode(array('title'=>"Error", 'status' => 'error', 'msg' => ('Invalid query: ' . mysql_error()))));
        $userData = mysql_fetch_assoc($result);
        if($userData['auth'] > $_SESSION['auth']){
            die(json_encode(array('status' => 'error', 'msg' => "You cannot update someone who is a higher authentication level than you.", 'title'=>"")));
        }
        $query = sprintf("UPDATE `{$mysql_db}`.`dsp_users` SET `position` = '%s', `auth` = '%d' WHERE `dsp_users`.`user` = '%s';", $pos, $auth, $user);
        $result = mysql_query($query) or die(json_encode(array('title'=>"Error", 'status' => 'error', 'msg' => ('Invalid query: ' . mysql_error()))));

        echo json_encode(array('status' => 'success', 'msg' => "Updated Successfully!", 'title'=>""));
        mysql_close($mysql_link);
        break;

}
