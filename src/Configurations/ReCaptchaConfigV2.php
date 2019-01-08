<?php

namespace TimeHunter\LaravelGoogleReCaptchaV2\Configurations;

use TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\ReCaptchaConfigV2Interface;

class ReCaptchaConfigV2 implements ReCaptchaConfigV2Interface
{
    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return config('googlerecaptchav2.request_method');
    }

    /**
     * @return string
     */
    public function isServiceEnabled()
    {
        return config('googlerecaptchav2.is_service_enabled');
    }

    /**
     * @return string
     */
    public function getSiteVerifyUrl()
    {
        return config('googlerecaptchav2.site_verify_url');
    }

    /**
     * @return string
     */
    public function getHostName()
    {
        return config('googlerecaptchav2.host_name');
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return config('googlerecaptchav2.secret_key');
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return config('googlerecaptchav2.site_key');
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return config('googlerecaptchav2.options');
    }

    /**
     * @return bool
     */
    public function isInline()
    {
        return config('googlerecaptchav2.inline');
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return config('googlerecaptchav2.language');
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return config('googlerecaptchav2.theme');
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        return config('googlerecaptchav2.badge');
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return config('googlerecaptchav2.size');
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return config('googlerecaptchav2.template');
    }
}
