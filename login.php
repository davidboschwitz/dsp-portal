<?php
session_start();
session_destroy();
//session_stop();
$page['no_timeout'] = TRUE;

include "include/functions.inc";

$errormsg = "";
//If a login attempt has been made
if (filter_input(INPUT_POST, 'attempt', FILTER_SANITIZE_NUMBER_INT) > 0) {
    session_start();
    require "include/mysql.inc";

    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

    $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($user));
    $result = mysql_query($query) or die('Invalid query (A): ' . mysql_error());
    $data = mysql_fetch_assoc($result);
    if ($data['user'] === $user) {
        if ($data['pass'] === md5($pass)) {
            $_SESSION['user'] = $user;
            $_SESSION['auth'] = $data['auth'];
            if ($data['auth'] >= 10)//webmaster
                $_SESSION['debug'] = true;
            $_SESSION['full_name'] = $data['first_name'] . " " . $data['last_name'];
            $_SESSION['first_name'] = $data['first_name'];
            $_SESSION['last_name'] = $data['last_name'];
            $_SESSION['time'] = time();
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
        <?php include "include/head.inc"; ?>
    </head>
    <body>
        <div class="container">
            <div id="header">
                <span class="header-msg">DSP Portal - Login</span>
            </div>
            <p style="color: red;"><?php echo $errormsg; ?></p>
            <div id="login-message"></div>
            <figure class="highlight">
                <div id="login-box" style="width:40%; padding: 0.5em">
                    <form id="login" name="login" method="POST" action="login.php" class="form-horizontal">
                        <input id="attempt" name="attempt" type="hidden" value="<?php echo ((filter_input(INPUT_POST, 'attempt', FILTER_SANITIZE_NUMBER_INT)) + 1) . ""; ?>" />

                        <div class="form-group <?php if (!empty($errormsg)) echo " has-error" ?>">
                            <label for="user" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user" name="user" placeholder="Username" value="<?php echo filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING); ?>" />
                            </div>
                        </div>
                        <div class="form-group <?php if (!empty($errormsg)) echo " has-error" ?>">
                            <label for="pass" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" id="submit" class="btn btn-default" value="Log in" />
                            </div>
                        </div>
                    </form>
                </div>
            </figure>
        </div>
    </body>
</html>
<?php
mysql_close($mysql_link);
