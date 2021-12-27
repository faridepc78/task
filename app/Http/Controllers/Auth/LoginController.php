<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function sendFailedLoginResponse(LoginRequest $request)
    {
        throw ValidationException::withMessages([
            'failed' => [trans('auth.failed')]
        ]);
    }

    protected function attemptLogin(LoginRequest $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), true
        );
    }

    protected function credentials(LoginRequest $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password
        ];
    }

    public function login(LoginRequest $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(LoginRequest $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : $this->redirectPath();
    }

    public function redirectPath()
    {
        $role = Auth::user()['role'];
        switch ($role) {
            case User::ADMIN:
                return redirect()->route('dashboard');
            case User::USER:
                return redirect()->route('home');
        }
    }
}
