<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login'; // Default redirection URL

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle the user after authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function authenticated($request, $user)
    {
        if ($user->status != 1) {
            Auth::logout();
            return redirect('/login')->withErrors(['error' => 'Your account is inactive.']);
        }
    
        // Redirect based on user role
        switch ($user->role) {
            case 1:
                $this->redirectTo = '/admin';
                break;
            case 2:
                $this->redirectTo = '/manager';
                break;
            case 3:
                $this->redirectTo = '/user';
                break;
            case 4:
                $this->redirectTo = '/ceo';
                break;
            default:
                $this->redirectTo = '/login';
                break;
        }
    
        return redirect($this->redirectTo);
    }
    
    
}
