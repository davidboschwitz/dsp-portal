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

switch (filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING)) {
    case 'changepass':
        require 'include/mysql.inc';
        $currentPass = filter_input(INPUT_POST, 'currentpass', FILTER_SANITIZE_STRING);
        $newPass = filter_input(INPUT_POST, 'newpass', FILTER_SANITIZE_STRING);
        $confirmNewPass = filter_input(INPUT_POST, 'confirmnewpass', FILTER_SANITIZE_STRING);
        if ($newPass !== $confirmNewPass) {
          die(json_encode(array('status' => 'error', 'msg' => "New passwords do not match!", 'title' => 'Error')));
        }
        if(strlen($newPass) < 6) {
            die(json_encode(array('status' => 'error', 'msg' => "New password must be at least 6 characters long!", 'title' => 'Error')));
        }
        $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($_SESSION['user']));
        $result = mysql_query($query);
        $data = mysql_fetch_assoc($result);

        if ($_SESSION['user'] !== $data['user']) {
            //should never happen, but you never know.
            die(json_encode(array('status' => 'error', 'msg' => "Invalid user!", 'title' => 'Error')));
        }
        include "include/hash.php";
        if (!validate_password($currentPass, $data['pass'])) {
            //echo $currentPass.','.$data['pass'] . '=' . md5($currentPass);
            die(json_encode(array('status' => 'error', 'msg' => "Current password incorrect!", 'title' => 'Error')));
        }
        $newhash = create_hash($newPass);
        $query = sprintf("UPDATE `$mysql_db`.`dsp_users` SET `pass` = '%s' WHERE `dsp_users`.`user` = '%s';", mysql_escape_string($newhash), mysql_escape_string($_SESSION['user']));
        $result = mysql_query($query) or die(json_encode(array('status' => 'error', 'msg' => "Invalid query: " . mysql_error(), 'title' => 'Error')));
        echo(json_encode(array('status' => 'success', 'msg' => "Changed Password Successfully!", 'title' => 'Success')));
        $_SESSION['pass'] = $newhash;
        break;
}

mysql_close($mysql_link);
