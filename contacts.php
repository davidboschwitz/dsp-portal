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
$page['auth'] = 0;
$page['no_timeout'] = TRUE;
$page['title'] = "Contacts";
require "include/functions.inc";
?>
<html>
    <head>
        <title>Contacts</title>
        <?php require "include/head.inc"; ?>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <div class="row" style="margin-left: 0px; margin-right: 0px">
          <?php
           ?>
          <table class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Email</th>
                </tr>
              </thead>
              <?php
              require 'include/mysql.inc';
              $query = "SELECT * FROM `{$mysql_db}`.`dsp_users` WHERE `position` NOT LIKE '' ORDER BY `auth` DESC";
              $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
$i = 0;
    while ($row[$i] = mysql_fetch_assoc($result)) {
              ?>
              <tr>
                <td></td>
                <td><?php echo $row[$i]['first_name'].' '.$row[$i]['last_name']; ?></td>
                <td><?php echo $row[$i]['position'];?></td>
                <td><a href="mailto:<?php echo $row[$i]['user'] .'@'. $config['email_domain']; ?>"><?php echo $row[$i]['user'] .'@'. $config['email_domain']; ?></a></td>
              </tr>
              <?php
              $i++;
            }
            mysql_close();
               ?>
          </table>
        </div>
        <?php require "include/footer.inc"; ?>
    </body>
</html>
