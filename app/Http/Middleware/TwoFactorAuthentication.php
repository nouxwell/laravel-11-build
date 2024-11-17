<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        // Eğer 2FA kapalıysa direkt giriş yap
        if (!$user->two_factor_enabled) {
            return $next($request);
        }

        // 2FA kodu doğrulaması gerekli
        $google2fa = new Google2FA();
        $otp = $request->input('2fa_code'); // API üzerinden gelen 2FA kodu

        if ($google2fa->verifyKey($user->two_factor_secret, $otp)) {
            return $next($request);
        }

        return response()->json(['error' => '2FA doğrulama kodu hatalı'], 403);
    }
}
