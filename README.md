## OpenTok for Laravel
--------------------------------------

This is a laravel4 wrapper library forthe [OpenTok](http://tokbox.com/opentok/) SDK. OpenTok is a product by TokBox which utilizes WebRTC to enable peer to peer video, audio and messaging.

Please note: this repository is in *NO WAY* associated with TokBox.

## Composer Require
Currently only dev-master but is only a wrapper really...

    "tomcorbett/opentok-laravel": "dev-master"

### Publishing The Configuration
Publish the configurations for this package in order to change them to your liking:

    php artisan config:publish tomcorbett/opentok-laravel

### Setting up your Configuration
Get your api\_key and api\_secret from your OpenTok account and replace the placeholders in your config file:

  ```php
    return array( 
      /**
      * put your API key in here
      */
      'api_key' => 'API_KEY',

      /**
      * put your API secret in here
      */	
      'api_secret' => 'API_SECRET',
    );
  ```

### Before you dive in...

Although it's very tempting yo dive straight in, to avoid frustration, I would highly reccomend that you take a look at the [Intro to OpenTok](http://tokbox.com/opentok/intro/) and also click around the site and read their docs. My documentation is *terrible* and only intended to make it easier to use for laravel developers and in no way is it a replacement for the OpenTok documentation (which is really good).

It's definitely a good idea to get to grips with the general flow, the technologies used and also their definitions e.g. session, publisher, subscriber, token etc.

### General Usage

First you need to create a session so your subscribers and/or publishers have something to assiciate with
```php
// new session
$session    = OpentokApi::createSession();            
$sessionId  = $session->getSessionId();

// check if it's been created or not (could have failed)
if (empty($sessionId)) {
    throw new \Exception("An open tok session could not be created");
}
```

Now we need to create a token for your publisher to use so they can actually publish
Please note that you will need to API key on the client side to use in the JS so something like this would be fine:
(saves you hardcoding in your JS file or template)
```php
// use the necessary files
use Tomcorbett\OpentokLaravel\Facades\OpentokApi;
use OpenTokException;

// get your API key from config
$api_key = Config::get('opentok-laravel::api_key');
        
// then create a token (session created in previous step)
try {
    // note we're create a publisher token here, for subscriber tokens we would specify.. yep 'subscriber' instead
    $token = OpentokApi::generateToken($sessionId,
        array(
            'role' => Role::PUBLISHER
        )
    );
} catch(OpenTokException $e) {
    // do something here for failure
}

// pass these to your view where you're broadcasting from as you'll need them...
return View::make('your/view')
    ->with('session_id', $sessionId)
    ->with('api_key', $api_key)
    ->with('token', $token)
```

For the JS/HTML etc. for publishing video/audio/messages please see the OpenTok [Quick Start Guide](http://tokbox.com/opentok/quick-start/) and [Documentation](http://tokbox.com/opentok/libraries/client/js/) and take a browse around their How To examples etc. they're pretty good!

Hopefully you will find this library useful, if so please feel free to let me know, and feel free to drop any comments, questions or suggestions to improve!
