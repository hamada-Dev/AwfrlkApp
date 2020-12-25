<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Socialite;

class LoginController extends Controller
{


    use AuthenticatesUsers {
        logout as performLogout;
    }


    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->back();
    }

    protected function authenticated(Request $request)
    {
        if (auth()->user()->group == 'admin') { // do your margic here
            return redirect()->route('home.index');
        }elseif(auth()->user()->group == 'user'){
            return redirect('api/category');
        }

        return redirect()->back();
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/website';
    //
    //    /**
    //     * @param string $redirectTo
    //     */
    //    public function setRedirectTo(string $redirectTo): void
    //    {
    //        $this->redirectTo = $redirectTo;
    //    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        Session::put('preUrl', URL::previous());
    }

    public function redirectTo()
    {
        return Session::get('preUrl') ? Session::get('preUrl') :   $this->redirectTo;
    }


    public function redirectToGoogle($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleGoogleCallback($provider)
    {
        try {

            $provider == 'twitter' ?
                $user = \Laravel\Socialite\Facades\Socialite::driver($provider)->user() :
                $user = \Laravel\Socialite\Facades\Socialite::driver($provider)->stateless()->user();


            $finduser = User::where('provider_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->route('home');
            } else {

                $newUser = User::create([
                    'name' => $user->name,
                    'email' =>  $provider == 'twitter' ? $user->nickname : $user->email,
                    'provider_id' => $user->id,
                    'api_token' => str_random(60),
                    'image' => $user->avatar,
                ]);

                Auth::login($newUser);

                return redirect()->route('home');
                //return redirect()->back();
            }
        } catch (Exception $e) {

            return redirect('auth/' . $provider);
        }
    }
}
