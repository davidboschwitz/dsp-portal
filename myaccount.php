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
$page['title'] = "My Account";
require 'include/functions.inc';
?>
<html>
    <head>
        <title>Account Settings</title>
        <?php require 'include/head.inc'; ?>
        <script>
            function changepass() {
             var current = document.getElementById("currentpass").value;
             var newP = document.getElementById("newpass").value;
             var confirm = document.getElementById("confirmnewpass").value;
              swal({
                title: "Are you sure?",
                text: "Are you sure you want to change your password?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "rgb(140, 212, 245)",
                confirmButtonText: "Yes, change it!",
                closeOnConfirm: false
               },
               function(){
                 $.post("myaccount_functions.php", {task: "changepass", currentpass: current, newpass: newP, confirmnewpass: confirm}, function (data) {
                   var response = JSON.parse(data);
                   swal(response.title, response.msg, response.status);
                 });
               });
                document.getElementById("currentpass").value = "";
                document.getElementById("newpass").value = "";
                document.getElementById("confirmnewpass").value = "";
            }
        </script>
    </head>
    <body>
<?php require 'include/header.inc'; ?>
        <div id="accountinfo">
          <strong>Name:</strong> <?php echo $_SESSION['full_name']; ?><br>
          <strong>Net-ID:</strong> <?php echo $_SESSION['user']; ?><br>
          <strong>Position:</strong> <?php echo $_SESSION['position']; ?><br>
          <strong>Class:</strong> <?php echo get_greek_num($_SESSION['class']); ?><br>
          <br>
        </div>
        <div id="changepassdiv">
            <form id="changepass" >
                Current Password: <br>
                <input type="password" name="currentpass" id="currentpass" placeholder="Current Pass" required /><br>
                New Password: <br>
                <input type="password" name="newpass" id="newpass" placeholder="New Password" required /><br>
                Confirm New Password: <br>
                <input type="password" name="confirmnewpass" id="confirmnewpass" placeholder="Confirm Password" /><br>
                <input type="button" onclick="changepass()" value="Change Password" required /><br>
            </form>
        </div>

<?php require 'include/footer.inc'; ?>
    </body>
</html>
