<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SmtpSetting;
use Config;
use Illuminate\Support\Facades\Schema;
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
        try {
            if (class_exists('Illuminate\Support\Facades\Schema') &&
                \Illuminate\Support\Facades\Schema::hasTable('smtp_settings')) {

                $smtpsetting = \App\Models\SmtpSetting::first();

                if ($smtpsetting) {
                    $data = [
                        'driver' => $smtpsetting->mailer,
                        'host' => $smtpsetting->host,
                        'port' => $smtpsetting->port,
                        'username' => $smtpsetting->username,
                        'password' => $smtpsetting->password,
                        'encryption' => $smtpsetting->encryption,
                        'from' => [
                            'address' => $smtpsetting->from_address,
                            'name' => 'RealEstate'
                        ]
                    ];

                    Config::set('mail', $data);
                }
            }
        } catch (\Throwable $e) {
        // ne jamais casser l'app
        }
    }
}
