<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('booking-create', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(
                fn (Request $request, array $headers) => back()->withErrors([
                    'rate_limit' => 'Terlalu banyak request. Silakan coba lagi dalam beberapa menit.',
                ])->withInput()->withHeaders($headers)
            );
        });

        RateLimiter::for('booking-action', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(
                fn (Request $request, array $headers) => back()->withErrors([
                    'rate_limit' => 'Terlalu banyak request. Silakan coba lagi dalam beberapa menit.',
                ])->withInput()->withHeaders($headers)
            );
        });

        RateLimiter::for('availability-check', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        RateLimiter::for('booking-pin-send', function (Request $request) {
            return Limit::perMinutes(5, 3)->by(
                $request->ip().'|'.mb_strtolower((string) $request->input('email', ''))
            )->response(
                fn (Request $request, array $headers) => back()->withErrors([
                    'rate_limit' => 'Terlalu banyak permintaan kode verifikasi. Silakan coba lagi dalam beberapa menit.',
                ])->withInput()->withHeaders($headers)
            );
        });

        RateLimiter::for('booking-pin-verify', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(
                fn (Request $request, array $headers) => back()->withErrors([
                    'rate_limit' => 'Terlalu banyak percobaan. Silakan coba lagi dalam beberapa menit.',
                ])->withInput()->withHeaders($headers)
            );
        });
    }
}
