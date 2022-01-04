<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $cart = Session::get('cart');
            if ($cart !== null){
                foreach ($cart as $Key => $value){
                    Cart::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $value['product_id'],
                        'product_name' => $value['product_name'],
                        'product_slug' => $value['product_slug'],
                        'quantity' => $value['quantity'],
                        'price' => $value['price'],
                        'att' => $value['att'],
                        'p' => $value['p'],
                        'category_id' => $value['category'],
                    ]);
                }
            }
            return redirect('/');
        }
        return redirect("login")->withErrors('Oppes! You have entered invalid credentials');
    }
}
