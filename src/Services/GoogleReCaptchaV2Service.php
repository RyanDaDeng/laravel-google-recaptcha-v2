<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2018/12/28
 * Time: 5:37 PM.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV2\Services;

use TimeHunter\LaravelGoogleReCaptchaV2\Core\GoogleReCaptchaV2Response;
use TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\RequestClientInterface;
use TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\ReCaptchaConfigV2Interface;

class GoogleReCaptchaV2Service
{
    public $config;
    public $requestClient;

    /**
     * GoogleReCaptchaV2Service constructor.
     * @param ReCaptchaConfigV2Interface $config
     * @param RequestClientInterface $requestClient
     */
    public function __construct(ReCaptchaConfigV2Interface $config, RequestClientInterface $requestClient)
    {
        $this->config = $config;
        $this->requestClient = $requestClient;
    }

    /**
     * @param $response
     * @param null $ip
     * @return GoogleReCaptchaV2Response
     */
    public function verifyResponse($response, $ip = null)
    {
        if (! $this->config->isServiceEnabled()) {
            $res = new GoogleReCaptchaV2Response([], $ip);
            $res->setSuccess(true);

            return $res;
        }

        if (empty($response)) {
            $res = new GoogleReCaptchaV2Response([], $ip, GoogleReCaptchaV2Response::MISSING_INPUT_ERROR);
            $res->setSuccess(false);

            return $res;
        }

        $verifiedResponse = $this->requestClient->post(
            $this->config->getSiteVerifyUrl(),
            [
                'secret' => $this->config->getSecretKey(),
                'remoteip' => $ip,
                'response' => $response,
            ],
            $this->config->getOptions()
        );

        if (is_null($verifiedResponse) || empty($verifiedResponse)) {
            return new GoogleReCaptchaV2Response([], $ip, GoogleReCaptchaV2Response::ERROR_UNABLE_TO_VERIFY);
        }

        $decodedResponse = json_decode($verifiedResponse, true);
        $rawResponse = new GoogleReCaptchaV2Response($decodedResponse, $ip);

        if ($rawResponse->isSuccess() === false) {
            return $rawResponse;
        }

        if (! empty($this->config->getHostName()) && strcasecmp($this->config->getHostName(), $rawResponse->getHostname()) !== 0) {
            $rawResponse->setMessage(GoogleReCaptchaV2Response::ERROR_HOSTNAME);
            $rawResponse->setSuccess(false);

            return $rawResponse;
        }

        $rawResponse->setSuccess(true);
        $rawResponse->setMessage('Successfully passed.');

        return $rawResponse;
    }

    /**
     * @return ReCaptchaConfigV2Interface
     */
    public function getConfig(): ReCaptchaConfigV2Interface
    {
        return $this->config;
    }

    /**
     * @return RequestClientInterface
     */
    public function getRequestClient(): RequestClientInterface
    {
        return $this->requestClient;
    }
}
