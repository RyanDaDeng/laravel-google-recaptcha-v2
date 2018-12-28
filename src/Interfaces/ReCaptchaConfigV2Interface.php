<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV2\Interfaces;

interface ReCaptchaConfigV2Interface
{
    /**
     * @return string
     */
    public function getRequestMethod();

    /**
     * @return bool
     */
    public function isServiceEnabled();

    /**
     * @return string
     */
    public function getSecretKey();

    /**
     * @return string
     */
    public function getSiteKey();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @return string
     */
    public function getSiteVerifyUrl();

    /**
     * @return string
     */
    public function getHostName();

    /**
     * @return bool
     */
    public function isInline();

    /**
     * @return string
     */
    public function getLanguage();

    /**
     * @return string
     */
    public function getTheme();

    /**
     * @return string
     */
    public function getBadge();

    /**
     * @return string
     */
    public function getSize();

    /**
     * @return string
     */
    public function getTemplate();
}
