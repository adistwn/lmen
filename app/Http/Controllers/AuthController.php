<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->request = $request;
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function createJwt(User $user)
    {
        $payload = [
            'iss'      => "lumen-jwt",       // Issuer of the token
            'sub'      => $user->uuid,         // Subject of the token
            'username' => $user->username,   // Subject of the token
            'iat'      => time(),            // Time when JWT was issued. 
            'exp'      => time() + 86400     // Expiration time 86400 means 24 hours
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Check login
     *
     * @param Request $request
     * @return void
     */
    public function checkLogin(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json([
                'error'   => true,
                'message' => 'Username or password is wrong.'
            ], 400);
        }

        if (Hash::check($password, $user->password)) {

            $token = $this->createJwt($user);
            $user->token = $token;
            $user->save();

            return response()->json([
                'error'   => false,
                'message' => 'Login successfully',
                'data'    => [
                    'token' => $token
                ]
            ], 200);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Username or password is wrong.'
        ], 400);
    }

    
}
