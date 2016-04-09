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

          function haspass(){
              var nodes = document.getElementById("disdis").getElementsByTagName('*');
              if($("#mypass").val()){
                  for(var i = 0; i < nodes.length; i++) {
                       nodes[i].disabled = false;
                  }
                  document.getElementById("passwarn").style="color: black";
              } else {
                for(var i = 0; i < nodes.length; i++) {
                     nodes[i].disabled = true;
                }
                document.getElementById("passwarn").style="color: red";
              }
          }

          function toggledebug() {
                $.post("webmaster_functions.php", {task: "toggledebug"}, function (data) {
                    <?php if($_SESSION['debug']) { ?>
                      console.log(data);
                      //console.log(response.status);
                      //console.log(response.newpass);
                    <?php } ?>
                    var response = jQuery.parseJSON(data);
                    swal("Debug", response.msg, "info");
                    if(response.status == 1) {
                      document.getElementById("debugbutton").value = "Turn debug OFF";
                    }
                    if(response.status == 2) {
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
              text: "Are you sure you want to reset " + resetme+"\'s password?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, reset it!",
              closeOnConfirm: false
            },
            function(){
                $.post("webmaster_functions.php", {task: "resetpass", mypass: my, usertoreset: resetme}, function (data) {
                    <?php if($_SESSION['debug']) { ?>
                      console.log(data);
                      //console.log(response.status);
                      //console.log(response.newpass);
                    <?php } ?>
                    var response = jQuery.parseJSON(data);
                    if(response.status == 1) {
                      swal("Success!", "Password reset successful!", "success");
                      document.getElementById("givenpass").value = response.newpass;
                    } else {
                      swal("Password reset failed!", response.error, "error");
                    }
                });
              });
            document.getElementById("mypass").value = "";
            document.getElementById("usertoreset").value = "";
            haspass();
          }

          function createpointdef(){
            document.getElementById("givenpass").value = "";
            if (confirm("Are you sure you want to add this point?")) {
                $.post("webmaster_functions.php", {task: "createpointdef", mypass: $("#mypass").val(), code: $("#new_point_code").val(), pts: $("#new_point_pts").val(), desc: $("#new_point_def").val()}, function (data) {
                    <?php if($_SESSION['debug']) { ?>
                      console.log(data);
                      //console.log(response.status);
                      //console.log(response.newpass);
                    <?php } ?>
                    var response = jQuery.parseJSON(data);
                    if(response.status == 1) {
                      alert("Success");
                      alert(response.msg);
                    } else {
                      alert("Add point failed!");
                      alert(response.error);
                    }
                });
            }
            document.getElementById("new_point_code").value = "";
            document.getElementById("new_point_pts").value = "";
            document.getElementById("new_point_def").value = "";
            document.getElementById("mypass").value = "";
            haspass();
          }

          function createuser(){
            alert("Not yet implemented!");
          }
        </script>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <h1>Webmaster Tools</h1>
        <h3>Toggle Debug</h3>
        Note: Debug will only ever be on for webmasters (auth > 100).<br>
        <?php if($_SESSION['debug']) { ?>
          <input type="button" id="debugbutton" value="Turn debug OFF" onclick="toggledebug()" />
        <?php } else { ?>
          <input type="button" id="debugbutton" value="Turn debug ON" onclick="toggledebug()" />
        <?php } ?>

        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4" style="text-align: center">
            <h3 id="passwarn" style="color:red">You must enter your password to enable the below features</h3>
            Enter your password:<br>
            <input type="password" id="mypass" name="mypass" required onchange="haspass()" /><br>

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
                  User's authentication level:<br>
                  <input type="number" id="new_auth" name="new_auth" min="0" max="127" required disabled /><br>
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
      </div>
    </body>
</html>
