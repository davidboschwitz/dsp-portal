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

require "config.inc";
session_start();
if($page['auth'] > 0 ){
    if ($_SESSION['auth'] < $page['auth']) {
        //you don't have the authority to be on this page!
        echo "<h1>401 - Unauthorized</h1><br>";
        if (!isset($_SESSION['auth']))
            echo "<a href=\"login.php\">Login here.</a>";
        exit;
    }

    if ($config['timeout'] > 0 && !isset($page['no_timeout'])) {
        if ($_SESSION['time'] + $config['timeout'] < time()) {
            //Session timeout
            $_SESSION['errormsg'] = "Session Timed-out. You have been automatically logged out.";
            header("Location: login.php");
            exit;
        }
        $_SESSION['time'] = time();
    }
}

function valid_net_id($netid) {
    if (strlen($netid) < 1 && strlen($netid) > 25)
        return false;
    //TODO fix regex because it matches to nothing
    if (preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $netid)) {
        //echo "fail: ".$netid."<br>";
        return false;
    }
    return true;
}
