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
$page['title'] = "Webmaster Tools";
require "include/functions.inc";
?>
<html>
    <head>
        <title>Webmaster Tools</title>
        <?php require "include/head.inc"; ?>
        <script type="text/javascript">
            $(function () {
                $("#usertoreset").autocomplete({
                    delay: 300,
                    minlength: 2,
                    source: "./getusers.php"
                });
            });

            function openHints() {
                window.open("pointindex.php", "_blank", "toolbar=no, scrollbars=yes, resizable=no, top=500, left=500, width=500, height=600");
            }


            function ugh() {
                window.open("pointindex.php", "_blank", "toolbar=no, scrollbars=yes, resizable=no, top=500, left=500, width=500, height=600");
            }

            function haspass() {
                var nodes = document.getElementById("disdis").getElementsByTagName('*');
                if ($("#mypass").val()) {
                    for (var i = 0; i < nodes.length; i++) {
                        nodes[i].disabled = false;
                    }
                    document.getElementById("passwarn").style = "color: black";
                } else {
                    for (var i = 0; i < nodes.length; i++) {
                        nodes[i].disabled = true;
                    }
                    document.getElementById("passwarn").style = "color: red";
                }
            }

            function endPass() {
                if (!document.getElementById("saveit").checked)
                    document.getElementById("mypass").value = "";
                haspass();
            }

            function toggledebug() {
                $.post("webmaster_functions.php", {task: "toggledebug"}, function (data) {
<?php if ($_SESSION['debug']) { ?>
                        console.log(data);
                        //console.log(response.status);
                        //console.log(response.newpass);
<?php } ?>
                    var response = jQuery.parseJSON(data);
                    swal("", response.msg, "info");
                    if (response.status == 1) {
                        document.getElementById("debugbutton").value = "Turn debug OFF";
                    }
                    if (response.status == 2) {
                        document.getElementById("debugbutton").value = "Turn debug ON";
                    }
                });
                haspass();
            }

            function resetpass() {
                document.getElementById("givenpass").value = "";
                var my = document.getElementById("mypass").value;
                var resetme = document.getElementById("usertoreset").value;
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to reset " + resetme + "\'s password?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, reset it!",
                    closeOnConfirm: false
                },
                        function () {
                            $.post("webmaster_functions.php", {task: "resetpass", mypass: my, usertoreset: resetme}, function (data) {
<?php if ($_SESSION['debug']) { ?>
                                    console.log(data);
                                    //console.log(response.status);
                                    //console.log(response.newpass);
<?php } ?>
                                var response = jQuery.parseJSON(data);
                                swal(response.title, response.msg, response.status);
                                if (response.status == 'success') {
                                    document.getElementById("givenpass").value = response.newpass;
                                }
                            });
                        });
                document.getElementById("usertoreset").value = "";
                endPass();
            }

            function createpointdef() {
                document.getElementById("givenpass").value = "";

                var code = document.getElementById("new_point_code").value;
                var pts = document.getElementById("new_point_pts").value;
                var def = document.getElementById("new_point_def").value;
                var my = document.getElementById("mypass").value;
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to add this point?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "rgb(140, 212, 245)",
                    confirmButtonText: "Yes, add it!",
                    closeOnConfirm: false
                },
                        function () {
                            $.post("webmaster_functions.php", {task: "createpointdef", mypass: my, code: code, pts: pts, desc: def}, function (data) {
<?php if ($_SESSION['debug']) { ?>
                                    console.log(data);
                                    //console.log(response.status);
                                    //console.log(response.newpass);
<?php } ?>
                                var response = jQuery.parseJSON(data);
                                swal(response.title, response.msg, response.status);
                            });
                        });

                document.getElementById("new_point_code").value = "";
                document.getElementById("new_point_pts").value = "";
                document.getElementById("new_point_def").value = "";
                endPass();
            }

            function updatePerson(num) {
                document.getElementById("givenpass").value = "";

                var user = document.getElementById("user" + num).value;
                var auth = document.getElementById("auth" + num).value;
                var cls = document.getElementById("class" + num).value;
                var pos = document.getElementById("pos" + num).value;
                var my = document.getElementById("mypass").value;

                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to update " + user + "\'s information?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "rgb(140, 212, 245)",
                    confirmButtonText: "Yes, update it!",
                    closeOnConfirm: false
                },
                        function () {
                            $.post("webmaster_functions.php", {task: "updateperson", mypass: my, user: user, auth: auth, pos: pos, "class": cls}, function (data) {
<?php if ($_SESSION['debug']) { ?>
                                    console.log(data);
                                    //console.log(response.status);
                                    //console.log(response.newpass);
<?php } ?>
                                var response = jQuery.parseJSON(data);
                                swal(response.title, response.msg, response.status);
                            });
                        });

                endPass();
            }

            function createuser() {
                document.getElementById("givenpass").value = "";

                var user = document.getElementById("new_user").value;
                var first = document.getElementById("new_firstname").value;
                var last = document.getElementById("new_firstname").value;
                var my = document.getElementById("mypass").value;

                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to create " + user + "?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "rgb(140, 212, 245)",
                    confirmButtonText: "Yes, create it!",
                    closeOnConfirm: false
                },
                        function () {
                            $.post("webmaster_functions.php", {task: "createuser", mypass: my, user: user, first: first, last: last}, function (data) {
<?php if ($_SESSION['debug']) { ?>
                                    console.log(data);
                                    //console.log(response.status);
                                    //console.log(response.newpass);
<?php } ?>
                                var response = jQuery.parseJSON(data);
                                swal(response.title, response.msg, response.status);
                            });
                        });
                document.getElementById("new_user").value = "";
                document.getElementById("new_firstname").value = "";
                document.getElementById("new_firstname").value = "";
                endPass();
            }
            function loadNewEditor() {
                //console.log(document.getElementById('editor-selector').value);
                if (document.getElementById('editor-selector').value < 0) {
                    document.getElementById('editor-selector').setAttribute("style", "height:0px");
                    //document.getElementById('editor-iframe').src = "";
                    return;
                }
                //document.getElementById('editor-iframe').src = "/webmaster_editor.php?pos=" + document.getElementById('editor-selector').value;

            }

            function openeditorwindow(){
                if (document.getElementById('editor-selector').value >= 0){
                    window.open('webmaster_editor.php?pos='+document.getElementById('editor-selector').value, '_blank', 'toolbar=no, scrollbars=yes, resizable=yes');
                }
            }

        </script>
    </head>
    <body onload="haspass()">
        <?php require "include/header.inc"; ?>
        <h3>Toggle Debug</h3>
        Note: Debug will only ever be on for webmasters (auth > 100).<br>
        <?php if ($_SESSION['debug']) { ?>
            <input type="button" id="debugbutton" value="Turn debug OFF" onclick="toggledebug()" class="btn btn-info btn-xs" />
        <?php } else { ?>
            <input type="button" id="debugbutton" value="Turn debug ON" onclick="toggledebug()" class="btn btn-info btn-xs" />
        <?php } ?>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: center">
                <h3 id="passwarn" style="color:red">You must enter your password to enable the below features</h3>
                Enter your password:<br>
                <input type="password" id="mypass" name="mypass" required onchange="haspass()" /> <input type="checkbox" id="saveit" title="save password (for this visit only)" /><br>

            </div>
        </div>

        <div id="disdis">
            <div class="row">
                <div class="col-md-4">
                    <h3>Reset user password</h3>
                    <form id="resetpass" method="POST">
                        Enter the user who you would like to reset:<br>
                        <input type="text" id="usertoreset" name="usertoreset" required disabled /><br>
                        New password:<br>
                        <input type="text" id="givenpass" readonly /><br>
                        <input type="button" id="resetpassbutton" value="Reset Password" onclick="resetpass()" disabled />
                    </form>
                </div>
                <div class="col-md-4">
                    <h3>Create new user</h3>
                    <form id="createuser" method="POST">
                        <!-- TODO: Implement exists function for creating new users here -->
                        New user's net-id:<br>
                        <input type="text" id="new_user" name="newuser" required disabled /><br>
                        User's first name:<br>
                        <input type="text" id="new_firstname" name="new_firstname" required disabled /><br>
                        User's last name:<br>
                        <input type="text" id="new_lastname" name="new_lastname" required disabled /><br>
                        <input type="button" id="createuserbutton" value="Create new user" onclick="createuser()" disabled />
                    </form>
                </div>
                <div class="col-md-4">
                    <h3>Create new point definition</h3>
                    <form id="createuser" method="POST">
                        New point code:&nbsp;&nbsp;[ <a onclick="openHints()" style="text-decoration: underline; color:blue;" href="#">code index</a> ]<br>
                        <input type="text" id="new_point_code" name="new_point_code" required disabled /><br>
                        Number of points given:<br>
                        <input type="number" id="new_point_pts" name="new_point_pts" min="1" max="50" required disabled /><br>
                        Point description:<br>
                        <input type="text" id="new_point_def" name="new_point_def" required disabled /><br>
                        <input type="button" id="createpointdefbutton" value="Create new point def" onclick="createpointdef()" disabled />
                    </form>
                </div>
            </div>
            <hr  />
            <div class="row" style="margin-left: 0px; margin-right: 0px">
                <h3>Page Editor</h3>
                <select id="editor-selector" onchange="loadNewEditor()">
                    <option value="-1">Select a file to edit</option>
                    <?php for ($i = 0; $i < count($config['editable_file_names']); $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $config['editable_file_names'][$i]; ?></option>
                    <?php } ?>
                </select>
                <button class="btn btn-info btn-xs" onclick="openeditorwindow()">Open editor</button>

