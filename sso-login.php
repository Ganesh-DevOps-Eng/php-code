<?php

// Fill in your Azure AD (Active Directory) application details
$appid = "fc935d73-7641-400b-a8ad-cc548a8dce42"; // Your Azure AD Application Client ID
$tenantid = "4c1a87da-93b7-4e87-b5ad-da86a9c2ae72"; // Your Azure AD Tenant ID
$secret = "YOUR_CLIENT_SECRET"; // Your Azure AD Application Client Secret (if required)
$redirect_uri = 'https://matelliocorp-eb-env.eba-vwb8qadf.us-east-1.elasticbeanstalk.com/remote/saml/login/'; // Your SAML Assertion Consumer Service URL

$login_url = 'https://login.microsoftonline.com/' . $tenantid . '/saml2';

session_start();

$_SESSION['state'] = session_id();

echo '<h2><p>You can <a href="?action=login">Log In</a> with Microsoft</p></h2>';

if (isset($_GET['action']) && $_GET['action'] == 'login') {
    $params = array(
        'client_id' => $appid,
        'resource' => 'https://matelliocorp-eb-env.eba-vwb8qadf.us-east-1.elasticbeanstalk.com/remote/saml/metadata/',
        'response_type' => 'id_token',
        'response_mode' => 'form_post',
        'scope' => 'openid',
        'nonce' => bin2hex(random_bytes(16)), // Generate a unique nonce value
        'state' => $_SESSION['state'],
        'redirect_uri' => $redirect_uri
    );

    header('Location: ' . $login_url . '?' . http_build_query($params));
}

if (array_key_exists('id_token', $_POST)) {
    // Retrieve the ID token from the POST data
    $id_token = $_POST['id_token'];

    // You can verify and decode the ID token to extract user information here

    // Example: Decode and extract claims
    $decoded_id_token = jwt_decode($id_token);
    $user_name = $decoded_id_token['name'];
    $user_email = $decoded_id_token['email'];

    echo 'Welcome, ' . $user_name . '! Your email is ' . $user_email;
}

// You would typically include a library for decoding JWT tokens.
// For example, you can use a library like Firebase JWT to decode the ID token.
// Make sure to include and configure the JWT decoding library properly.

// Example function for decoding JWT tokens using Firebase JWT (you'll need to include the library):
function jwt_decode($token) {
    require_once 'firebase-jwt/autoload.php'; // Include the library
    $firebase = new \Firebase\JWT\JWT();

    return (array) $firebase->decode($token, YOUR_PUBLIC_KEY, array('RS256'));
}
