<?php

$page['auth'] = 1;
require 'include/functions.inc';

switch (filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING)) {
    case 'changepass':
        require 'include/mysql.inc';
        $currentPass = filter_input(INPUT_POST, 'currentpass', FILTER_SANITIZE_STRING);
        $newPass = filter_input(INPUT_POST, 'newpass', FILTER_SANITIZE_STRING);
        $confirmNewPass = filter_input(INPUT_POST, 'confirmnewpass', FILTER_SANITIZE_STRING);
        if ($newPass !== $confirmNewPass) {
            die("New Passwords do not match!");
        }
        $query = sprintf("SELECT * FROM `dsp`.`dsp_users` WHERE `user` = '%s'", mysql_escape_string($_SESSION['user']));
        $result = mysql_query($query);
        $data = mysql_fetch_assoc($result);

        if ($_SESSION['user'] !== $data['user']) {
            //should never happen, but you never know.
            die("Invalid user!");
        }
        if (md5($currentPass) !== $data['pass']) {
            echo $currentPass.','.$data['pass'] . '=' . md5($currentPass);
            die("Current password incorrect!");
        }
        $query = sprintf("UPDATE `dsp`.`dsp_users` SET `pass` = '%s' WHERE `dsp_users`.`user` = '%s';", md5(mysql_escape_string($newPass)), mysql_escape_string($_SESSION['user']));
        $result = mysql_query($query) or die('Invalid query: ' . mysql_error());
        echo "Changed Password Successfully";
        break;
}

mysql_close($mysql_link);
