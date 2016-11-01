<?php

require_once('vendor/autoload.php');

const TITLE = 'My amazing app';
const REDIRECT = '/about.php';

session_start();

$client = new Google_Client();
$client->setApplicationName(TITLE);
$client->setClientId('436234700430-95t4dmq8ktglphp3n0qcnt4qe5baa0m2.apps.googleusercontent.com');
$client->setClientSecret('iE93KMLDh2_mTqdySSLrMDZS');
$client->setRedirectUri(REDIRECT);
$client->setScopes(array(Google_Service_Plus::PLUS_ME));
$plus = new Google_Service_Plus($client);

if (isset($_REQUEST['logout'])) {
        unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
        if (strval($_SESSION['state']) !== strval($_GET['state'])) {
                error_log('The session state did not match.');
                exit(1);
        }

        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
        header('Location: ' . REDIRECT);
}

if (isset($_SESSION['access_token'])) {
        $client->setAccessToken($_SESSION['access_token']);
}

if ($client->getAccessToken() && !$client->isAccessTokenExpired()) {
        try {
                $me = $plus->people->get('me');
                $body = '<PRE>' . print_r($me, TRUE) . '</PRE>';
        } catch (Google_Exception $e) {
                error_log($e);
                $body = htmlspecialchars($e->getMessage());
        }
        # the access token may have been updated lazily
        $_SESSION['access_token'] = $client->getAccessToken();
} else {
        $state = mt_rand();
        $client->setState($state);
        $_SESSION['state'] = $state;
        $body = sprintf('<P><A HREF="%s">Login</A></P>',
            $client->createAuthUrl());
}

?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
        <TITLE><?= TITLE ?></TITLE>
</HEAD>
<BODY>
        <?= $body ?>
        <P><A HREF="<?= REDIRECT ?>?logout">Logout</A></P>
</BODY>
</HTML>
