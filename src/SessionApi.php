<?php

namespace coviu\Api;


class SessionApi
{
  private $get;
  private $post;
  private $put;
  private $del;

  public function __construct($service)
  {
    $this->get = $service->get();
    $this->post = $service->json()->post();
    $this->put = $service->json()->put();
    $this->del = $service->delete();
  }

  public function createSession ($session)
  {
      return $this->post->path('/sessions')->body($session);
  }

  public function getSession ($sessionId)
  {
    return $this->get->path('/sessions/')->subpath($sessionId);
  }

  public function getSessions($query)
  {
    return $this->get->path('/sessions')->query($query);
  }

  public function updateSession($sessionId, $update)
  {
    return $this->put->path('/sessions/')->subpath($sessionId)->body($update);
  }

  public function deleteSession($sessionId)
  {
    return $this->del->path('/sessions/')->subpath($sessionId);
  }

  public function getSessionParticipants($sessionId)
  {
    return $This->get->path('/sessions/')->subpath($sessionId)->subpath('/participants');
  }

  public function addParticipant ($sessionId, $participant)
  {
    return $this->post->path('/sessions/')->subpath($sessionId)->subpath('/participants')->body($participant);
  }

  public function getParticipant ($participantId)
  {
    return $this->get->path('/participants/')->subpath($participantId);
  }

  public function updateParticipant($participantId, $update)
  {
    return $this->put->path('/participants/')->subpath($participantId)->body($update);
  }

  public function deleteParticipant($participantId)
  {
    return $this->del->path('/participants/')->subpath($participantId);
  }
}
