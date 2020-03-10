<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')
        ->with(['hd' => 'http://127.0.0.1:8000'])
        //->setScopes(['read:user', 'public_repo'])
        ->redirect();
    }
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        print_r($user);

    }

    public function getGoogleUser()
    {
        $token = "ya29.a0Adw1xeUsZIukW2k7uuDFu0flfcwz0wmvn4bhsCVIWG9l9mik4nqQEvVbSdbtftJIEoHGFPeswFLURvhizLMAZNXza7T3mEDx9B6Jx5srpAADrtv-uHlEXgEdLTLhs74KvKu3ItztsCEHjAFc069aywve2YmwiPQag3o";
        $user = Socialite::driver('google')->userFromToken($token);

        print_r($user);


    }
}
