<?php

namespace coviu\Api;

use PHPUnit_Framework_TestCase;

class OAuth2ClientTest extends PHPUnit_Framework_TestCase
{
  private static $endpoint = 'https://api-staging.covi.io/v1';
  private static $api_key = '7a552998-0da1-4dcf-b15d-824c0c93c788';
  private static $key_secret = '769a75fb2bb4e0b09cde';

  public function testGetGetAnAccessToken()
  {
    $client = new OAuth2Client(self::$api_key, self::$key_secret, Request::request(self::$endpoint));
    $res = $client->getAccessToken()->run();
    $this->assertTrue(isset($res['body']['access_token']));
    $this->assertTrue(isset($res['body']['refresh_token']));
    $this->assertTrue(isset($res['body']['expires_in']));
  }

  public function testGetGetAnAccessToken()
  {
    $client = new OAuth2Client(self::$api_key, self::$key_secret, Request::request(self::$endpoint));
    $res = $client->getAccessToken()->run();
    $this->assertTrue(isset($res['body']['access_token']));
    $this->assertTrue(isset($res['body']['refresh_token']));
    $this->assertTrue(isset($res['body']['expires_in']));
    $res = $client->refreshAccessToken($res['body']['refresh_token'])->run();
    $this->assertTrue(isset($res['body']['access_token']));
    $this->assertTrue(isset($res['body']['refresh_token']));
    $this->assertTrue(isset($res['body']['expires_in']));
  }
}
