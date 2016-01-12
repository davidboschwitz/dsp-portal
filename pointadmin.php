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

$query = "SELECT * FROM `$mysql_db`.`points_awarded` WHERE 1 = 1";

if (isset($_POST['datebefore']) && isset($_POST['dateafter']) && !empty($_POST['dateafter']) && !empty($_POST['datebefore'])) {
    //TODO make sure input is formatted to be a date
    $query .= sprintf(" AND `timestamp` BETWEEN '%s' AND '%s 23:59:00'", mysql_escape_string($_POST['datebefore']), mysql_escape_string($_POST['dateafter']));
}
if (isset($_POST['awardedto']) && valid_net_id($_POST['awardedto']) && !empty($_POST['awardedto'])) {
    $query .= sprintf(" AND `awardedto` = '%s'", mysql_escape_string($_POST['awardedto']));
}
if (isset($_POST['awardedby']) && valid_net_id($_POST['awardedby']) && !empty($_POST['awardedby'])) {
    $query .= sprintf(" AND `awardedby` = '%s'", mysql_escape_string($_POST['awardedby']));
}
if (isset($_POST['code']) && strlen($_POST['code']) > 3 && strlen($_POST['code']) < 6 && !empty($_POST['code'])) {
    //TODO make sure it is a valid code
    $query .= sprintf(" AND `code` = '%s'", mysql_escape_string($_POST['code']));
}
if (isset($_POST['quantity']) && $_POST['quantity'] > 0 && !empty($_POST['quantity'])) {
    $query .= sprintf(" AND `quantity` = '%s'", mysql_escape_string($_POST['quantity']));
}
if (isset($_POST['comments']) && !empty($_POST['comments'])) {
    $query .= sprintf(" AND `comments` LIKE '%s'", mysql_escape_string($_POST['comments']));
}

switch ($_POST['sortby']) {
    case "timestamp":
    case "awardedto":
    case "awardedby":
    case "code":
    case "quantity":
    case "comments":
        $query .= " ORDER BY " . $_POST['sortby'];
        if ($_POST['sortmethod'] == "ASC" || $_POST['sortmethod'] == "DESC")
            $query .= " " . $_POST['sortmethod'];
        break;
}
if ($_POST['page'] < 1)
    $_POST['page'] = 1;
$limitL = ($_POST['page'] - 1) * 50;
$query .= " LIMIT " . $limitL . ",50";

$result = mysql_query($query) or die('Invalid query: ' . mysql_error());

