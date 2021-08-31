<?php
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:  {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }

require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('credentials.json');
$client->setRedirectUri('http://localhost/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE);

// $client = new Google_Client();
// $client->setApplicationName('Google Drive API PHP Quickstart');
// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
// $client->setScopes(Google_Service_Drive::DRIVE);
// $client->setAuthConfig('credentials.json');
// $client->setAccessType('offline');
// $client->setPrompt('select_account consent');

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/fewfew';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

?>