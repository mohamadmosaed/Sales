<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            $subscription = Subscription::where('id', $user->subscription_id)
                ->where('end_date', '>', now())
                ->first();

            if ($subscription) {
                Auth::login($user);
                return redirect()->route('home');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'اشتراك منتهي برجاء تجديد الاشتراك.');
            }
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Invalid email or password.');
        }
    }

    }



