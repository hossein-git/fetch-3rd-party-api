<?php

namespace Modules\Company;

use Illuminate\Support\ServiceProvider;
use Modules\Company\Facades\CompanyFacade;
use Modules\Company\Services\CompanyService;


class CompanyServiceProvider extends ServiceProvider
{

    public function register()
    {
        CompanyFacade::shouldProxyTo(CompanyService::class);

    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
