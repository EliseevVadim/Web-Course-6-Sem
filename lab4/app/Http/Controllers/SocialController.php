<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $user = $this->findOrCreateUser($provider, $socialUser);
            Auth::login($user);
            $cart = Cart::where('user_id', $user->id)->get()->first();
            $socialUserObject = json_encode([
                'id' => $user->id,
                'token' => $user->apiToken,
                'name' => $user->name,
                'cart_id' => $cart->id
            ]);
            Session::put('social-data', $socialUserObject);
            return redirect()->route('home-social');
        }
        catch (\Exception $exception) {
            return redirect()->route('auth');
        }
    }

    public function findOrCreateUser($provider, $socialUser)
    {
        if ($user = $this->findUserBySocialId($provider, $socialUser->getId())) {
            $user->apiToken = $user->createToken('MyAuthApp')->plainTextToken;
            return $user;
        }
        if ($user = $this->findUserByEmail($provider, $socialUser->getEmail())) {
            $this->addSocialAccount($provider, $user, $socialUser);
            $user->apiToken = $user->createToken('MyAuthApp')->plainTextToken;
            return $user;
        }
        $user = User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'password' => bcrypt(Str::random(25)),
        ]);
        $this->addSocialAccount($provider, $user, $socialUser);
        $user->apiToken = $user->createToken('MyAuthApp')->plainTextToken;
        return $user;
    }

    public function findUserBySocialId($provider, $id)
    {
        $socialAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $id)
            ->first();
        return $socialAccount ? $socialAccount->user : false;
    }

    public function findUserByEmail($provider, $email)
    {
        return User::where('email', $email)->first();
    }

    public function addSocialAccount($provider, $user, $socialiteUser)
    {
        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
        ]);
        $cart = new Cart;
        $cart->user_id = $user->id;
        $cart->save();
    }
}
