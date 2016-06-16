<?php

namespace coviu\Api;

use PHPUnit_Framework_TestCase;

class OAuth2ClientTest extends PHPUnit_Framework_TestCase
{
  public function testTheClientCanBeConstructed()
  {
    $key = 'key';
    $secret = 'secret';
    $endpoint = 'endpoint';
    $client = new OAuth2Client($key, $secret, $endpoint);
    $this->assertTrue($client->getApiKey() == $key);
    $this->assertTrue($client->getKeySecret() == $secret);
    $this->assertTrue($client->getEndpoint() == $endpoint);
  }
}
