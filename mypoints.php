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
require "include/functions.inc";
$page ['title'] = "My Points Breakdown (" . $_SESSION['full_name'] . ")";
require "include/mysql.inc"; //connect to MySQL

$user = $_SESSION['user'];

$query = sprintf("SELECT pa.code, pa.quantity, pd.points, pd.description, pc.description AS category
FROM $mysql_db.points_awarded AS pa
INNER JOIN $mysql_db.points_categories AS pc ON SUBSTRING(pa.code,1,2) = pc.code
INNER JOIN $mysql_db.points_definition AS pd ON pd.code = pa.code
WHERE pa.awardedto = '%s'
ORDER BY pa.code", mysql_escape_string($user));

$result = mysql_query($query) or die('Invalid query: ' . mysql_error());


$rowcount = 0;
$i = 0;
while ($row[$i] = mysql_fetch_assoc($result)) {
    //TODO: add rows with same codes quantities into one single row
    $flag = false;
    for ($a = 0; $a < $rowcount; $a++) {
        if ($content[$a]['code'] == $row[$i]['code']) {
            $flag = true;
            $content[$a]['quantity'] += $row[$i]['quantity'];
        }
    }
    if (!$flag) {
        $content[$a] = $row[$i];
        $rowcount++;
    }
    $i++;
}
?>
<html>
    <head>
        <title>My Points</title>
        <?php require "include/head.inc"; ?>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <table id="responsive-table" class="table table-bordered table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th style="text-align: right;">Pts</th>
                    <th style="text-align: right;">#</th>
                    <th style="text-align: right;">Ttl</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Description</th>
                </tr>
            </thead>
            <?php
            $totalpts = 0;
            $totalquantity = 0;
            for ($i = 0; $i < $rowcount; $i++) {
                $totalpts += $content[$i]['points'] * $content[$i]['quantity'];
                $totalquantity += $content[$i]['quantity'];
                ?>
                <tr>
                    <td class="table-right" data-title="Points"><?php echo $content[$i]['points']; ?></td>
                    <td class="table-right" data-title="Quantity"><?php echo $content[$i]['quantity']; ?></td>
                    <td class="table-right" data-title="Total"><?php echo ($content[$i]['points'] * $content[$i]['quantity']); ?></td>
                    <td data-title="Code"><?php echo $content[$i]['code']; ?></td>
                    <td data-title="Category"><?php echo $content[$i]['category']; ?></td>
                    <td data-title="Description"><?php echo $content[$i]['description']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="table-hide table-right">&nbsp;</td>
                <td class="table-hide table-right"><?php //echo $totalquantity;   ?></td>
                <td class="table-right" data-title="Total Points"><?php echo $totalpts; ?></td>
                <td class="table-hide"><i>Total</i></td>
                <td class="table-hide table-right">Current Status:</td>
                <td data-title="Current Status"><?php echo points_status($totalpts); ?></td>
            </tr>
        </table>
        <?php require "include/footer.inc"; ?>
    </body>
</html>
<?php
mysql_close($mysql_link);
