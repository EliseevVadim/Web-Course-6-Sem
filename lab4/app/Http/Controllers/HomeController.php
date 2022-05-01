<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function openRegistrationPage()
    {
        return view('registerPage');
    }

    public function openAuthorizationPage()
    {
        return view('authorizationPage');
    }

    public function openHomePage()
    {
        $user = Auth::user();
        if (is_null($user))
            abort(404);
        $cart = Cart::where('user_id', '=', $user->id)
            ->get()
            ->first();
        $ordersCount = Order::where('cart_id', $cart->id)->count();
        return view('home', compact('user', 'ordersCount'));
    }

    public function openSettingsPage()
    {
        if (is_null(Auth::user()))
            abort(404);
        return view('settings');
    }

    public function openMenuPage()
    {
        if (is_null(Auth::user()))
            abort(404);
        $user = Auth::user();
        $cart = Cart::where('user_id', '=', $user->id)
            ->get()
            ->first();
        $ordersCount = Order::where('cart_id', $cart->id)->count();
        return view('menu', compact('user', 'ordersCount'));
    }

    public function openProductPage($id)
    {
        if (is_null(Auth::user()))
            abort(404);
        $user = Auth::user();
        $cart = Cart::where('user_id', '=', $user->id)
            ->get()
            ->first();
        $ordersCount = Order::where('cart_id', $cart->id)->count();
        return view('product', compact('id', 'user', 'ordersCount'));
    }

    public function openCartPage()
    {
        if (is_null(Auth::user()))
            abort(404);
        $user = Auth::user();
        $cart = Cart::where('user_id', '=', $user->id)
            ->get()
            ->first();
        $ordersCount = Order::where('cart_id', $cart->id)->count();
        return view('cart', compact('user', 'ordersCount'));
    }

    public function openNewsPage()
    {
        if (is_null(Auth::user()))
            abort(404);
        $user = Auth::user();
        return view('news', compact('user'));
    }

    public function openPostPage($id)
    {
        if (is_null(Auth::user()))
            abort(404);
        return view('post', compact('id'));
    }

    public function openCheckoutPage()
    {
        if (is_null(Auth::user()))
            abort(404);
        $user = Auth::user();
        $cart = Cart::where('user_id', '=', $user->id)
            ->get()
            ->first();
        $ordersCount = Order::where('cart_id', $cart->id)->count();
        return view('checkout', compact('user', 'ordersCount'));
    }

    public function processToHomePageAfterSocialAuth()
    {
        $socialUserObject = Session::get('social-data');
        return view('social-redirect-page', compact('socialUserObject'));
    }
}
