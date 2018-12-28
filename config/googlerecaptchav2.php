<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Request Method
    |--------------------------------------------------------------------------
    |
    | If not provided, will use curl as default.
    | Supported: "guzzle", "curl", if you want to use your own request method,
    | please read document.
    |
    */
    'request_method' => 'curl',

    /*
    |--------------------------------------------------------------------------
    | reCAPTCHA Template file
    |--------------------------------------------------------------------------
    | Type: string
    | Default: GoogleReCaptchaV2::googlerecaptchav2.template
    | If you want to customise your own template, you can change it.
    |
    */
    'template'=>'GoogleReCaptchaV2::googlerecaptchav2.template',

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable Service
    |--------------------------------------------------------------------------
    | Type: bool
    |
    | This option is used to disable/enable the service
    |
    | Supported: true, false
    |
    */
    'is_service_enabled' => true,
    /*
    |--------------------------------------------------------------------------
    | Host Name
    |--------------------------------------------------------------------------
    | Type: string
    | Default will be empty, assign value only if you want domain check with Google response
    | Google reCAPTCHA host name, https://www.google.com/recaptcha/admin
    |
    */
    'host_name' => '',
    /*
    |--------------------------------------------------------------------------
    | Secret Key
    |--------------------------------------------------------------------------
    | Type: string
    | Google reCAPTCHA credentials, https://www.google.com/recaptcha/admin
    |
    */
    'secret_key' => '',
    /*
    |--------------------------------------------------------------------------
    | Site Key
    |--------------------------------------------------------------------------
    | Type: string
    | Google reCAPTCHA credentials, https://www.google.com/recaptcha/admin
    |
    */
    'site_key' => '',

    /*
    |--------------------------------------------------------------------------
    | Badge Style
    |--------------------------------------------------------------------------
    | Type: string
    | Supported: bottomright,bottomleft,inline
    |   - if your size is invisible, you can use bottomright or bottomleft to adjust your badge location
    |
    */
    'badge' => 'inline',

    /*
    |--------------------------------------------------------------------------
    | Size
    |--------------------------------------------------------------------------
    | Type: string
    | supported: invisible
    | if your reCAPTCHA supports invisible, you can put 'invisible', otherwise leave it as empty string
    |
    */
    'size' => '',

    /*
    |--------------------------------------------------------------------------
    | Theme Style
    |--------------------------------------------------------------------------
    | Type: string
    | supported: dark, light
    |
    */
    'theme' => 'light',
    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    | Custom option field for your request setting, which will be used for RequestClientInterface
    |
    */
    'options' => [

    ],
    /*
    |--------------------------------------------------------------------------
    | Site Verify Url
    |--------------------------------------------------------------------------
    | Type: string
    | Google reCAPTCHA API
    */
    'site_verify_url' => 'https://www.google.com/recaptcha/api/siteverify',

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    | Type: string
    | https://developers.google.com/recaptcha/docs/language
    */
    'language' => 'en',
];
