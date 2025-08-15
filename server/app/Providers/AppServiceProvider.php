<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\Payments\Contracts\PaymentProviderInterface;
use App\Services\Payments\StripeProviderService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->singleton(CartService::class, function ($app) {
            if ($user = $app->auth->user()) {
                $user->load([
                    'cart.stock'
                ]);
            }

            return new CartService($app->auth->user());
        });

        $this->app->singleton(PaymentProviderInterface::class, function () {
            return new StripeProviderService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Date::use(CarbonImmutable::class);
        Stripe::setApiKey(config('services.stripe.secret'));
    }
}
