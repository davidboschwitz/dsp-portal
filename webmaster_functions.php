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
    include "include/mysql.inc";

      if(!validate_password(filter_input(INPUT_POST, 'mypass', FILTER_SANITIZE_STRING), $_SESSION['pass'])) {
          die(json_encode(array('status' => 0, 'error' => "Invalid authentication")));
      }
      $user = filter_input(INPUT_POST, 'usertoreset', FILTER_SANITIZE_STRING);
      $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($user));
      $result = mysql_query($query);
      $data = mysql_fetch_assoc($result);

      if ($user !== $data['user']) {
          //webmasters should know better
          die(json_encode(array('status' => 0, 'error' => "User: $user does not exist!")));
      }
      $newpass = substr(md5(rand()), 7, 8);

      $query = sprintf("UPDATE `$mysql_db`.`dsp_users` SET `pass` = '%s' WHERE `dsp_users`.`user` = '%s';", mysql_escape_string(create_hash($newpass)), mysql_escape_string($user));
      $result = mysql_query($query) or die(json_encode(array('status' => 0, 'error' => ('Invalid query: ' . mysql_error()))));
      echo json_encode(array('status' => 1, 'newpass' => $newpass));
      break;


}
