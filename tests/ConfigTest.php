<?php

namespace TimeHunter\Tests\GoogleReCaptchaV2;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleReCaptchaV2\GoogleReCaptchaV2;
use TimeHunter\LaravelGoogleReCaptchaV2\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV2\Core\GoogleReCaptchaV2Response;
use TimeHunter\LaravelGoogleReCaptchaV2\Configurations\ReCaptchaConfigV2;
use TimeHunter\LaravelGoogleReCaptchaV2\Services\GoogleReCaptchaV2Service;

class ConfigTest extends TestCase
{
    public function testServiceDisabled()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(false);

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn(false);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);
        $response = $service->verifyResponse('test');
        $this->assertEquals(true, $response->isSuccess());
    }

    public function testMissingInput()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn(false);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $response = $service->verifyResponse(null);
        $this->assertEquals(false, $response->isSuccess());

        $response = $service->verifyResponse('');

        $this->assertEquals(false, $response->isSuccess());
    }

    public function testEmptyResponse()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = null;

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $response = $service->verifyResponse(null);
        $this->assertEquals(false, $response->isSuccess());
    }

    public function testFalseResponse()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{"success":false,"ip":"::1","challengeTs":null,"hostname":"","errorCodes":[],"message":"Missing input response."}';

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $response = $service->verifyResponse('test response');
        $this->assertEquals(false, $response->isSuccess());
    }

    public function testHostName1()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test"}';

        $configStub->method('getHostName')
            ->willReturn('wrong.test');

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $response = $service->verifyResponse('test response');

        $this->assertEquals(false, $response->isSuccess());
        $this->assertEquals(GoogleReCaptchaV2Response::ERROR_HOSTNAME, $response->getMessage());
    }

    public function testHostName2()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $testJson = '{ "success": true, "challenge_ts": "2018-12-25T03:35:32Z", "hostname": "ryandeng.test"}';

        $configStub->method('getHostName')
            ->willReturn('');

        $clientStub = $this->createMock(GuzzleRequestClient::class);
        $clientStub->method('post')
            ->willReturn($testJson);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $response = $service->verifyResponse('test response');

        $this->assertEquals(true, $response->isSuccess());
    }
}
