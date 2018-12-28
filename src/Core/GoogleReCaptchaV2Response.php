<?php
/**
 * Created by PhpStorm.
 * User: dadeng
 * Date: 2018/11/22
 * Time: 下午11:46.
 */

namespace TimeHunter\LaravelGoogleReCaptchaV2\Core;

use Carbon\Carbon;

class GoogleReCaptchaV2Response
{
    const MISSING_INPUT_ERROR = 'Missing input response.';
    const ERROR_UNABLE_TO_VERIFY = 'Unable to verify.';
    const ERROR_HOSTNAME = 'Hostname does not match.';
    const ERROR_TIMEOUT = 'Timeout';

    protected $success;
    protected $challengeTs;
    protected $hostname;
    protected $errorCodes = [];
    protected $ip;
    protected $message;

    public function __construct($data, $ip, $message = '')
    {
        $this->success = isset($data['success']) ? $data['success'] : false;
        $this->challengeTs = isset($data['challenge_ts']) ? $data['challenge_ts'] : null;
        $this->hostname = isset($data['hostname']) ? $data['hostname'] : '';
        $this->errorCodes = isset($data['error-codes']) ? $data['error-codes'] : [];
        $this->ip = $ip;
        $this->message = $this->errorCodes ? $this->errorCodes[0] : $message;
    }

    /**
     * @param bool $value
     */
    public function setSuccess(bool $value)
    {
        $this->success = $value;
    }

    /**
     * @param string $value
     */
    public function setMessage(string $value)
    {
        $this->message = $value;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return Carbon
     */
    public function getChallengeTs()
    {
        return Carbon::parse($this->challengeTs);
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @return array
     */
    public function getErrorCodes()
    {
        return $this->errorCodes;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'success' => $this->success,
            'ip' => $this->ip,
            'challengeTs' => $this->challengeTs,
            'hostname' => $this->hostname,
            'errorCodes' => $this->errorCodes,
            'message' => $this->message,
        ];
    }
}
