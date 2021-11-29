<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;


use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{

    

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->nombre.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function(Request $request){
           
            $user = User::where('nombreCompleto',$request->username)->first();
            
            if($user && ($request->password == $user->password)){
               
                return $user;

            }else{
                // Si los datos no son los correctos volvemos al login y mostramos un error
                
                throw ValidationException::withMessages([
                    Fortify::username() => trans('auth.failed'),
                ]);
               
            }
        });
        Fortify::registerView(function(){
            return view('auth.register');
        });
        Fortify::loginView(function () {
            return view('auth.login');
        });
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.passwords.email');
        });
        Fortify::resetPasswordView(function ($request) {
            return view('auth.passwords.reset', ['request' => $request]);
        });
        Fortify::verifyEmailView(function () {
            return view('auth.verify');
        });
        Fortify::confirmPasswordView(function () {
            return view('auth.passwords.confirm');
        });
    }
}
