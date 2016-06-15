<?php
/*
  Copyright 2015  Silvia Pfeiffer  (email : silviapfeiffer1@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// authentication helper routines for JWT and oauth2 with the Coviu API

require_once('vendor/autoload.php');

namespace coviu;


function build_oauth2_auth_header( $access_token ) {
  // Construct the OAuth2 bearer token authorization header from an access token.
  return ( array('Authorization' => 'Bearer '.$access_token) );
}

function create_subscription( $access_token, $api_root, $body ) {
  global $endpoint;

  $data = $body;

  // Create a new subscription for a user.
  // We need to create a subscription before we sign a session jwt for the user,
  // otherwise coviu will rudely deny access to the session.
  $auth_header = build_oauth2_auth_header( $access_token );
  $header = array('Content-Type' => 'application/json');
  $header = array_merge( $header, $auth_header );

  // POST /v1/orgs/<org id>/subscriptions/
  $url = $endpoint.$api_root->_links->subscriptions->href;

  $response = Requests::post( $url, $header, json_encode($data) );

  return json_decode($response->body);
}

function get_subscriptions( $access_token, $api_root) {
  global $endpoint;

  // Get the first page of subscriptions, leaving the API to choose how many to return.
  $auth_header = build_oauth2_auth_header( $access_token );
  $header = array();
  $header = array_merge( $header, $auth_header );

  // GET /v1/orgs/<org id>/subscriptions/
  $url = $endpoint.$api_root->_links->subscriptions->href;

  $response = Requests::get( $url, $header );

  return json_decode($response->body);
}

function get_subscription_by_ref( $access_token, $api_root, $ref) {
  $subscriptions = get_subscriptions( $access_token, $api_root );

  for ($i=0, $c=count($subscriptions->content); $i<$c; $i++) {
    if ( $ref == $subscriptions->content[$i]->content->remoteRef ) {
      return $subscriptions->content[$i];
    }
  }
  return null;
}

function get_sessions( $access_token, $api_root) {
  global $endpoint;

  // Get the first page of sessions, leaving the API to choose how many to return.
  $auth_header = build_oauth2_auth_header( $access_token );
  $header = array();
  $header = array_merge( $header, $auth_header );

  // GET /v1/orgs/<org id>/sessions/
  $url = $endpoint.$api_root->_links->sessions->href;

  $response = Requests::get( $url, $header );

  return json_decode($response->body);
}

function get_link( $access_token, $page ) {
  global $endpoint;

  // Get a resource identified by HAL link object.
  $auth_header = build_oauth2_auth_header( $access_token );
  $header = array();
  $header = array_merge( $header, $auth_header );

  $url = $endpoint.$page->href;

  $response = Requests::get( $url, $header );

  return json_decode($response->body);
}

function delete_subscription( $access_token, $subscription) {
  global $endpoint;

  // Delete a previously created subscription.
  $auth_header = build_oauth2_auth_header( $access_token );
  $header = array();
  $header = array_merge( $header, $auth_header );

  $url = $endpoint.$subscription->_links->self->href;

  $response = Requests::delete( $url, $header );

  return json_decode($response->body);
}

function delete_subscription_by_id( $access_token, $api_root, $subscriptionId ) {
  global $endpoint;

  // Delete a previously created subscription.
  $auth_header = build_oauth2_auth_header( $access_token );
  $header = array();
  $header = array_merge( $header, $auth_header );

  // DELETE /v1/orgs/<org id>/subscriptions/<subscriptionId>
  $url = $endpoint.$api_root->_links->subscriptions->href.'/'.$subscriptionId;

  $response = Requests::delete( $url, $header );

  return json_decode($response->body);
}

// TESTS BELOW HERE
$endpoint = getenv('API_ENDPOINT');
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



