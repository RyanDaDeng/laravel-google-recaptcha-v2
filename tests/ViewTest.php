<?php

namespace TimeHunter\Tests;

use PHPUnit\Framework\TestCase;
use TimeHunter\LaravelGoogleReCaptchaV2\GoogleReCaptchaV2;
use TimeHunter\LaravelGoogleReCaptchaV2\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV2\Configurations\ReCaptchaConfigV2;
use TimeHunter\LaravelGoogleReCaptchaV2\Services\GoogleReCaptchaV2Service;

class ViewTest extends TestCase
{
    public function testView()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(false);

        $clientStub = $this->createMock(GuzzleRequestClient::class);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $data = $service->render('contact_us_id');
        $this->assertEquals(null, $data);
    }

    public function testView2()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('getSiteKey')
            ->willReturn('test1');

        $configStub->method('isInline')
            ->willReturn(false);

        $configStub->method('getLanguage')
            ->willReturn('en');

        $clientStub = $this->createMock(GuzzleRequestClient::class);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $data = $service->prepareViewData(['contact_us_id']);

        $this->assertEquals('test1', $data['publicKey']);
        $this->assertEquals('contact_us_id', $data['ids'][0]);
        $this->assertEquals(false, $data['inline']);
        $this->assertEquals('en', $data['language']);
    }

    public function testView3()
    {
        // Create a stub for the SomeClass class.
        $configStub = $this->createMock(ReCaptchaConfigV2::class);

        // Configure the stub.
        $configStub->method('isServiceEnabled')
            ->willReturn(true);

        $configStub->method('getSiteKey')
            ->willReturn('test1');

        $configStub->method('isInline')
            ->willReturn(false);

        $configStub->method('getLanguage')
            ->willReturn('en');

        $clientStub = $this->createMock(GuzzleRequestClient::class);

        $_service = new GoogleReCaptchaV2Service($configStub, $clientStub);
        $service = new GoogleReCaptchaV2($_service);

        $data = $service->prepareViewData(['contact_us_id', 'contact_us_id2']);

        $this->assertEquals('test1', $data['publicKey']);
        $this->assertEquals('contact_us_id', $data['ids'][0]);
        $this->assertEquals('contact_us_id2', $data['ids'][1]);
        $this->assertEquals(false, $data['inline']);
        $this->assertEquals('en', $data['language']);
    }
}
