<!--
  Title: Laravel Recaptcha v2
  Description: Laravel package for recaptcha v2.
  Author: ryandeng
  -->
  
  <meta name='keywords' content='recaptcha v2,laravel recaptcha v2,laravel google recaptcha v2,google recaptcha v2,laravel recaptcha'>

# Laravel Package for Google reCAPTCHA v2

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Coverage Status][ico-coverage]][link-coverage]
[![Build][ico-build]][link-build]
[![StyleCI][ico-styleci]][link-styleci]
[![Latest Unstable Version][ico-unstable]][link-unstable]

I will be super happy if you think this package is good and also star me.  ^.^

PS: The version "~3.*" contains vue component which is unstable and incomplete right now, feel free to install it if you really want to use vue. It will be released soon.

# DEMO

## Invisible

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/881545398213_.pic.jpg" width="250" height="300" />

## Inline

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/891545398531_.pic.jpg" width="250" height="300" />

## Corner

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/901545398593_.pic.jpg" width="150" height="100" />

## Description

Google reCAPTCHA v2 is a new mechanism to verify whether the user is bot or not.

reCAPTCHA v2 is intended for power users, site owners that want more data about their traffic, and for use cases in which it is not appropriate to show a challenge to the user.

For example, a registration page might still use reCAPTCHA v2 for a higher-friction challenge, whereas more common actions like sign-in, searches, comments, or voting might use reCAPTCHA v2.

Please check Google site: https://developers.google.com/recaptcha/docs/faq

## Features

- Score Comparision
- Support invisible, global and inline badge style
- Support multiple reCAPTCHA the same page for different forms
- Support multiple actions to be placed on the same page
- Support custom implementation on config interface
- Support custom implementation on request method interface 


## Requirement

This package requires the following dependencies:

- Laravel 5.x 

- If you want to use Validation Class your Laravel version needs to be >= 5.5

- php > 5

- Please ensure that you have read basic information from Google reCAPTCHA v2.

## Installation


Via Composer

``` sh
        $ composer require timehunter/laravel-google-recaptcha-v2 "~2.0.0"
```

If your Laravel framework version <= 5.4, please register the service provider in your config file: /config/app.php, otherwise please skip it.


``` php
'providers'=[
    ....,
    TimeHunter\LaravelGoogleCaptchav2\Providers\GoogleReCaptchav2ServiceProvider::class
]
```

And also
``` php
'aliases'=[
     ....,
     'GoogleReCaptchav2'=> TimeHunter\LaravelGoogleCaptchav2\Facades\GoogleReCaptchav2::class
 ]
```


If your Laravel framework version is >= 5.5, just run the following command to publish views and config.
```sh 
$ php artisan vendor:publish --provider="TimeHunter\LaravelGoogleCaptchav2\Providers\GoogleReCaptchav2ServiceProvider"
```

After installation, you should see a googlerecaptchav2/field.blade and header.blade file in your views folder and googlerecaptchav2.php in your app/config folder.

## Basic Usage
#### Setting up your Google reCAPTCHA details in config file

Please register all details on host_name, site_key, secret_key and site_verify_url.

Specify your Score threshold and action in 'setting', e.g.
``` php
      'setting' =  [
          [
            'action' => 'contact_us', // Google reCAPTCHA required paramater
            'threshold' => 0.2, // score threshold
            'is_enabled' => false // if this is true, the system will do score comparsion against your threshold for the action
            ]
        ]
```        
Note: if you want to enable Score Comparision, you also need to enable is_score_enabled to be true.
``` php
'is_score_enabled' = true
```   

For score comparision, all actions should be registered in googlerecaptchav2 config file under 'setting' section. 

For more details please check comments in config file.

#### Display reCAPTCHA v2

##### Blade
Include div with an ID inside your form, e.g.

``` html  
 <div id="contact_us_id"></div>
```

Include Template script in your bottom/header of your page, params should follow 'ID'=>'Action', e.g.

``` PHP  
 {!!  GoogleReCaptchav2::render(
            [
                'contact_us_id'=>'contact_us',  // the div id=contact_us_id maps to action name contact_us
                'signin_id'=>'registration',  // the div id=signin_id maps to action name registration
                'register_id'=>'registration'   // the div id=register_id maps to action name registration
            ]) !!}
```

##### Example Usage

``` html  
<form method="POST" action="/verify">
    @csrf
    <div id="contact_us_id"></div>
    <input type="submit" value="submit">
    <div>
        <small>
            This site is protected by reCAPTCHA and the Google
            <a href="https://policies.google.com/privacy">Privacy Policy</a> and
            <a href="https://policies.google.com/terms">Terms of Service</a> apply.
        </small>
    </div>
</form>

{!!  GoogleReCaptchav2::render([
               'contact_us_id'=>'contact_us'
           ]) !!}

```

The backend request will receive a value for 'g-recaptcha-response', please take a look at Sample Use Case and Facade usage sections.

## Badge Display

Inline

1. Go to config file, and set 
``` PHP
    [
        ...
        'inline' => true
        ...
    ]
```
2. Badge will be displayed as inline format within the form.


Invisible

