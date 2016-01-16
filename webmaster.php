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

          function resetpass(){
            document.getElementById("givenpass").value = "";
            if (confirm("Are you sure you want to reset ")) {
                $.post("webmaster_functions.php", {task: "resetpass", mypass: $("#mypass").val(), usertoreset: $("#usertoreset").val()}, function (data) {
                    var response = jQuery.parseJSON(data);
                    <?php if($_SESSION['debug']) { ?>
                      console.log(response.status);
                      console.log(response.newpass);
                    <?php } ?>
                    if(response.status == 1) {
                      alert("Password reset success!");
                      document.getElementById("givenpass").value = response.newpass;
                    } else {
                      alert("Password reset failed!");
                    }
                });
            }
            document.getElementById("mypass").value = "";
            document.getElementById("usertoreset").value = "";
          }
        </script>
    </head>
    <body>
        <?php require "include/header.inc"; ?>
        <h1>Webmaster Tools</h1>
        <h3>Reset user password</h3>
        <form id="resetpass" method="POST">
            Enter your password:<br>
            <input type="password" id="mypass" name="mypass" /><br>
            Enter the user who you would like to reset:<br>
            <input type="password" id="usertoreset" name="usertoreset" /><br>
            New password:<br>
            <input type="text" id="givenpass" readonly /><br>
            <input type="button" id="resetpassbutton" value="Reset Password" onclick="resetpass()" />
        </form>
    </body>
</html>
