<?php 

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use rmccue\requests;

use coviu\Api\OAuth2Client;


$endpoint = getenv('COVIU_API_ENDPOINT');
if (!$endpoint) {
  $endpoint = 'https://api.coviu.com/v1';
}

$api_key = getenv('API_KEY');
if (!$api_key) {
  echo("Set API_KEY environment variable.");
  exit();
}

$api_key_secret = getenv('KEY_SECRET');
if (!$api_key_secret) {
  echo("Set KEY_SECRET environment variable.");
  exit();
}

$token_endpoint = $endpoint.'/auth/token';

$client = new OAuth2Client($api_key, $api_key_secret, $token_endpoint);

// Recover an access token
$grant = $client->getAccessToken();

var_dump($grant);


// Refresh an access token before grant->expires_in has expired.
$grant = $client->refreshAccessToken( $grant->refresh_token);

var_dump($grant);
