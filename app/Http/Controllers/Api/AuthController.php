<?php

namespace codeFin\Http\Controllers\Api;

use codeFin\Http\Controllers\Controller;
use codeFin\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lang;

class AuthController extends Controller {

    use AuthenticatesUsers;

    // metodo resposnsavel por criar o token
    public function accessToken(Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);


        //se o token for válido a $token fica já com o token, se não foi valido $token = null e não entra no if
        // Auth::guard('api') -> chama o drive de autenticação do ./config->auth.php
        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function refreshToken(Request $request) {
        $token = Auth::guard('api')->refresh();
        return $this->sendLoginResponse($request, $token);
    }

    protected function sendLoginResponse(Request $request, $token) {

        $this->clearLoginAttempts($request);

        return response()->json([
                    'token' => $token
        ]);
    }

    protected function sendLockoutResponse(Request $request) {
        $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return response()->json([
                    'message' => $message
                        ], 403);
    }

    protected function sendFailedLoginResponse(Request $request) {
        return response()->json([
                    'message' => Lang::get('auth.failed')
                        ], 400);  // código 400 as credenciais estao invalidas, 401 -> token expirado
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return Response
     */
    public function logout(Request $request) {
        Auth::guard('api')->logout();
        return response()->json([], 204);
    }

}
