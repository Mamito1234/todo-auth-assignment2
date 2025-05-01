<?php

namespace App\Providers;

use App\Http\Responses\ConfirmPasswordViewResponse;
use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse as ConfirmPasswordViewResponseContract;
use Laravel\Fortify\Fortify;
// use App\Actions\Fortify\CustomAttemptToAuthenticate;
use App\Http\Responses\ViewResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginViewResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterViewResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse as VerifyEmailResponseContract;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $this->app->singleton(ConfirmPasswordViewResponseContract::class, ConfirmPasswordViewResponse::class);

    $this->app->singleton(LoginViewResponse::class, fn () => new ViewResponse('auth.login'));
    $this->app->singleton(RegisterViewResponse::class, fn () => new ViewResponse('auth.register'));
    $this->app->singleton(VerifyEmailViewResponse::class, fn () => new ViewResponse('auth.verify-email'));
}

     // public function register(): void
    // {
    //     $this->app->singleton(LoginResponseContract::class, LoginViewResponse::class);
    //     $this->app->singleton(RegisterResponseContract::class, RegisterViewResponse::class);
    //     $this->app->singleton(VerifyEmailResponseContract::class, VerifyEmailViewResponse::class);
    // }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        // Fortify::attemptToAuthenticateUsing(CustomAttemptToAuthenticate::class);

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::lower($request->input(Fortify::username())) . '|' . $request->ip();
            return Limit::perMinute(3)->by($throttleKey)->response(function () {
                return response('Too many login attempts. Please try again in 60 seconds.', 429);
            });
            // ->maxAttempts(3);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}














// namespace App\Providers;

// use Laravel\Fortify\Contracts\LoginViewResponse;
// use Laravel\Fortify\Contracts\RegisterViewResponse;
// use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
// // use Laravel\Fortify\Http\Responses\ViewResponse;
// use App\Http\Responses\ViewResponse;
// use App\Actions\Fortify\CreateNewUser;
// use App\Actions\Fortify\ResetUserPassword;
// use App\Actions\Fortify\UpdateUserPassword;
// use App\Actions\Fortify\UpdateUserProfileInformation;
// use Illuminate\Cache\RateLimiting\Limit;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\RateLimiter;
// use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Str;
// use Laravel\Fortify\Fortify;

// class FortifyServiceProvider extends ServiceProvider
// {
//     /**
//      * Register any application services.
//      */
//     public function register(): void
//     {
//         // Bind Fortify view responses
//         $this->app->singleton(LoginViewResponse::class, fn () => new ViewResponse('auth.login'));
//         $this->app->singleton(RegisterViewResponse::class, fn () => new ViewResponse('auth.register'));
//         $this->app->singleton(VerifyEmailViewResponse::class, fn () => new ViewResponse('auth.verify-email'));
//     }

//     /**
//      * Bootstrap any application services.
//      */
//     public function boot(): void
//     {
//         Fortify::createUsersUsing(CreateNewUser::class);
//         Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
//         Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
//         Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

//         Fortify::verifyEmailView(function () {
//             return view('auth.verify-email');
//         });

//         RateLimiter::for('login', function (Request $request) {
//             $throttleKey = Str::lower($request->input(Fortify::username())) . '|' . $request->ip();
//             return Limit::perMinute(1)->by($throttleKey)->response(function () {
//                 return response('Too many login attempts. Please try again in 60 seconds.', 429);
//             })->maxAttempts(3);
//         });

//         RateLimiter::for('two-factor', function (Request $request) {
//             return Limit::perMinute(5)->by($request->session()->get('login.id'));
//         });
//     }
// }





// namespace App\Providers;

// use Laravel\Fortify\Contracts\LoginViewResponse;
// use Laravel\Fortify\Contracts\RegisterViewResponse;
// use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
// use Laravel\Fortify\Http\Responses\ViewResponse;
// use App\Actions\Fortify\CreateNewUser;
// use App\Actions\Fortify\ResetUserPassword;
// use App\Actions\Fortify\UpdateUserPassword;
// use App\Actions\Fortify\UpdateUserProfileInformation;
// use Illuminate\Cache\RateLimiting\Limit;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\RateLimiter;
// use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Str;
// use Laravel\Fortify\Fortify;

// class FortifyServiceProvider extends ServiceProvider
// {
//     /**
//      * Register any application services.
//      */
//     public function register(): void
//     {
//         //
//     }

//     /**
//      * Bootstrap any application services.
//      */
//     public function boot(): void
//     {


//         $this->app->singleton(LoginViewResponse::class, fn () => new ViewResponse('auth.login'));
//         $this->app->singleton(RegisterViewResponse::class, function () {
//             return new ViewResponse('auth.register');
//         });
//         // Fix for VerifyEmailViewResponse not instantiable
//         $this->app->singleton(
//             VerifyEmailViewResponse::class,
//             fn () => new ViewResponse('auth.verify-email')
//         );

//         Fortify::createUsersUsing(CreateNewUser::class);
//         Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
//         Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
//         Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

//         Fortify::verifyEmailView(function () {
//             return view('auth.verify-email');
//         });

//         RateLimiter::for('login', function (Request $request) {
//             $throttleKey = Str::lower($request->input(Fortify::username())).'|'.$request->ip();

//             return Limit::perMinute(1)->by($throttleKey)->response(function () {
//                 return response('Too many login attempts. Please try again in 60 seconds.', 429);
//             })->maxAttempts(3);
//         });

//         RateLimiter::for('two-factor', function (Request $request) {
//             return Limit::perMinute(5)->by($request->session()->get('login.id'));
//         });
//     }
// }
