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

namespace coviu\Api;

require_once('vendor/autoload.php');

use rmccue\requests;

class OAuth2Client
{

    /** @var string */
    private $api_key;

    /** @var string */
    private $api_key_secret;

    /** @var string */
    private $token_endpoint;

    public function __construct($api_key, $api_key_secret, $token_endpoint)
    {
        $this->api_key = $api_key;
        $this->api_key_secret = $api_key_secret;
        $this->token_endpoint = $token_endpoint;
    }

    public function getAccessToken()
    {
      $data = array('grant_type' => 'client_credentials');

      // Use the api_key and api_key_secret to get an access token and refresh token for the api client.
      $response = self::sendPostRequest( $data );

      return json_decode($response->body);
    }

    public function refreshAccessToken( $refresh_token )
    {
      $data = array('grant_type' => 'refresh_token', 'refresh_token' => $refresh_token);

      // Use the api_key and api_key_secret along with a previous refresh token to refresh an
      // access token, returning a new grant with access token and refresh token.
      $response = self::sendPostRequest( $data );

      return json_decode($response->body);
    }

    /**
     * Create a Basic Authorization header using the api key & secret
     *
     * @return array
     */
    private function buildAuthHeader()
    {
      // Construct the HTTP Basic Auth header.
      return ( array('Authorization' => 'Basic '.base64_encode($this->api_key.':'.$this->api_key_secret)) );
    }

    /**
     * Send a HTTP post request and retrieve the response
     *
     * @param array      $data       Array of HTTP headers
     *
     * @return array
     */
    private function sendPostRequest( $data )
    {
      $auth_header = self::buildAuthHeader();
      $header = array();
      $header = array_merge( $header, $auth_header );

      $response = \Requests::post( $this->token_endpoint, $header, $data );

      return $response;
    }


    public function getApiKey()
    {
      return $this->api_key;
    }

    public function getKeySecret()
    {
      return $this->api_key_secret;
    }

    public function getEndpoint()
    {
      return $this->token_endpoint;
    }
}
