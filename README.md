coviu-php-sdk - Coviu api php client library
============================================


Coviu provides a session based API for creating and restricting access to coviu calls. The core concepts exposed are

* Session: A coviu call that occurs between two or more parties at a specified time, and has a finite duration.
* Participants: Users who may participate in a coviu call.

Participants join a call by following a _session link_ in their browser, or mobile app. The _session link_
identifies the participant, including their name, optional avatar, and importantly their _role_. As such,
it is important that each person joining the call be issued a different _session link_, i.e. have a distinct
_participant_ created for them. A participant's _role_ identifies whether that user may access the call directly,
or if they are required the be _let in_ by an existing participant.

coviu-php-sdk exposes this functionality through a convenient php library.


### Installation

```bash
composer require coviu/Api
```



TODO: UPDATE below here

### Quickstart

Setup the sdk by passing in your api key and key secret

```javascript
var sdk = require('coviu-js-sdk');

var apiKey = 'my_api_key_from_coviu.com';
var keySecret = 'my_api_key_secret';

var coviu = sdk(apiKey, keySecret);
```

Schedule a session for the future.

```javascript

var session =  {
  session_name: "A test session with Dr. Who",
  start_time: 'Wed, 08 Jun 2016 13:34:00 GMT',
  end_time: 'Wed, 08 Jun 2016 13:44:00 GMT',
  picture: 'http://www.fillmurray.com/200/300',
  participants: []
};

coviu.sessions.createSession(session).run().then(console.log);
```

Example output
```javascript
{
  team_id: '936c863f-ccff-4775-9011-cd17f4b5ad75',
  client_id: '07c0fdbd-9089-4943-aa0b-2b01754f42e7',
  participants: [],
  session_id: '09ef6778-3714-4dd6-91ec-d2868365c4ef',
  session_name: 'A test session with Dr. Who',
  start_time: 'Wed, 08 Jun 2016 13:34:00 GMT',
  end_time: 'Wed, 08 Jun 2016 13:44:00 GMT',
  picture: 'http://www.fillmurray.com/200/300'
}
```

`coviu.sessions.*` is a collection of functions that build requests that can be run against the api. In order to run the
request, the `.run()` method must be called, which returns a promise of the result.

It's important to notice that the string format for start_time and end_time is RFC-1123, which specifies the UTC timezone.

You can now add a participant to the session

```javascript
var host = {
  display_name: "Dr. Who",
  role: "host", // or "guest"
  picture: "http://fillmurray.com/200/300",
  state: "test-state"
};
var sessionId = '09ef6778-3714-4dd6-91ec-d2868365c4ef';
api.sessions.addParticipant(sessionId, host).run().then(console.log);
```

Example output
```javascript
{
  client_id: '07c0fdbd-9089-4943-aa0b-2b01754f42e7',
  display_name: 'Dr. Who',
  entry_url: 'https://coviu.com/session/e3c40e88-2b19-49bd-b687-1c08e4e0e124',
  participant_id: 'e3c40e88-2b19-49bd-b687-1c08e4e0e124',
  picture: 'http://fillmurray.com/200/300',
  role: 'HOST',
  session_id: '09ef6778-3714-4dd6-91ec-d2868365c4ef',
  state: 'test-state'
}
```

Notice the `entry_url` for the newly created participant. Following this url in a browser or in one of the coviu mobile
between `start_time` and `end_time` (while the session is active), will join the participant into the session, assuming
the role and identity provided.


We can now read the entire session structure back
```javascript
api.sessions.getSession('09ef6778-3714-4dd6-91ec-d2868365c4ef').run().then(console.log).catch(console.error);
```

Example output
```javascript
{
  team_id: '936c863f-ccff-4775-9011-cd17f4b5ad75',
  client_id: '07c0fdbd-9089-4943-aa0b-2b01754f42e7',
  session_id: '09ef6778-3714-4dd6-91ec-d2868365c4ef',
  session_name: 'A test session with Dr. Who',
  start_time: 'Wed, 08 Jun 2016 13:35:44 GMT',
  end_time: 'Wed, 08 Jun 2016 13:45:44 GMT',
  picture: 'http://www.fillmurray.com/200/300',
  participants:[{
    client_id: '07c0fdbd-9089-4943-aa0b-2b01754f42e7',
    display_name: 'Dr. Who',
    entry_url: 'https://coviu.com/session/e3c40e88-2b19-49bd-b687-1c08e4e0e124',
    participant_id: 'e3c40e88-2b19-49bd-b687-1c08e4e0e124',
    picture: 'http://fillmurray.com/200/300',
    role: 'HOST',
    session_id: '09ef6778-3714-4dd6-91ec-d2868365c4ef',
    state: 'test-state'
  }]
}
```

There's a full set of api documents provided with api source for the `coviu-sdk-api` npm module at
https://github.com/coviu/coviu-sdk-api/blob/master/libs/sessions.js
