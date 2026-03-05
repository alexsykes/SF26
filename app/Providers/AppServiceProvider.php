<?php

namespace App\Providers;

use App\Rules\ReCaptcha;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->validator->extend('google_recaptcha', function ($attribute, $value, $parameters, $validator) {
            $rule = new GoogleReCaptcha;

            //            dd($rule->validate($value));
            // Validate reCAPTCHA
            $rule->validate($attribute, $value, function ($message) use ($validator, $attribute) {
                $validator->errors()->add($attribute, $message);
            });

            // Return true to success
            return true;
        });
    }
}
