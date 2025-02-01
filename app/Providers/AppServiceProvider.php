<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use PagSeguro\Library;
use PagSeguro\Configuration\Configure;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        Library::initialize();

        $sandbox = env('PAGSEGURO_SANDBOX', false);

        Configure::setEnvironment($sandbox ? 'sandbox' : 'production');

        Library::cmsVersion()->setName("Marketplace")->setRelease("1.0.0");
        Library::moduleVersion()->setName("Marketplace")->setRelease("1.0.0");
    }
}
