<?php
require_once 'vendor/autoload.php'; // Include the OneLogin toolkit

$azureADSettings = array(
    'strict' => true,
    'sp' => array(
        'entityId' => 'your-sp-entity-id', // Replace with your Service Provider Entity ID
        'assertionConsumerService' => array(
            'url' => 'https://your-app-url/sso-login.php', // Replace with your application's SSO callback URL
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ),
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
        'x509cert' => '', // Your SP x509 certificate (leave empty if not used)
        'privateKey' => '', // Your SP private key (leave empty if not used)
    ),
    'idp' => array(
        'entityId' => 'https://sts.windows.net/4c1a87da-93b7-4e87-b5ad-da86a9c2ae72/',
        'singleSignOnService' => array(
            'url' => 'https://login.microsoftonline.com/4c1a87da-93b7-4e87-b5ad-da86a9c2ae72/saml2',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ),
        'x509cert' => '', // IdP x509 certificate (leave empty if not used)
    ),
);

$samlAuth = new OneLogin_Saml2_Auth($azureADSettings);

if (!$samlAuth->isAuthenticated()) {
    // Redirect the user to the IdP for authentication
    $samlAuth->login();
} else {
    // User is authenticated, you can access user information with $samlAuth->getAttributes()
    $username = $samlAuth->getAttributes()['NameID'][0];
    // Store the user's information or perform further actions
    // Redirect the user to your application's home page or other appropriate page
    header('Location: /your-home-page.php');
}