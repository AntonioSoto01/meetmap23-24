<?php
require 'common_functions.php';
require '../vendor/autoload.php';
require '../config/config.php';
use League\OAuth2\Client\Provider\Github;


$provider = new Github([
    'clientId' => GITHUB_ID,
    'clientSecret' => GITHUB_SECRET,
    'redirectUri' => BASE_URL . 'oauthGithub.php',
]);
$options = [
    'scope' => ['user', 'user:email'] // array or string; at least 'user:email' is required
];


if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl($options);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
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


    // Optional: Now you have a token you can look up a user's profile data
    try {
        // We got an access token, let's now get the owner details
        $ownerDetails = $provider->getResourceOwner($token);

        // Use these details to create a new profile or update an existing one
        $username = $ownerDetails->getNickname();
        $firstName = $ownerDetails->getName();
        //$email = $ownerDetails->getEmail();
        $email = getUserPrimaryEmail($provider, $token);
        $userDetails = $ownerDetails->toArray();
        $profileImage = $userDetails['avatar_url'];

        // Check if the user already exists in the database
        $query = "SELECT * FROM Users WHERE email = :email";
        $params = [':email' => $email];
        $stmt = executeQuery($query, $params);

        if ($stmt) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if ($user['oauth_provider'] != null && $user['oauth_provider'] != 'github') {
                    echo "<script>alert('Please login with your registered provider.')</script>";
                    $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                    header("Location: $previousPage?msg=fail");
                    exit();

                } else {
                    $_SESSION['user_id'] = $user['id'];
                    if ($user['oauth_provider'] !='github') {

                        $query_update_user = "UPDATE Users SET name = :name, oauth_provider = 'github', profile_image = :profile_image, pw = NULL WHERE id = :id";
                        $params_update_user = [':name' => $firstName,  ':profile_image' => $profileImage, ':id' => $user['id']];
                        $stmt_update_user = executeQuery($query_update_user, $params_update_user);

                        if ($stmt_update_user) {
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                            header("Location: $previousPage");
                            exit();

                        }else{print_r($stmt_update_user);}

                    }else{
                    $previousPage = $_SESSION['previous_page'] ?? 'index.php';
                    header("Location: $previousPage?msg=success");
                    exit();
                }}
            } else {
                $query_insert_user = "INSERT INTO Users (username, email, oauth_provider, profile_image) VALUES (:username, :email, 'github', :profile_image)";
                $params_insert_user = [':username' => $username, ':email' => $email, ':profile_image' => $profileImage];
                $stmt_insert_user = executeQuery($query_insert_user, $params_insert_user);
                if ($stmt_insert_user) {
                    $query = "SELECT * FROM Users WHERE username = :username";
                    $params = [':username' => $username];
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


}
function getUserPrimaryEmail($provider, $accessToken)
{
    $url = 'https://api.github.com/user/emails';
    try {
        $request = $provider->getAuthenticatedRequest(
            'GET',
            $url,
            $accessToken
        );

        $response = $provider->getResponse($request);
        $emails = json_decode($response->getBody(), true);

        // Find the primary email
        foreach ($emails as $email) {
            if ($email['primary'] === true) {
                return $email['email'];
            }
        }

        // Return null if no primary email found
        return null;
    } catch (\Exception $e) {
        // Handle exception or error in fetching user emails
        return null;
    }

}
?>