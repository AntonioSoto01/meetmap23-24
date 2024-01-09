<?php
require 'common_functions.php';
require  '../vendor/autoload.php';
require '../config/config.php';
use League\OAuth2\Client\Provider\Github;

session_start(); // Remove if session.auto_start=1 in php.ini

$provider = new Github([
    'clientId'     => GITHUB_ID,
    'clientSecret' => GITHUB_SECRET,
    'redirectUri'  => BASE_URL . 'oauthGithub.php',
]);
$options = [
    'scope' => ['user','user:email'] // array or string; at least 'user:email' is required
];


if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl  = $provider->getAuthorizationUrl($options);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);


    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getNickname());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
?>
