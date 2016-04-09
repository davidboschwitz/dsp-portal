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
require "include/functions.inc";
?>
<html>
    <head>
        <title>Calendar</title>
        <?php require "include/head.inc"; ?>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <div class="page-header" style="margin-top: 0; background-color: #fcfcfc">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2>
                            <img style="display:none" height="35" width="35" class="print-inline" src="https://www.deltasig-de.org/Images/MobileTouch-57x57.png">
                            Chapter Contacts
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-left: 0px; margin-right: 0px">
          <h3>Roster</h3>
          <?php
           ?>
          <table class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Position</th>
                </tr>
              </thead>
              <?php
              require 'include/mysql.inc';
              $query = "SELECT * FROM `{$mysql_db}`.`dsp_users` WHERE `position` NOT LIKE ''";
              $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
$i = 0;
    while ($row[$i] = mysql_fetch_assoc($result)) {
              ?>
              <tr>
                <td></td>
                <td><?php echo $row[$i]['first_name'].' '.$row[$i]['last_name']; ?></td>
                <td><a href="mailto:<?php echo $row[$i]['user'] .'@'. $config['email_domain']; ?>"><?php echo $row[$i]['email'] .'@'. $config['email_domain']; ?></a></td>
                <td><?php echo $row[$i]['position'];</td>
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
