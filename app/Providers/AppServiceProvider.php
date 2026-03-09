<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
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
        // Email Verification Mail
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage())
                ->subject('Verify Your Email')
                ->view('emails.email_verification', [
                    'url' => $url,
                    'user' => $notifiable
                ]);
        });

        // Forgot Password Mail
        ResetPassword::toMailUsing(function ($notifiable, $token) {

            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage())
                ->subject('Reset Your Password')
                ->view('emails.reset_password', [
                    'url' => $url,
                    'user' => $notifiable
                ]);
        });
        Schema::defaultStringLength(191);
    }
}
