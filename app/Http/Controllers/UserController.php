<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * Store a newly created user in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->formValidationError($validator->errors());
        }

        $token = null;

        try {
            if (!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return $this->formValidationError('Invalid email or password');
            }
        } catch (JWTException $e) {
            return $this->badRequest('Failed to create token');
        }

        return $this->okResponse('Logged in', ['token' => $token]);
    }
}
