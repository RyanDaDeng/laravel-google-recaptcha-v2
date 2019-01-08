<?php
/**
 * Created by PhpStorm.
 * User: rayndeng
 * Date: 6/8/18
 * Time: 5:29 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV2;

use TimeHunter\LaravelGoogleReCaptchaV2\Core\GoogleReCaptchaV2Response;
use TimeHunter\LaravelGoogleReCaptchaV2\Services\GoogleReCaptchaV2Service;
use TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\ReCaptchaConfigV2Interface;

class GoogleReCaptchaV2
{
    /**
     * @var GoogleReCaptchaV2Service
     */
    private $service;

    /**
     * GoogleReCaptchaV2 constructor.
     * @param GoogleReCaptchaV2Service $service
     */
    public function __construct(GoogleReCaptchaV2Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $ids
     * @return array
     */
    public function prepareViewData($ids = [])
    {
        $data = [
            'publicKey' => $this->getConfig()->getSiteKey(),
            'ids' => $ids,
            'inline' => $this->getConfig()->isInline(),
            'language' => $this->getConfig()->getLanguage(),
            'theme' => $this->getConfig()->getTheme(),
            'badge' => $this->getConfig()->getBadge(),
            'size' => $this->getConfig()->getSize(),
        ];

        return $data;
    }

    /**
     * @param $ids
     * @return \Illuminate\Contracts\View\View|null
     */
    public function render(...$ids)
    {
        if (! $this->getConfig()->isServiceEnabled()) {
            return;
        }
        $data = $this->prepareViewData($ids);

        return app('view')->make($this->getConfig()->getTemplate(), $data);
    }

    /**
     * @param $response
     * @param null $ip
     * @return GoogleReCaptchaV2Response
     */
    public function verifyResponse($response, $ip = null)
    {
        return $this->service->verifyResponse($response, $ip);
    }

    /**
     * @return ReCaptchaConfigV2Interface
     */
    public function getConfig()
    {
        return $this->service->config;
    }
}
