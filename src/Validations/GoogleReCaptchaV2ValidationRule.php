<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 9/8/18
 * Time: 1:39 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV2\Validations;

use Illuminate\Contracts\Validation\ImplicitRule;
use TimeHunter\LaravelGoogleReCaptchaV2\Facades\GoogleReCaptchaV2;

class GoogleReCaptchaV2ValidationRule implements ImplicitRule
{
    protected $ip;
    protected $message;

    public function __construct()
    {
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = GoogleReCaptchaV2::verifyResponse($value, app('request')->getClientIp());
        $this->message = $response->getMessage();

        return $response->isSuccess();
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
