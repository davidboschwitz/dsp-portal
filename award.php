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
$page['auth'] = 5;
require "include/functions.inc";
session_start();
?>
<html>
    <head>
        <title>Award Points</title>
        <?php require "include/head.inc"; ?>
        <script type="text/javascript">
            function multipleCheck() {
                if (document.getElementById("multiple").checked) {
                    document.getElementById("awardedto").disabled = true;
                    document.getElementById("awardedto").readOnly = true;
                    document.getElementById("awardedto").value = "";
                    document.getElementById("awardedto").required = false;

                    document.getElementById("awardedtomultiple").disabled = false;
                    document.getElementById("awardedtomultiple").readOnly = false;
                    document.getElementById("awardedtomultiple").required = true;
                } else {
                    document.getElementById("awardedto").disabled = false;
                    document.getElementById("awardedto").readOnly = false;
                    document.getElementById("awardedto").required = true;

                    document.getElementById("awardedtomultiple").disabled = true;
                    document.getElementById("awardedtomultiple").readOnly = true;
                    document.getElementById("awardedtomultiple").value = "";
                    document.getElementById("awardedtomultiple").required = false;
                }
            }
            function openHints() {
                window.open("pointindex.php", "_blank", "toolbar=no, scrollbars=yes, resizable=no, top=500, left=500, width=500, height=600");
            }
            $(function () {
                $("#awardedto").autocomplete({
                    delay: 300,
                    minlength: 2,
                    source: "./getusers.php"
                });
            });
            $(function (data) {
                $("#awardedtomultiple").autocomplete({
                    delay: 300,
                    minlength: 2,
                    source: "./getusers.php?multiple"
                });

            });

            function submitaward() {
                if (!document.getElementById("multiple").checked)
                    if ($("#awardedto").val() === "") {
                        $("#awardedto").class += " has-error";
                        return false;
                    }
            }

            function startTime() {
                var today = new Date();
                var month = today.getMonth() + 1;
                var day = today.getDate();
                var year = today.getYear() + 1900;
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('date').innerHTML =
                month + "/" + day + "/" + year + " " + h + ":" + m;
                var t = setTimeout(startTime, (61 - s) * 1000);
            }

            function checkTime(i) {
                 if (i < 10)
                     i = "0" + 1;
                 return i;
            }
        </script>
    </head>
    <body onload="multipleCheck(), startTime()">
        <?php require "include/header.inc"; ?>
        <form id="awardpts" action="submitaward.php" method="POST" on class="form-group">
            <h1>Award new points</h1>
            <div class="center-block" style="width: 50%">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <tr class="form-inline">
                        <td class="awardlabel">Code</td>
                        <td><input id="code" name="code" type="text" maxlength="5" readonly required class="form-control " />&nbsp;[ <a onclick="openHints()" style="text-decoration: underline; color:blue;" href="#">list</a> ]</td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Quantity</td>
                        <td><input id="quantity" name="quantity" type="number" min="1" max="20" value="1" required class="form-control" style="width:15%" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Award to</td>
                        <td> <input id="awardedto" name="awardedto" type="text" placeholder="net-id to award to" required class="form-control" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Award to multiple members?</td>
                        <td><input id="multiple" name="multiple" type="checkbox" onchange="multipleCheck()" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Award to multiple<br><i>(comma separate users)</i></td>
                        <td><textarea id="awardedtomultiple" name="awardedtomultiple" type="text" placeholder="multiple net-ids (comma separated)" style="width: 390px; height:80px; margin:0px" class="form-control" ></textarea></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Comments</td>
                        <td><input id="comments" name="comments" type="text" style="width: 100%;" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded by</td>
                        <td><p class="form-control-static"><?php echo $_SESSION['user']; ?></p></td>
                    </tr>
                    <tr>
                        <td class="awardlabel">Awarded on</td>
                        <td><div id="date" class="form-control-static"><?php echo date("Y-m-d h:m:s"); ?></div></td>
                    </tr>
                    <tr>
                        <td class="awardlabel"></td>
                        <td><input id="submit" type="submit" value="Submit" onclick="submitaward()" class="btn btn-default" /></td>
                    </tr>
                </table>
            </div>
        </form>
        <?php require "include/footer.inc"; ?>
    </body>
</html>