$i = 0;
while ($row[$i++] = mysql_fetch_assoc($result)) {
    //TODO: add rows with same codes quantities into one single row
}
$rowcount = --$i; //Otherwise returns extra empty NULL row
?>
<html>
    <head>
        <title>Points Admin</title>
        <?php require "include/head.inc"; ?>
        <script type="text/javascript">
            function openHints() {
                window.open("pointindex.php", "_blank", "toolbar=no, scrollbars=yes, resizable=no, top=500, left=500, width=500, height=600");
            }

            function sortForm(col) {
                if (document.getElementById("sortby").value == col) {
                    if (document.getElementById("sortmethod").value == "ASC") {
                        document.getElementById("sortmethod").value = "DESC";
                    } else {
                        document.getElementById("sortmethod").value = "ASC";
                    }
                }
                document.getElementById("sortby").value = col;
                document.getElementById("pointadmin").submit();
            }
            $(function () {
                $("#awardedto").autocomplete({
                    delay: 300,
                    minlength: 2,
                    source: "./getusers.php"
                });
            });
            function editPoint(pointID) {
                $.post("pointadmin_functions.php", {task: "edit", pointid: pointID}, function (data) {
                    alert(data)
                });
            }
            function deletePoint(pointID) {
                if (confirm("Are you sure you want to delete this point?")) {
                    $.post("pointadmin_functions.php", {task: "delete", pointid: pointID}, function (data) {
                        alert(data)
                    });
                }
            }
            var pointsOnPage = [<?php
        for ($i = 0; $i < $rowcount; $i++) {
            echo $row[$i]['pointid'] . ($i + 1 < $rowcount ? "," : "");
        }
        ?>];
            var pointsSelected = new Array();
            function togglePoint(pointID) {
                if (pointID == "all") {
                    for (var i = 0; i < pointsOnPage.length; i++) {
                        document.getElementById("pointcheck" + pointsOnPage[i]).checked = document.getElementById("pointcheckall").checked;
                        togglePoint(pointsOnPage[i]);
                    }
                    return;
                }
                if (document.getElementById("pointcheck" + pointID).checked) {
                    pointsSelected.push(pointID);
                } else {
                    for (var i = pointsSelected.length - 1; i >= 0; i--) {
                        if (pointsSelected[i] === pointID) {
                            pointsSelected.splice(i, 1);
                        }
                    }
                }
            }
        </script>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <h1>Search for Points Awarded</h1>
        <div class="center">
            <form id="pointadmin" action="" method="POST">
                <input id="sortby" name="sortby" type="hidden" value="<?php echo ($_POST['sortby'] ? $_POST['sortby'] : "ASC"); ?>" />
                <input id="sortmethod" name="sortmethod" type="hidden" value="<?php echo $_POST['sortmethod']; ?>" />
                <table class="award">
                    <tr>
                        <td class="awardlabel">Code</td>
                        <td><input id="code" name="code" type="text" maxlength="5" style="width: 50px;" value="<?php echo $_POST['code']; ?>" />&nbsp;&nbsp;[ <a onclick="openHints()" style="text-decoration: underline; color:blue;" href="#">list</a> ]</td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Quantity</td>
                        <td><input id="quantity" name="quantity" type="number" min="1" max="20" value="<?php echo $_POST['quantity']; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded to</td>
                        <td> <input id="awardedto" name="awardedto" type="text" placeholder="net-id awarded to" value="<?php echo $_POST['awardedto']; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Comments</td>
                        <td><input id="comments" name="comments" type="text" style="width: 100%;" value="<?php echo $_POST['comments']; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded by</td>
                        <td><input id="awardedby" name="awardedby" type="text" placeholder="net-id awarded by" value="<?php echo $_POST['awardedby']; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded after</td>
                        <td><input id="datebefore" name="datebefore" type="date" value="<?php echo ($_POST['datebefore'] ? $_POST['datebefore'] : date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 7, date("Y")))); ?>"/></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded before</td>
                        <td><input id="dateafter" name="dateafter" type="date" value="<?php echo ($_POST['dateafter'] ? $_POST['dateafter'] : date("Y-m-d")); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel"></td>
                        <td><button name="page" type="Submit" value="0" >Search</button></td>
                    </tr>
                </table>
                <?php if ($config['debug'] || $_SESSION['debug']) { ?>
                    <br>
                    <div class="alert alert-warning" role="alert">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        <?php echo $query; ?>
                    </div>
                <?php } ?>
                <p><?php echo mysql_num_rows($result); ?> rows returned</p>
                <div id="pointadmintable">
                        <div>
                            <div class="col-md-6" style="text-align: left;"><?php if ($_POST['page'] != 1) { ?><button name="page" type="Submit" value="<?php echo ($_POST['page'] - 1); ?>" class="btn btn-sm">Previous</button><?php } ?></div>
                            <div class="col-md-6" style="text-align: right;"><?php if ($rowcount > 49) { ?><button name="page" type="Submit" value="<?php echo ($_POST['page'] + 1); ?>" class="btn btn-sm">Next</button><?php } ?></div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-condensed">

                        <thead>
                            <tr>
                                <th><input type="checkbox" id="pointcheckall" onclick="togglePoint('all')" /></th>
                                <th onclick="sortForm('timestamp')">Timestamp</th>
                                <th onclick="sortForm('code')">Code</th>
                                <th onclick="sortForm('quantity')">Quantity</th>
                                <th onclick="sortForm('awardedto')">Awarded To</th>
                                <th onclick="sortForm('awardedby')">Awarded By</th>
                                <th onclick="sortForm('comments')">Comments</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php for ($i = 0; $i < $rowcount; $i++) { ?>
                            <tr id="point[<?php echo $row[$i]['pointid']; ?>]">
                                <td><input type="checkbox" id="pointcheck<?php echo $row[$i]['pointid']; ?>" onclick="togglePoint(<?php echo $row[$i]['pointid']; ?>)" /></td>
                                <td><?php echo $row[$i]['timestamp']; ?></td>
                                <td><?php echo $row[$i]['code']; ?></td>
                                <td><?php echo $row[$i]['quantity']; ?></td>
                                <td><?php echo $row[$i]['awardedto']; ?></td>
                                <td><?php echo $row[$i]['awardedby']; ?></td>
                                <td><?php echo $row[$i]['comments']; ?></td>
                                <td><input type="button" value="Edit" onclick="editPoint(<?php echo $row[$i]['pointid']; ?>)" class="btn btn-xs " />
                                    <input type="button" value="Delete" onclick="deletePoint(<?php echo $row[$i]['pointid']; ?>)" class="btn btn-xs btn-danger" /></td>
                                </form>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </form>
        </div>
        <?php require "include/footer.inc"; ?>
    </body>
</html>
