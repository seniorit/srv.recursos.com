<?php

namespace App\Providers;

use Illuminate\Http\Request;
use App\Http\HttpHandler\ResponseHttp;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->singleton(ResponseHttp::class, function ($app) {
      return new ResponseHttp();
    });
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Schema::defaultStringLength(255);
    \Laravel\Sanctum\Sanctum::usePersonalAccessTokenModel(\App\Models\PersonalAccessToken::class);
    $this->utilitiesHelper();
    $this->rateLimiter();
  }


  public function utilitiesHelper(): void
  {
    require_once app_path('Utilities/AppHelper.php');
  }

  /**
   * Configure rate limiting for the application.
   *
   * This method defines a rate limiter for the 'api' named key,
   * allowing a maximum of 60 requests per minute. The rate limit
   * is applied based on the user's ID if authenticated, or the
   * client's IP address otherwise.
   */
  private function rateLimiter(): void
  {
    RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });
  }
}