<!--                <iframe id="editor-iframe" src="" width="100%" height="450px">
                </iframe>-->
            </div>
            <hr />
            <div class="row" style="margin-left: 0px; margin-right: 0px">
                <h3>Roster</h3>
                <?php
                ?>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Auth Level</th>
                            <th>Position</th>
                            <th>Class</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    require 'include/mysql.inc';
                    $query = "SELECT * FROM `{$mysql_db}`.`dsp_users` ORDER BY last_name;";
                    $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
                    $i = 0;
                    while ($row[$i] = mysql_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><input type="hidden" id="user<?php echo $i; ?>" value="<?php echo $row[$i]['user']; ?>" />
                                <?php echo $row[$i]['last_name'] . ', ' . $row[$i]['first_name'] . ' (' . $row[$i]['user'] . ')'; ?></td>
                            <td><input type="text" id="auth<?php echo $i; ?>" value="<?php echo $row[$i]['auth']; ?>" /></td>
                            <td><input type="text" id="pos<?php echo $i; ?>" value="<?php echo $row[$i]['position']; ?>" /></td>
                            <td>
                               <select id="class<?php echo $i; ?>">
                                <?php for($a = 0; $a < 24; $a++) { ?>
                                  <option value="<?php echo $a; ?> " <?php if($row[$i]['class'] == $a) echo" selected"; ?>><?php echo get_greek_num($a) ?></option>;
                                <?php } ?>
                               </select>
                            <td><input type="button" value="Update" onclick="updatePerson(<?php echo $i; ?>)" class="btn btn-xs " /></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    mysql_close();
                    ?>
                </table>
            </div>
        </div>
        <?php include 'include/footer.inc'; ?>
    </body>
</html>