1. Set inline as true as well
2. Modify your div with style display:none
3. Refer to Google official site: https://developers.google.com/recaptcha/docs/faq
, you need to include the following text:
 ``` HTML
    This site is protected by reCAPTCHA and the Google
        <a href="https://policies.google.com/privacy">Privacy Policy</a> and
        <a href="https://policies.google.com/terms">Terms of Service</a> apply.
 ```

Corner

1. Set inline as false
2. Your badge will be shown in the bottom right side.

Custom

1. Set inline as true
2. Do Styling/CSS on its div element


## Validation Class (Only support Laravel >= 5.5)
   
   You can use provided Validation object to verify your reCAPTCHA.
      
``` php
   use TimeHunter\LaravelGoogleCaptchav2\Validations\GoogleReCaptchaValidationRule
   $rule = [
            'g-recaptcha-response' => [new GoogleReCaptchaValidationRule('action_name')]
        ];
```

   -  $actionName: if its NULL, the package won't verify action with google response.
  
## Facade Usage

You can also directly use registered service by calling the following method.
- setAction() is optional only if you want to verify if the action is matched.
- verifyResponse() which accepts the token value from your form. This return Google reCAPTCHA Response object.

``` php
   GoogleReCaptchav2::setAction($action)->verifyResponse($value);
```

Example Usage

``` php
   GoogleReCaptchav2::verifyResponse($value,$ip)->getMessage();
   GoogleReCaptchav2::verifyResponse($value)->isSuccess();
   GoogleReCaptchav2::verifyResponse($value)->toArray();
   GoogleReCaptchav2::setAction($action)->verifyResponse($value)->isSuccess();
```

``` php
   GoogleReCaptchav2::verifyResponse($request->input('g-recaptcha-response'))->getMessage()
```

## Sample Use Case

Register your action in config, also enable score and set up your own site key and secret key:
``` php
    'setting' => [
        [
            'action' => 'contact_us',
            'threshold' => 2,
            'score_comparision' => true
        ],
        [
            'action' => 'signup',
            'threshold' => 0.2,
            'score_comparision' => true
        ],
    ]
```

Register two routes in web.php
``` php
Route::get('/index', 'ReCaptchaController@index');
Route::post('/verify', 'ReCaptchaController@verify');
```

Create two functions in controller:
``` php
    public function verify(Request $request)
    {
        dd(GoogleReCaptchav2::verifyResponse($request->input('g-recaptcha-response'))->getMessage());
    }
    public function index(Request $request)
    {
        return view('index');    
   }
```

Create your form in index.blade.php:
``` html
<form method="POST" action="/verify">
    @csrf
    <div id="contact_us_id"></div>
    <input type="submit" value="submit">
</form>


<form method="POST" action="/verify">
    @csrf
    <div id="signup_id"></div>
    <input type="submit" value="submit">
</form>

{!!  GoogleReCaptchav2::render(['contact_us_id'=>'contact_us', 'signup_id'=>'signup']) !!}
```

Go to /index and click submit button on contact us form and you should see an error message that 'Score does not meet the treshhold' because the threshold >2. You can play around the controller to see all outcomes. Importantly, you need to wait the script to load and render the token before clicking the submit button.

## Advanced Usage

#### Custom implementation on Config
    
For some users, they might store the config details in their own storage e.g database. You can create your own class and implement:

```
TimeHunter\LaravelGoogleCaptchav2\Interfaces\ReCaptchaConfigv2Interface
```

Remember to register it in your own service provider

``` php
     $this->app->bind(
                ReCaptchaConfigv2Interface::class,
                YourOwnCustomImplementation::class
            );
```

#### Custom implementation on Request method

The package has two default options to verify: Guzzle and Curl, if you want to use your own request method, You can create your own class and implement 
```
TimeHunter\LaravelGoogleCaptchav2\Interfaces\RequestClientInterface
```

Remember to register it in your own service provider
``` php
     $this->app->bind(
                RequestClientInterface::class,
                YourOwnCustomImplementation::class
            );
```


## Security

If you discover any security related issues, please email ryandadeng@gmail.com instead of using the issue tracker.


## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://poser.pugx.org/timehunter/laravel-google-recaptcha-v2/version
[ico-downloads]: https://poser.pugx.org/timehunter/laravel-google-recaptcha-v2/downloads
[ico-coverage]: https://coveralls.io/repos/github/RyanDaDeng/laravel-google-recaptcha-v2/badge.svg?branch=master&service=github
[ico-build]: https://travis-ci.org/RyanDaDeng/laravel-google-recaptcha-v2.svg?branch=master
[ico-styleci]: https://github.styleci.io/repos/146857583/shield
[ico-unstable]: https://poser.pugx.org/timehunter/laravel-google-recaptcha-v2/v/unstable

[link-packagist]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v2
[link-downloads]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v2
[link-author]: https://github.com/ryandadeng
[link-coverage]: https://coveralls.io/github/RyanDaDeng/laravel-google-recaptcha-v2?branch=master
[link-build]: https://travis-ci.org/RyanDaDeng/laravel-google-recaptcha-v2
[link-styleci]: https://github.styleci.io/repos/163373553
[link-unstable]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v2

