<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function login(LoginFormRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->errors(), 400);
        }

        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            $user = Auth::guard()->user();
            $user->generateToken();

            return $this->sendResponse($user->toArray(), 'Login OK.');
        }

        return $this->sendError('Login Error.', $request, 500);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard()->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return $this->sendResponse( 'User logged out');
    }
}
