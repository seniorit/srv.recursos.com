<?php

use App\Providers\AppServiceProvider;
use App\Providers\DatabaseServiceProvider;
use App\Providers\ExchangesServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;

return [
  AppServiceProvider::class,
  DatabaseServiceProvider::class,
  ExchangesServiceProvider::class,
  SanctumServiceProvider::class,
];
