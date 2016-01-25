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
        <title>Points Admin</title>
        <?php require "include/head.inc"; ?>
        <script type="text/javascript">
          $(function () {
              $("#usertoreset").autocomplete({
                  delay: 300,
                  minlength: 2,
                  source: "./getusers.php"
              });
          });

          function haspass(){
              if($("#mypass").val()){
                document.getElementById("new_user").disabled = false;
                document.getElementById("new_firstname").disabled = false;
                document.getElementById("new_lastname").disabled = false;
                document.getElementById("new_auth").disabled = false;
                document.getElementById("createuserbutton").disabled = false;

                document.getElementById("usertoreset").disabled = false;
                document.getElementById("resetpassbutton").disabled = false;
                document.getElementById("new_").disabled = false;
              }else{
                document.getElementById("new_user").disabled = true;
                document.getElementById("new_firstname").disabled = true;
                document.getElementById("new_lastname").disabled = true;
                document.getElementById("new_auth").disabled = true;
                document.getElementById("createuserbutton").disabled = true;

                document.getElementById("usertoreset").disabled = true;
                document.getElementById("resetpassbutton").disabled = true;
                document.getElementById("new_").disabled = true;
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
                    alert(response.msg);
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
            if (confirm("Are you sure you want to reset " + $("#usertoreset").val())+"\'s password?") {
                $.post("webmaster_functions.php", {task: "resetpass", mypass: $("#mypass").val(), usertoreset: $("#usertoreset").val()}, function (data) {
                    <?php if($_SESSION['debug']) { ?>
                      console.log(data);
                      //console.log(response.status);
                      //console.log(response.newpass);
                    <?php } ?>
                    var response = jQuery.parseJSON(data);
                    if(response.status == 1) {
                      alert("Password reset success!");
                      document.getElementById("givenpass").value = response.newpass;
                    } else {
                      alert("Password reset failed!");
                      alert(response.error);
                    }
                });
            }
            document.getElementById("mypass").value = "";
            document.getElementById("usertoreset").value = "";
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
            <h3>You must enter your password to enable the below features</h3>
            Enter your password:<br>
            <input type="password" id="mypass" name="mypass" required onchange="haspass()" /><br>

          </div>
        </div>

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
      </div>
    </body>
</html>
