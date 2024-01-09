<?php
require 'common_functions.php';
require  '../vendor/autoload.php';
require '../config/config.php';
use League\OAuth2\Client\Provider\Google;

session_start(); // Remove if session.auto_start=1 in php.ini

$provider = new Google([
    'clientId'     => GOOGLE_ID,
    'clientSecret' => GOOGLE_SECRET,
    'redirectUri'  => BASE_URL . 'oauthGoogle.php',
    'verify'       => false
]);

if (!empty($_GET['error'])) {
    // Got an error, probably user denied access
    exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
} elseif (empty($_GET['code'])) {
    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    die();
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    // State is invalid, possible CSRF attack in progress
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a user's profile data
    try {
        // We got an access token, let's now get the owner details
        $ownerDetails = $provider->getResourceOwner($token);

        // Use these details to create a new profile or update an existing one
        $firstName = $ownerDetails->getName();
        $email = $ownerDetails->getEmail();
        $profileImage = $ownerDetails->getAvatar();

        // Check if the user already exists in the database
        $query = "SELECT * FROM Users WHERE email = :email";
        $params = [':email' => $email];
        $stmt = executeQuery($query, $params);

        if ($stmt) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                   // $query_update_user = "UPDATE Users SET name = :name, email = :email, oauth_provider = 'google', profile_image = :profile_image WHERE id = :id";
                    //$params_update_user = [':name' => $firstName, ':email' => $email, ':profile_image' => $profileImage, ':id' => $user['id']];
                    //$stmt_update_user = executeQuery($query_update_user, $params_update_user);
                //if ($stmt) {
                    //$user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                    header("Location: $previousPage?msg=success");
                     exit();

               // }

            } else {
                $query_insert_user = "INSERT INTO Users (name, email, oauth_provider, profile_image) VALUES (:name, :email, 'google', :profile_image)";
                $params_insert_user = [':name' => $firstName, ':email' => $email, ':profile_image' => $profileImage];
                $stmt_insert_user = executeQuery($query_insert_user, $params_insert_user);
                if ($stmt_insert_user) {
                    $query = "SELECT * FROM Users WHERE username = :username";
                    $params = [':username' => $firstName];
                    $stmt = executeQuery($query, $params);

                    if ($stmt) {
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['user_id'] = $user['id'];
                        $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                        header("Location: $previousPage?msg=success");
                        exit();
                    }
                }
            }
        } else {
            exit('Error fetching user details');
        }

    } catch (Exception $e) {
        exit('Something went wrong: ' . $e->getMessage());
    }

    // Use this to interact with an API on the user's behalf
    echo $token->getToken();

    // Use this to get a new access token if the old one expires
    echo $token->getRefreshToken();

    // Unix timestamp at which the access token expires
    echo $token->getExpires();
}
?>
