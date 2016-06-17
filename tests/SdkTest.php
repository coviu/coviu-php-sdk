<?php

namespace coviu\Api;

use PHPUnit_Framework_TestCase;

class SdkTest extends PHPUnit_Framework_TestCase
{
  private static $endpoint = 'https://api-staging.covi.io/v1';
  private static $api_key = '7a552998-0da1-4dcf-b15d-824c0c93c788';
  private static $key_secret = '769a75fb2bb4e0b09cde';
  private $sdk;

  public static function exampleSession()
  {
    return [
      'start_time' => (new \DateTime())->modify('+10 seconds')->format(\DateTime::ISO8601),
      'end_time' => (new \DateTime())->modify('+1 hour')->format(\DateTime::ISO8601),
      'session_name' => 'example session',
      'picture' => 'http://www.fillmurray.com/200/300'
    ];
  }

  public static function exampleHost()
  {
    return [
      'display_name' => 'Dr. Who',
      'role' => 'host',
      'picture'=> 'http://fillmurray.com/200/300',
      'state'=> 'test-state'
    ];
  }
  public static function exampleHow()
  {
    return [
      'display_name' => 'Dr. Who',
      'role'=> 'guest',
      'picture'=> 'http://fillmurray.com/200/300',
      'state'=> 'test-state'
    ];
  }

  protected function setUp()
  {
    $this->coviu = new Coviu(self::$api_key, self::$key_secret, self::$endpoint);
  }

  public function testGetSessions()
  {
    $sessions = $this->coviu->sessions->getSessions([]);
    $this->assertTrue(is_array($sessions['content']));
    $this->assertTrue(is_int($sessions['page_size']));
    $this->assertTrue(is_int($sessions['page']));
    $this->assertTrue(is_bool($sessions['more']));
  }
  //
  // it('can create a session', function(){
  //   // Set the session start time 10 seconds into the future.
  //   var example = helpers.exampleSession(10000);
  //   return coviu.sessions.createSession(example).run().then(function(result){
  //     assert(result);
  //     assert(result.team_id);
  //     assert(result.client_id);
  //     assert(result.session_id);
  //     session = result
  //   });
  // });
  //
  public function testCanCreateASession()
  {
    var_dump(self::exampleSession());
    // $session = $this->coviu->sessions->createSession(self::exampleSession());
    // var_dump($session);
  }
  // it('can add a host participant to a session', function(){
  //   var example = helpers.exampleHost();
  //   return coviu.sessions.addParticipant(session.session_id, example).run().then(function(result){
  //     assert(result);
  //     assert(result.participant_id);
  //     assert(result.entry_url);
  //     assert(result.role === 'HOST');
  //     host = result;
  //   });
  // });
  //
  // it('can add a guest participant to the session', function(){
  //   var example = helpers.exampleGuest();
  //   return coviu.sessions.addParticipant(session.session_id, example).run().then(function(result){
  //     assert(result);
  //     assert(result.participant_id);
  //     assert(result.entry_url);
  //     assert(result.role === 'GUEST');
  //     guest = result;
  //   });
  // });
  //
  // it('can get a session by id', function(){
  //   return coviu.sessions.getSession(session.session_id).run().then(function(result){
  //     assert(result.session_id === session.session_id);
  //     assert(result.participants.length === 2);
  //     assert(result.participants.filter(function(p){return p.role === 'HOST'}).length === 1);
  //     assert(result.participants.filter(function(p){return p.role === 'GUEST'}).length === 1);
  //   });
  // });
  //
  // it('can update a participant to e.g. set a guest to a host', function(){
  //   var update = {role: 'HOST', display_name: 'New Display Name'};
  //   return coviu.sessions.updateParticipant(guest.participant_id, update).run().then(function(result) {
  //     assert(result);
  //     assert(result.role === update.role);
  //     assert(result.display_name === update.display_name);
  //   });
  // });
  //
  // it('can update a session\s name, start, and end time, and picture', function(){
  //   var update = {
  //     start_time: helpers.relativeNow(10*60*60*1000).toUTCString(),
  //     end_time: helpers.relativeNow(20*60*60*1000).toUTCString(),
  //     display_name: 'example',
  //     picture: 'example'
  //   };
  //   return coviu.sessions.updateSession(session.session_id, update).run().then(function(result) {
  //     assert(result);
  //     assert(result.start_time === update.start_time);
  //     assert(result.end_time === update.end_time);
  //     assert(result.participants.filter(function(p){return p.role === 'HOST'}).length === 2);
  //   });
  // });
  //
  // it('can get just the participants for a session', function(){
  //   return coviu.sessions.getSessionParticipants(session.session_id).run().then(function(result) {
  //     assert(result);
  //     assert(result.length === 2);
  //   });
  // });
  //
  // it('can get a single participant by id', function(){
  //   return coviu.sessions.getParticipant(host.participant_id).run().then(function(result) {
  //     assert(result.participant_id === host.participant_id);
  //     assert(result.session_id === session.session_id);
  //   });
  // });
  //
  // it('can remove a participant from a session', function(){
  //   return coviu.sessions.deleteParticipant(guest.participant_id).run().then(function(){
  //     return coviu.sessions.getSession(session.session_id).run().then(function(session){
  //       assert(session.participants.length === 1);
  //     });
  //   })
  // });
  //
  // it('can cancel a session', function(){
  //   return coviu.sessions.deleteSession(session.session_id).run().then(function(){
  //     return helpers.expectFailure(coviu.sessions.getSession(session.session_id).run());
  //   })
  // });
}
