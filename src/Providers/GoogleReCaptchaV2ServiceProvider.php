<?php

namespace TimeHunter\LaravelGoogleReCaptchaV2\Providers;

use Illuminate\Support\ServiceProvider;
use TimeHunter\LaravelGoogleReCaptchaV2\GoogleReCaptchaV2;
use TimeHunter\LaravelGoogleReCaptchaV2\Core\CurlRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV2\Core\GuzzleRequestClient;
use TimeHunter\LaravelGoogleReCaptchaV2\Configurations\ReCaptchaConfigV2;
use TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\RequestClientInterface;
use TimeHunter\LaravelGoogleReCaptchaV2\Services\GoogleReCaptchaV2Service;
use TimeHunter\LaravelGoogleReCaptchaV2\Interfaces\ReCaptchaConfigV2Interface;

class GoogleReCaptchaV2ServiceProvider extends ServiceProvider
{
    // never defer the class, by default is false, but put here as a notice
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'GoogleReCaptchaV2');

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public function bindConfig()
    {
        $this->app->bind(
            ReCaptchaConfigV2Interface::class,
            ReCaptchaConfigV2::class
        );
    }

    /**
     * @param $method
     */
    public function bindRequest($method)
    {
        switch ($method) {
            case 'guzzle':
                $this->app->bind(
                    RequestClientInterface::class,
                    GuzzleRequestClient::class
                );
                break;
            case'curl':
                $this->app->bind(
                    RequestClientInterface::class,
                    CurlRequestClient::class
                );
                break;
            default:
                $this->app->bind(
                    RequestClientInterface::class,
                    CurlRequestClient::class
                );
                break;
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/googlerecaptchav2.php', 'googlerecaptchav2'
        );

        $laravel = app();
        $version = $laravel::VERSION;

        if (version_compare($version, '5.7.*') === 1 || version_compare($version, '5.6.*') === 1 || version_compare($version, '5.5.*') === 1) {
            if (! $this->app->has(ReCaptchaConfigV2Interface::class)) {
                $this->bindConfig();
            }
            // default strategy
            if (! $this->app->has(RequestClientInterface::class)) {
                switch ($this->app->get(ReCaptchaConfigV2Interface::class)->getRequestMethod()) {
                    case 'guzzle':
                        $this->app->bind(
                            RequestClientInterface::class,
                            GuzzleRequestClient::class
                        );
                        break;
                    case'curl':
                        $this->app->bind(
                            RequestClientInterface::class,
                            CurlRequestClient::class
                        );
                        break;
                    default:
                        $this->app->bind(
                            RequestClientInterface::class,
                            CurlRequestClient::class
                        );
                        break;
                }
            }
        } else {
            $this->bindConfig();
            $this->bindRequest(app(ReCaptchaConfigV2Interface::class)->getRequestMethod());
        }

        $this->app->bind('GoogleReCaptchaV2', function () {
            $service = new GoogleReCaptchaV2Service(app(ReCaptchaConfigV2Interface::class), app(RequestClientInterface::class));

            return new GoogleReCaptchaV2($service);
        });
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../../config/googlerecaptchav2.php' => config_path('googlerecaptchav2.php'),
        ], 'googlerecaptchav2.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../../resources/views' => base_path('resources/views'),
        ], 'googlerecaptchav2.views');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // define a list of provider names
        return [
            'GoogleReCaptchaV2',
        ];
    }
}
