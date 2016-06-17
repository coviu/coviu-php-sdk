<?php
namespace coviu\Api;

require_once('vendor/autoload.php');
/*
 Authenticator adds the OAuth2 authentication behaviour to a coviu\Api\Request.
 */
class Authenticator {

  private $access_token;
  private $refresh_token;
  private $next_refresh;
  private $client;
  private $clock_func;

  public function __construct($client)
  {
    $this->access_token = NULL;
    $this->refresh_token = NULL;
    $this->next_refresh = NULL;
    $this->client = $client;
    $this->clock_func = 'time';
  }

  public function __invoke()
  {
    if ($this->needsInit())
    {
      $this->init();
    }

    if ($this->needsRefresh())
    {
      $this->refresh();
    }

    return 'Bearer '.$this->access_token;
  }

  public function needsInit()
  {
    return is_null($this->access_token) || is_null($this->refresh_token) || is_null($this->next_refresh);
  }

  public function needsRefresh()
  {
    return $this->clock() > $this->next_refresh;
  }

  public function init()
  {
    $response = $this->client->getAccessToken()->run();
    self::validate_oauth2_response($response);
    $grant = $response['body'];
    $this->setupGrant($grant);
  }

  public function setupGrant($grant)
  {
    $this->access_token = $grant['access_token'];
    $this->refresh_token = $grant['refresh_token'];
    $this->next_refresh = $this->clock() + ($grant['expires_in'] / 2);
  }

  public function refresh()
  {
    $response = $this->client->refreshAccessToken($this->refresh_token)->run();
    self::validate_oauth2_response($response);
    $grant = $response['body'];
    $this->setupGrant($grant);
  }

  public function setClock($f)
  {
    $this->clock_func = $f;
  }

  public function clock()
  {
    $f = $this->clock_func;
    return $f();
  }

  public static function validate_oauth2_response($response)
  {
    if (!$response['ok'])
    {
      throw new OAuth2ClientException($response);
    }
  }
}
