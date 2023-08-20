<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\SmtpSetting;

class SmtpConfigurationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->booted(function () {
            // Retrieve the SMTP configuration from the database
            $smtpConfiguration = SmtpSetting::find(1); // Replace 1 with the desired configuration ID

            // Set the SMTP configuration dynamically
            Config::set('mail.mailers.smtp.host', $smtpConfiguration->host);
            Config::set('mail.mailers.smtp.port', $smtpConfiguration->port);
            Config::set('mail.mailers.smtp.username', $smtpConfiguration->username);
            Config::set('mail.mailers.smtp.password', $smtpConfiguration->password);
            Config::set('mail.mailers.smtp.encryption', $smtpConfiguration->encryption);

            Config::set('mail.from.address', 'ishraq@yopmail.com');
            Config::set('mail.from.name', 'ishraq');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
