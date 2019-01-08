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


Welcome all tickets (features/questions/bugs/improvements), I will respond to all tickets within 48 hours.

This is a package for Google reCAPTCHA v2.

If you want to use v3, please go to: https://github.com/RyanDaDeng/laravel-google-recaptcha-v3

# DEMO

## Checkbox

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/0DB7E6BA-15ED-45E7-AA12-3CEA05E1483E.png" width="250" height="300" />

## Invisible - hidden

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/881545398213_.pic.jpg" width="250" height="300" />

## Invisible - Inline

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/891545398531_.pic.jpg" width="250" height="300" />

## Corner

<img src="https://github.com/RyanDaDeng/aws-study-notes/blob/master/901545398593_.pic.jpg" width="150" height="100" />

## Description

A Laravel package for Google reCAPTCHA v2.

If you want to make your own font-end template, you have full access to modify template file, so you can customise your own template by reading through Google official guide for either invisible badge or inline checkbox. https://developers.google.com/recaptcha/docs/display

## Features

- Support invisible, corner and inline badge style
- Support multiple reCAPTCHA on the same page for different forms
- Support multiple actions to be placed on the same page
- Support custom implementation on config interface
- Support custom implementation on request method interface 
- Support custom implementation on Template file


## Requirement

This package requires the following dependencies:

- Laravel 5.x 

- If you want to use Validation Class your Laravel version needs to be >= 5.5

- php > 5

- Please ensure that you have read basic information from Google reCAPTCHA v2.

## Installation


Via Composer

``` sh
        $ composer require timehunter/laravel-google-recaptcha-v2 "~1.0.0" -vvv
```

If your Laravel framework version <= 5.4, please register the service provider in your config file: /config/app.php, otherwise please skip it.


``` php
'providers'=[
    ....,
    TimeHunter\LaravelGoogleReCaptchaV2\Providers\GoogleReCaptchaV2ServiceProvider::class
]
```

And also
``` php
'aliases'=[
     ....,
     'GoogleReCaptchaV2'=> TimeHunter\LaravelGoogleReCaptchaV2\Facades\GoogleReCaptchaV2::class
 ]
```


If your Laravel framework version is >= 5.5, just run the following command to publish config.
```sh 
$ php artisan vendor:publish --provider="TimeHunter\LaravelGoogleReCaptchaV2\Providers\GoogleReCaptchaV2ServiceProvider" --tag=googlerecaptchav2.config
```

Optional: if you want to modify or customise your own template, you can publish a default view first, and change 'template' in config file:

```sh 
$ php artisan vendor:publish --provider="TimeHunter\LaravelGoogleReCaptchaV2\Providers\GoogleReCaptchaV2ServiceProvider" --tag=googlerecaptchav2.views
```

After installation, you should see a googlerecaptchav2/template.blade under views folder and googlerecaptchav2.php in your app/config folder.

## Basic Usage
#### Setting up your Google reCAPTCHA details in config file

Please register all details on host_name, site_key, secret_key and site_verify_url.

For more details please check comments in config file.

#### Display reCAPTCHA v2

Note: for styling with reCAPTCHA v2 badge, the official site does not support it. You can still customise it on its div element if you want.

##### Blade
Include div with an ID inside your form, e.g.

``` html  
 <div id="form_id_1"></div>
 <div id="form_id_2"></div>
```

Include Template script in your bottom/header of your page, e.g.

``` PHP  
 {!!  GoogleReCaptchaV2::render('form_id_1','form_id_2') !!}
```

##### Example Usage

``` html  
{{--if laravel version <=5.6, please use {{ csrf_field() }}--}}
<form method="POST" action="/verify">
    @csrf
    <div id="form_1_id"></div>
    <input type="submit" value="submit">
</form>

<form method="POST" action="/verify">
    @csrf
    <div id="form_2_id"></div>
    <input type="submit" value="submit">
</form>

{!!  GoogleReCaptchaV2::render('form_1_id','form_2_id') !!}

```

The backend request will receive a value for 'g-recaptcha-response', please take a look at Sample Use Case and Facade usage sections.

## Badge Display

Importance: you can always make your own template, just assign your template in config:

``` PHP
    [
        ...
        'template' => 'test.template' // if your template is located at resources/views/test/template
        ...
    ]
```

### Checkbox

1. Go to config file, and set 
``` PHP
    [
        ...
        'badge' => 'inline'
        ...
    ]
```
2. Badge will be displayed as checkbox format within the form.

