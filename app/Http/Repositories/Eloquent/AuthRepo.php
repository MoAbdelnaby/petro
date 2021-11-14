<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\AuthRepoInterface;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthRepo extends AbstractRepo implements AuthRepoInterface
{
    use AuthenticatesUsers;

    protected function credentials(AuthLoginRequest $request)
    {
        return [
            'uid' => $request->get('username'),
            'password' => $request->get('password'),
        ];
    }

    public function username()
    {
        return 'username';
    }

    public function __construct()
    {

        parent::__construct(User::class);
        // ldap confing

    }

    public function login(AuthLoginRequest $request)
    {
        // ldap
        if (!Auth::attempt($this->credentials($request))) {
            // TODO:: try to log to local users
            return responseFail(__('auth.failed'));
        }
        // local login
        if (!auth()->user()->active) {
            // logout from web
            Auth::guard('web')->logout();
            throw new \Exception(__('auth.inactive'));
        }
        // if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        //     return responseFail(__('auth.failed'));
        // }

        $user = auth()->user();
        $role = $user->type;
        $tokenData = $user->createToken('My Token', [$role]);
        $token = $tokenData->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
            dd($token->expires_at);
        }
        if ($token->save()) {
            return [
                'access_token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'token_scope' => $token->scopes[0],
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
                'status_code' => 200
            ];
        }

        return null;
    }

    public function logout($request)
    {

        return $request->user()->token()->revoke();
    }

    public function currentUser($request)
    {
        return Auth::user();
    }
}
