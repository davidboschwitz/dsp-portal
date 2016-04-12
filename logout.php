<?php
    //Session timeout
    session_destroy();
    //session_stop();
    session_start();
    $_SESSION['errormsg'] = "You have been logged out.";
    header("Location: login.php");
    exit();
