<?php
require "config.inc";
session_start();

if ($_SESSION['auth'] < $page['auth']) {
    //you're don't have the authority to be on this page!
    echo "<h1>401 - Unauthorized</h1><br>";
    if (!isset($_SESSION['auth']))
        echo "<a href=\"login.php\">Login here.</a>";
    exit;
}

if ($config['timeout'] > 0 && $_SESSION['timeout'] + $config['timeout'] > time()) {
    //Session timeout
    echo "<h1>401 - Unauthorized</h1><br>";
    echo "Clearance level " . $page['auth'] . " required. <a href=\"login.php\">Login here.</a>";
    exit;
}

function valid_net_id($netid) {
    if (strlen($netid) < 1 && strlen($netid) > 25)
        return false;
    if (preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $netid)) {
        //echo "fail: ".$netid."<br>";
        return false;
    }
    return true;
}
