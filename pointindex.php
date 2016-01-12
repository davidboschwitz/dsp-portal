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
require "include/config.inc";
?>
<html>
    <head>
        <title>DSP - My Points</title>
        <?php include "include/head.inc"; ?>
        <script type="text/javascript">
            function giveCode(code) {
                opener.document.getElementById("code").value = code;
                this.close();
            }
        </script>
    </head>
    <body style="background-color:white">
        <h2 style="margin-top: 0">Points Breakdown</h2>
        Click on code to insert
        <table class="cream">
            <thead>
                <tr>
                    <th style="text-align: right;">Pts</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Description</th>
                </tr>
            </thead>
            <?php
            require "include/mysql.inc";
            $result = mysql_query("SELECT
  pd.points,
  pd.code,
  pc.description AS category,
  pd.description
FROM $mysql_db.points_definition AS pd
INNER JOIN $mysql_db.points_categories AS pc ON SUBSTRING(pd.code,1,2) = pc.code") or die('Invalid query: ' . mysql_error());

            $i = 0;
            while ($row[$i++] = mysql_fetch_assoc($result)) {
                //TODO: add rows with same codes quantities into one single row
            }
            $rowcount = --$i; //Otherwise returns extra empty NULL row
            for ($i = 0; $i < $rowcount; $i++) {
                ?>
                <tr>
                    <td style="text-align: right;"><?php echo $row[$i]['points']; ?></td>
                    <td onclick="giveCode('<?php echo $row[$i]['code']; ?>')"><a style="text-decoration: underline; color: blue;" href="#" onclick="giveCode('<?php echo $row[$i]['code']; ?>')"><?php echo $row[$i]['code']; ?></a></td>
                    <td><?php echo $row[$i]['category']; ?></td>
                    <td><?php echo $row[$i]['description']; ?></td>
                </tr>
            <?php } ?>
            <thead>
                <tr>
                    <th>&nbsp;</th><th></th><th></th><th></th>
                </tr>
            </thead>
        </table>
    </body>
</html>
<?php mysql_close($mysql_link);
