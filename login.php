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
    require "include/hash.php";

    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

    $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($user));
    $result = mysql_query($query) or die('Invalid query (A): ' . mysql_error());
    $data = mysql_fetch_assoc($result);
    if ($data['user'] === $user) {
        if (validate_password($pass, $data['pass']) && $data['auth'] > 0) {
            mysql_query("UPDATE `dsp_users` SET `num_login` = `num_login` + 1 WHERE `user` = \"%s\";",mysql_escape_string($user));
            $_SESSION['user'] = $user;
            $_SESSION['auth'] = $data['auth'];
            if ($data['auth'] >= 100)//webmaster
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
    if($data['pass'] == "reset"){
      $errormsg = "You need to reset your password.  Please contact the webmaster at <a href=\"mailto:" . $config['webmaster_email'] . "\">" . $config['webmaster_email'] . "</a>";
    }
    if($data['pass'] == "disabled" || $data['auth'] === 0){
      $errormsg = "Your account has been disabled.  For more information, please contact the webmaster at <a href=\"mailto:" . $config['webmaster_email'] . "\">" . $config['webmaster_email'] . "</a>";
    }
} else {

}
?>
<html>
    <head>
        <title><?php echo $config['name_abbr']; ?> Portal - Login</title>
        <?php include "include/head.inc"; ?>
    </head>
    <body>
        <div class="container mycontent" style="height:100%">
                <div id="sidebar">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="#">DSP</a>
                            </div>
                            <div class="collapse navbar-collapse">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="active"><a href="#">Sign in</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <div id="header">
                    <span class="header-msg">DSP Portal - Login</span>
                </div>
                <div id="login-message"></div>
                <?php if (!empty($errormsg)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                        <?php echo $errormsg; ?>
                    </div>
                <?php } ?>
                <div class="panel panel-default center-block" style="width:40%;">

                    <div id="login-box" class="panel-heading">
                        <h3 class="panel-title" style="font-weight: bold">Sign in</h3>
                    </div>
                    <div class="panel-body">
                        <form id="login" name="login" method="POST" action="login.php" class="form-horizontal">
                            <input id="attempt" name="attempt" type="hidden" value="<?php echo ((filter_input(INPUT_POST, 'attempt', FILTER_SANITIZE_NUMBER_INT)) + 1) . ""; ?>" />

                            <div class="form-group">
                                <label for="user" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="user" name="user" placeholder="Username" value="<?php echo filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
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
                </div>
            </div>
    </body>
</html>
<?php
mysql_close($mysql_link);
