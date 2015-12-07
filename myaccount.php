<?php
$page['auth'] = 1;
require 'include/functions.inc';
?>
<html>
    <head>
        <title>Account Settings</title>
        <?php require 'include/head.inc'; ?>
        <script>
            function changepass() {
                if (confirm("Are you sure you want to change your password?")) {
                    $.post("myaccount_functions.php", {task: "changepass", currentpass: $("#currentpass").val(), newpass: $("#newpass").val(), confirmnewpass: $("#confirmnewpass").val()}, function (data) {
                        alert(data);
                    });
                }
            }
        </script>
    </head>
    <body>
<?php require 'include/header.inc'; ?>
        <h1>My Account</h1>
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