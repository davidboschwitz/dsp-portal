<?php
/*
 * Copyright 2015 David Boschwitz.
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
            die("New Passwords do not match!");
        }
        $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($_SESSION['user']));
        $result = mysql_query($query);
        $data = mysql_fetch_assoc($result);

        if ($_SESSION['user'] !== $data['user']) {
            //should never happen, but you never know.
            die("Invalid user!");
        }
        include "include/hash.php";
        if (!validate_password($currentPass, $data['pass'])) {
            //echo $currentPass.','.$data['pass'] . '=' . md5($currentPass);
            die("Current password incorrect!");
        }
        $query = sprintf("UPDATE `$mysql_db`.`dsp_users` SET `pass` = '%s' WHERE `dsp_users`.`user` = '%s';", md5(mysql_escape_string($newPass)), mysql_escape_string($_SESSION['user']));
        $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
        echo "Changed Password Successfully";
        break;
}

mysql_close($mysql_link);
