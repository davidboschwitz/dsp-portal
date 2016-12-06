<?php
/*
https://www.googleapis.com/auth/userinfo.email
https://www.googleapis.com/auth/userinfo.profile
*/
phpinfo();
/*
use Google\Auth\ApplicationDefaultCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

// specify the path to your application credentials
putenv('GOOGLE_APPLICATION_CREDENTIALS=/include/client_secret.json.inc');
//
// // define the scopes for your API call
// $scopes = ['https://www.googleapis.com/auth/userinfo.profile', 'https://www.googleapis.com/auth/userinfo.email'];
//
// // create middleware
// $middleware = ApplicationDefaultCredentials::getMiddleware($scopes);
// $stack = HandlerStack::create();
// $stack->push($middleware);
//
// // create the HTTP client
// $client = new Client([
//   'handler' => $stack,
//   'base_url' => 'https://www.googleapis.com',
//   'auth' => 'google_auth'  // authorize all requests
// ]);
$client = new Google_Client();
$client->setAuthConfig('include/client_secret.json.inc');
$client->addScope('https://www.googleapis.com/auth/userinfo.email');
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/callback.php');
// make the request
$response = $client->get('auth/userinfo.profile');

// show the result!
var_dump($response->getBody());