### Invisible - inline

1. Set size as invisible
``` PHP
    [
        ...
        'size' => 'invisible'
        ...
    ]
```
2. Set badge as inline or bottomright or bottomleft
``` PHP
    [
        ...
        'badge' => 'inline' // also support: bottomright,bottomleft
        ...
    ]
```

### Invisible - hidden

1. Set size as invisible
``` PHP
    [
        ...
        'size' => 'invisible'
        ...
    ]
```
2. Modify your div with style display:none
3. Refer to Google official site: https://developers.google.com/recaptcha/docs/faq
, you need to include the following text:
 ``` HTML
    This site is protected by reCAPTCHA and the Google
        <a href="https://policies.google.com/privacy">Privacy Policy</a> and
        <a href="https://policies.google.com/terms">Terms of Service</a> apply.
 ```

### Corner

1. Set size as invisible
``` PHP
    [
        ...
        'size' => 'invisible'
        ...
    ]
```
2. Set badge as bottomright/bottomleft
``` PHP
    [
        ...
        'badge' => 'bottomright'
        ...
    ]
```

## Validation Class (Only support Laravel >= 5.5)
   
   You can use provided Validation object to verify your reCAPTCHA.
      
``` php
   use TimeHunter\LaravelGoogleReCaptchaV2\Validations\GoogleReCaptchaV2ValidationRule
   $rule = [
            'g-recaptcha-response' => [new GoogleReCaptchaV2ValidationRule()]
        ];
```
  
## Facade Usage

You can also directly use registered service by calling the following method.
- verifyResponse() which accepts the token value from your form. This return Google reCAPTCHA Response object.

``` php
   GoogleReCaptchaV2::verifyResponse($value, $ip=null);
```

Example Usage

``` php
   GoogleReCaptchaV2::verifyResponse($value,$ip)->getMessage();
   GoogleReCaptchaV2::verifyResponse($value)->isSuccess();
   GoogleReCaptchaV2::verifyResponse($value)->toArray();
```

``` php
   GoogleReCaptchaV2::verifyResponse($request->input('g-recaptcha-response'))->getMessage()
```

## Sample Use Case

1. Register your action in config, also enable score and set up your own site key and secret key:

2. Register two routes in web.php
``` php
Route::get('/index', 'ReCaptchaController@index');
Route::post('/verify', 'ReCaptchaController@verify');
```

3. Create two functions in controller:
``` php
    public function verify(Request $request)
    {
        dd(GoogleReCaptchaV2::verifyResponse($request->input('g-recaptcha-response'))->getMessage());
    }
    public function index(Request $request)
    {
        return view('index');    
   }
```

4. Create your form in index.blade.php:
``` html
{{--if laravel version <=5.6, please use {{ csrf_field() }}--}}

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

{!!  GoogleReCaptchaV2::render('contact_us_id','signup_id') !!}
```


## Advanced Usage

#### Custom implementation on Template
    
After publish views, a blade file created under googlerecaptchaV2, you can customise it and change template value in config file, e.g. if your template is saved in resources/views/test/template, you should put values as below:
``` PHP
    [
        ...
        'template' => 'test.template'
        ...
    ]
```


#### Custom implementation on Config
    
For some users, they might store the config details in their own storage e.g database. You can create your own class and implement:

```
TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\ReCaptchaConfigv2Interface
```

Remember to register it in your own service provider

``` php
     $this->app->bind(
                ReCaptchaConfigV2Interface::class,
                YourOwnCustomImplementation::class
            );
```

#### Custom implementation on Request method

The package has two default options to verify: Guzzle and Curl, if you want to use your own request method, You can create your own class and implement 
```
TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\RequestClientInterface
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
[ico-styleci]: https://github.styleci.io/repos/163373553/shield
[ico-unstable]: https://poser.pugx.org/timehunter/laravel-google-recaptcha-v2/v/unstable

[link-packagist]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v2
[link-downloads]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v2
[link-author]: https://github.com/ryandadeng
[link-coverage]: https://coveralls.io/github/RyanDaDeng/laravel-google-recaptcha-v2?branch=master
[link-build]: https://travis-ci.org/RyanDaDeng/laravel-google-recaptcha-v2
[link-styleci]: https://github.styleci.io/repos/163373553
[link-unstable]: https://packagist.org/packages/timehunter/laravel-google-recaptcha-v2

