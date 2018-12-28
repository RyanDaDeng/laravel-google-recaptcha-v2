<?php

namespace TimeHunter\LaravelGoogleReCaptchaV2\Facades;

use Illuminate\Support\Facades\Facade;
use TimeHunter\LaravelGoogleReCaptchaV2\Core\GoogleReCaptchaV2Response;

/**
 * @method static GoogleReCaptchaV2Response verifyResponse($value, $ip = null)
 * @method static render(...$ids)
 * @see \TimeHunter\LaravelGoogleReCaptchaV2\GoogleReCaptchaV2
 */
class GoogleReCaptchaV2 extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GoogleReCaptchaV2';
    }
}
