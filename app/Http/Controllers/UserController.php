<?php

namespace App\Http\Controllers;

use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // show your magic here
    }

    public function show()
    {
        $data = User::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $username = $request->post('username');
        $name     = $request->post('name');
        $email    = $request->post('email');
        $password = $request->post('password');

        $this->validate($request, [
            'name'     => 'required|min:4',
            'email'    => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
        
        $user           = new User;
        $user->uuid     = Uuid::uuid4()->getHex();
        $user->username = $username;
        $user->name     = $name;
        $user->email    = $email;
        $user->password = Hash::make($password);

        if ($user->save()) {
            $response = [
                'error'   => false,
                'message' => 'Successfully created user account'
            ];
        } else {
            $response = [
                'error'   => true,
                'message' => 'Error when create new user'
            ];
        }
        return response()->json($response);
    }
}
