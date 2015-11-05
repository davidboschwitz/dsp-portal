<?php
session_start();
session_destroy();
//session_stop();

include "include/functions.inc";

$errormsg = "";
//If a login attempt has been made
if ($_POST["attempt"] > 0) {
    session_start();
    include "include/mysql.inc";

    $query = sprintf("SELECT * FROM `dsp`.`dsp_users` WHERE `user` = '%s'", mysql_real_escape_string($_POST['user']));
    $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
    $data = mysql_fetch_assoc($result);
    if ($data['user'] == $_POST['user']) {
        if ($data['pass'] == md5($_POST['pass'])) {
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['auth'] = $data['auth'];
            if ($data['auth'] >= 10)//webmaster
                $_SESSION['debug'] = true;
            $_SESSION['full_name'] = $data['first_name'] . " " . $data['last_name'];
            $_SESSION['first_name'] = $data['first_name'];
            $_SESSION['last_name'] = $data['last_name'];
            header("Location: ./mypoints.php");
            exit;
        }
    }
    $errormsg = "User or Password incorrect";
} else {
    
}
?>
<html>
    <head>
        <title>DSP Portal - Login</title>
        <style>
<?php include "include/style.css"; ?>
        </style>
    </head>
    <body>
        <div id="header">
            <span class="header-msg">DSP Portal - Login</span>
        </div>
        <span style="color: red;"><?php echo $errormsg; ?></span>
        <div id="login-message"></div>
        <div id="login-box">
            <form id="login" name="login" method="POST" action="login.php">
                <input id="attempt" name="attempt" type="hidden" value="<?php echo (((int) trim($_POST['attempt'])) + 1) . ""; ?>" />
                <input id="user" name="user" type="text" placeholder="Username" value="<?php echo $_POST['user']; ?>"/><br>
                <input id="pass" name="pass" type="password" placeholder="Password" /><br>
                <input id="submit" type="submit" value="Login" />
            </form>
        </div>
    </body>
</html>