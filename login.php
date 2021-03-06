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
//session_start();
//session_stop();
$page['no_timeout'] = TRUE;
$page['auth'] = 0;
$page['title'] = "Portal - Login";

require "include/functions.inc";
require "include/ldap.php";
if(!isset($errormsg)){
    $errormsg = "";
    if(isset($_SESSION['errormsg']))
        $errormsg = $_SESSION['errormsg'];
}
session_destroy();
//If a login attempt has been made
if (filter_input(INPUT_POST, 'attempt', FILTER_SANITIZE_NUMBER_INT) > 0) {
    session_start();

    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    if(!isset($user) || empty($user)) {
        //blah
        goto main_page;
    }
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

    // call authenticate function
    if(ldap_authenticate($user,$pass)){
    
    require "include/mysql.inc";
    
    $query = sprintf("SELECT * FROM `$mysql_db`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($user));
    $result = mysql_query($query) or die('Invalid query (A): ' . mysql_error());
    $data = mysql_fetch_assoc($result);
    if ($data['user'] === $user) {
        if ($data['auth'] > 0) {
            mysql_query(sprintf("UPDATE `dsp_users` SET `num_login` = (`num_login` + 1) WHERE `user` = '%s';",mysql_escape_string($user)));
            $_SESSION['user'] = $user;
            $_SESSION['auth'] = $data['auth'];
            if ($data['auth'] >= 100)//webmaster
                $_SESSION['debug'] = true;
            $_SESSION['full_name'] = $data['first_name'] . " " . $data['last_name'];
            $_SESSION['first_name'] = $data['first_name'];
            $_SESSION['last_name'] = $data['last_name'];
            $_SESSION['position'] = $data['position'];
            $_SESSION['class'] = $data['class'];
            $_SESSION['time'] = time();
            $_SESSION['pass'] = $data['pass'];
            $_SESSION['logged_in'] = true;
            header("Location: ./mypoints.php");
            mysql_close($mysql_link);
            exit;
        }
    }
    $errormsg = "User or Password incorrect";
    if($data['pass'] == "reset") {
      $errormsg = "You need to reset your password.  Please contact the webmaster at <a href=\"mailto:" . $config['webmaster_email'] . "\">" . $config['webmaster_email'] . "</a>";
    }
    if($data['pass'] == "disabled" || $data['auth'] == 0) {
      $errormsg = "Your account has been disabled.  For more information, please contact the webmaster at <a href=\"mailto:" . $config['webmaster_email'] . "\">" . $config['webmaster_email'] . "</a>";
    }
     

    mysql_close($mysql_link);
    } else {
        $errormsg = "User or Password incorrect";
    }
} else {
  unset($_SESSION['logged_in']);
  $_SESSION['auth'] = 0;
}
main_page:
?>
<html>
    <head>
        <title><?php echo $config['name_abbr']; ?> Portal - Login</title>
        <?php include "include/head.inc"; ?>
    </head>
    <body>
        <?php require 'include/header.inc'; ?>
                <div id="login-message"></div>
                <?php if (!empty($errormsg)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                        <?php echo $errormsg; ?>
                    </div>
                <?php } ?>
                <div class="panel panel-default center-block login-box">

                    <div id="login-box" class="panel-heading">
                        <h3 class="panel-title" style="font-weight: bold">Sign in</h3>
                    </div>
                    <div class="panel-body">
                        <form id="login" name="login" method="POST" action="login.php" class="form-horizontal">
                            <input id="attempt" name="attempt" type="hidden" value="<?php echo (((filter_input(INPUT_POST, 'attempt', FILTER_SANITIZE_NUMBER_INT)) + 1) . ""); ?>" />

                            <div class="form-group">
                                <label for="user" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="user" name="user" placeholder="Username" value="<?php echo filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING); ?>" autofocus />
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
                                    <input type="submit" id="submit" class="btn btn-success btn-block" value="Log in" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
      <?php require 'include/footer.inc'; ?>
    </body>
</html>
<?php
